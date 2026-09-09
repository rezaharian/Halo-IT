<?php

use App\Models\Category;
use App\Models\Ticket;
use App\Models\User;

it('redirects guests to login when viewing tickets', function () {
    $this->get(route('tickets.index'))
        ->assertRedirect(route('login'));
});

it('creates a ticket and redirects to its detail page', function () {
    $user = User::factory()->create();
    $category = Category::create(['name' => 'Hardware', 'slug' => 'hardware']);

    $response = $this->actingAs($user)->post(route('tickets.store'), [
        'category_id' => $category->id,
        'subject' => 'Laptop tidak bisa menyala',
        'description' => 'Laptop berhenti menyala setelah dihubungkan ke charger.',
        'priority' => 'High',
    ]);

    $ticket = Ticket::query()->firstOrFail();

    $response->assertRedirect(route('tickets.show', $ticket));
    $this->assertModelExists($ticket);
    expect($ticket->ticket_number)->toBe(sprintf('TCK-%06d', $ticket->id));
    expect($ticket->status)->toBe('Open');
});

it('rejects a ticket submitted with an inactive category', function () {
    $user = User::factory()->create();
    $category = Category::create(['name' => 'Legacy', 'slug' => 'legacy', 'is_active' => false]);

    $this->actingAs($user)->from(route('tickets.create'))->post(route('tickets.store'), [
        'category_id' => $category->id,
        'subject' => 'Permintaan bantuan',
        'description' => 'Deskripsi masalah yang cukup panjang.',
        'priority' => 'Medium',
    ])->assertRedirect(route('tickets.create'))
        ->assertSessionHasErrors('category_id');

    expect(Ticket::query()->count())->toBe(0);
});

it('hides another users ticket', function () {
    $owner = User::factory()->create();
    $viewer = User::factory()->create();
    $category = Category::create(['name' => 'Network', 'slug' => 'network']);
    $ticket = Ticket::create([
        'ticket_number' => 'TKT-PRIVATE1',
        'user_id' => $owner->id,
        'category_id' => $category->id,
        'subject' => 'Private request',
        'description' => 'This ticket belongs to another user.',
        'priority' => 'Low',
        'status' => 'Open',
    ]);

    $this->actingAs($viewer)->get(route('tickets.show', $ticket))->assertNotFound();
});

it('escapes ticket content in the detail page', function () {
    $user = User::factory()->create();
    $category = Category::create(['name' => 'Security', 'slug' => 'security']);
    $ticket = Ticket::create([
        'ticket_number' => 'TKT-ESCAPE1',
        'user_id' => $user->id,
        'category_id' => $category->id,
        'subject' => '<script>alert("xss")</script>',
        'description' => 'Description with <script>alert("xss")</script>.',
        'priority' => 'Urgent',
        'status' => 'Open',
    ]);

    $this->actingAs($user)->get(route('tickets.show', $ticket))
        ->assertSee('&lt;script&gt;', false)
        ->assertDontSee('<script>alert("xss")</script>', false);
});
