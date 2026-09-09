<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $admin = User::updateOrCreate(['email' => 'admin@halo-it.test'], [
            'name' => 'HALO IT Admin',
            'password' => 'admin123',
            'email_verified_at' => now(),
        ]);
        $admin->forceFill(['role' => 'admin'])->save();

        $user = User::updateOrCreate(['email' => 'user@halo-it.test'], [
            'name' => 'HALO IT User',
            'password' => 'user123',
            'email_verified_at' => now(),
        ]);
        $user->forceFill(['role' => 'user'])->save();

        User::updateOrCreate(['email' => 'test@example.com'], [
            'name' => 'Test User',
            'password' => 'password',
            'email_verified_at' => now(),
        ]);

        foreach (
            [
                ['name' => 'Hardware', 'slug' => 'hardware', 'description' => 'Laptop, desktop, printer, dan perangkat fisik lainnya.'],
                ['name' => 'Software', 'slug' => 'software', 'description' => 'Aplikasi, akses lisensi, dan kendala sistem operasi.'],
                ['name' => 'Network', 'slug' => 'network', 'description' => 'Internet, Wi-Fi, VPN, dan konektivitas kantor.'],
                ['name' => 'Account & Access', 'slug' => 'account-access', 'description' => 'Akun, password, dan permintaan hak akses.'],
            ] as $category
        ) {
            Category::updateOrCreate(['slug' => $category['slug']], $category);
        }
    }
}
