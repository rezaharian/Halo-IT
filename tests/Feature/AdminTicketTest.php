<?php

use App\Models\Category;
use App\Models\Ticket;
use App\Models\User;

function adminUser(): User
{
    $user = User::factory()->create();
    $user->forceFill(['role' => 'admin'])->save();

    return $user->fresh();
}

function ticketFor(User $owner): Ticket
{
    $category = Category::create(['name' => fake()->unique()->word(), 'slug' => fake()->unique()->slug()]);

    return Ticket::create([
        'ticket_number' => 'TCK-000001',
        'user_id' => $owner->id,
        'category_id' => $category->id,
        'subject' => 'Printer berhenti bekerja',
        'description' => 'Printer tidak merespons permintaan cetak dari komputer.',
        'priority' => 'High',
        'status' => 'Open',
    ]);
}

it('redirects an admin to the admin dashboard after login', function () {
    $admin = adminUser();
    $admin->forceFill(['password' => bcrypt('password')])->save();

    $this->post(route('login'), [
        'email' => $admin->email,
        'password' => 'password',
    ])->assertRedirect(route('admin.dashboard'));
});

it('forbids a regular user from opening the admin dashboard', function () {
    $this->actingAs(User::factory()->create())
        ->get(route('admin.dashboard'))
        ->assertForbidden();
});

it('allows an admin to see all tickets and update their workflow', function () {
    $admin = adminUser();
    $owner = User::factory()->create();
    $ticket = ticketFor($owner);
    $category = Category::create(['name' => 'Network', 'slug' => 'network']);

    $this->actingAs($admin)->get(route('admin.tickets.index'))
        ->assertSee($ticket->ticket_number);

    $this->actingAs($admin)->put(route('admin.tickets.update', $ticket), [
        'category_id' => $category->id,
        'assigned_to' => $admin->id,
        'priority' => 'Urgent',
        'status' => 'In Progress',
    ])->assertRedirect(route('admin.tickets.show', $ticket));

    $ticket->refresh();

    expect($ticket->assigned_to)->toBe($admin->id);
    expect($ticket->priority)->toBe('Urgent');
    expect($ticket->status)->toBe('In Progress');
    expect($ticket->activities)->toHaveCount(4);
});

it('does not allow a regular user to update a ticket workflow', function () {
    $owner = User::factory()->create();
    $ticket = ticketFor($owner);

    $this->actingAs($owner)->put(route('admin.tickets.update', $ticket), [
        'category_id' => $ticket->category_id,
        'assigned_to' => null,
        'priority' => 'Low',
        'status' => 'Closed',
    ])->assertForbidden();

    expect($ticket->refresh()->status)->toBe('Open');
});
