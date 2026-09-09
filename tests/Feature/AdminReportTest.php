<?php

use App\Models\Category;
use App\Models\Ticket;
use App\Models\User;

it('shows the report to admins with aggregated ticket data', function () {
    $admin = User::factory()->create();
    $admin->forceFill(['role' => 'admin'])->save();
    $category = Category::create(['name' => 'Network', 'slug' => 'network']);
    Ticket::create([
        'ticket_number' => 'TCK-REPORT1',
        'user_id' => User::factory()->create()->id,
        'category_id' => $category->id,
        'subject' => 'Network issue',
        'description' => 'The office network is unavailable.',
        'priority' => 'Urgent',
        'status' => 'Open',
    ]);

    $this->actingAs($admin)->get(route('admin.reports.index', ['period' => 7]))
        ->assertOk()
        ->assertSee('Laporan bantuan IT')
        ->assertSee('Network')
        ->assertSee('Urgent')
        ->assertSee('Cetak / Simpan PDF')
        ->assertSee('Laporan Kinerja Helpdesk IT');
});

it('forbids regular users from viewing reports', function () {
    $this->actingAs(User::factory()->create())
        ->get(route('admin.reports.index'))
        ->assertForbidden();
});
