<?php

use App\Models\Category;
use App\Models\Ticket;
use App\Models\User;
use App\Notifications\TicketNotification;

it('stores a notification for admins when a user creates a ticket', function () {
    $user = User::factory()->create();
    $admin = User::factory()->create();
    $admin->forceFill(['role' => 'admin'])->save();
    $category = Category::create(['name' => 'Network', 'slug' => 'network']);

    $this->actingAs($user)->post(route('tickets.store'), [
        'category_id' => $category->id,
        'subject' => 'VPN tidak tersambung',
        'description' => 'Koneksi VPN gagal sejak pagi dan sudah dicoba ulang.',
        'priority' => 'High',
    ])->assertRedirect();

    expect($admin->fresh()->unreadNotifications)->toHaveCount(1);
    expect($admin->fresh()->unreadNotifications->first()->data['event'])->toBe('ticket.created');
});

it('returns unread notifications through the live feed and can mark them read', function () {
    $user = User::factory()->create();
    $category = Category::create(['name' => 'Software', 'slug' => 'software']);
    $ticket = Ticket::create([
        'ticket_number' => 'TCK-000099',
        'user_id' => $user->id,
        'category_id' => $category->id,
        'subject' => 'Aplikasi error',
        'description' => 'Aplikasi menampilkan error saat dibuka.',
        'priority' => 'Medium',
        'status' => 'Open',
    ]);
    $user->notify(new TicketNotification($ticket, 'ticket.updated', 'Tiket diperbarui.'));

    $feed = $this->actingAs($user)->getJson(route('notifications.feed'));
    $notificationId = $feed->json('notifications.0.id');

    $feed->assertOk()->assertJsonPath('notifications.0.message', 'Tiket diperbarui.');
    $this->actingAs($user)->postJson(route('notifications.read', $notificationId))->assertOk();
    expect($user->fresh()->unreadNotifications)->toHaveCount(0);
});
