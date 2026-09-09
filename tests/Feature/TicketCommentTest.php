<?php

use App\Models\Category;
use App\Models\Ticket;
use App\Models\User;

function commentTicket(User $owner): Ticket
{
    $category = Category::create(['name' => fake()->unique()->word(), 'slug' => fake()->unique()->slug()]);

    return Ticket::create([
        'ticket_number' => 'TCK-000010',
        'user_id' => $owner->id,
        'category_id' => $category->id,
        'subject' => 'Akses aplikasi bermasalah',
        'description' => 'Aplikasi tidak dapat dibuka dari perangkat kantor.',
        'priority' => 'Medium',
        'status' => 'Open',
    ]);
}

it('allows the ticket owner to add a public comment', function () {
    $user = User::factory()->create();
    $ticket = commentTicket($user);

    $this->actingAs($user)->post(route('tickets.comments.store', $ticket), [
        'comment' => 'Saya sudah mencoba login ulang.',
    ])->assertRedirect();

    $this->assertDatabaseHas('ticket_comments', [
        'ticket_id' => $ticket->id,
        'user_id' => $user->id,
        'comment' => 'Saya sudah mencoba login ulang.',
        'is_internal' => false,
    ]);
});

it('notifies every admin when a user adds a comment', function () {
    $user = User::factory()->create();
    $firstAdmin = User::factory()->create(['role' => 'admin']);
    $secondAdmin = User::factory()->create(['role' => 'admin']);
    $ticket = commentTicket($user);

    $this->actingAs($user)->post(route('tickets.comments.store', $ticket), [
        'comment' => 'Ada tambahan informasi untuk tim IT.',
    ])->assertRedirect();

    expect($firstAdmin->fresh()->unreadNotifications)->toHaveCount(1);
    expect($secondAdmin->fresh()->unreadNotifications)->toHaveCount(1);
    expect($firstAdmin->fresh()->unreadNotifications->first()->data['event'])->toBe('comment.created');

    $this->actingAs($firstAdmin)->getJson(route('notifications.feed'))
        ->assertOk()
        ->assertJsonPath('notifications.0.message', "Komentar baru pada tiket {$ticket->ticket_number} dari {$user->name}.");
});

it('keeps internal comments hidden from regular users', function () {
    $owner = User::factory()->create();
    $admin = User::factory()->create();
    $admin->forceFill(['role' => 'admin'])->save();
    $ticket = commentTicket($owner);

    $this->actingAs($admin)->post(route('tickets.comments.store', $ticket), [
        'comment' => 'Catatan internal untuk tim IT.',
        'is_internal' => true,
    ])->assertRedirect();

    expect($owner->fresh()->unreadNotifications)->toHaveCount(0);

    $this->actingAs($owner)->get(route('tickets.show', $ticket))
        ->assertDontSee('Catatan internal untuk tim IT.');

    $this->actingAs($admin)->get(route('admin.tickets.show', $ticket))
        ->assertSee('Catatan internal untuk tim IT.');
});
