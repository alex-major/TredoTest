<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserDevice;
use App\Models\Notification;
use App\Models\History;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(10)->hasUserDevice(1)->create();
		
		Notification::factory(30)->create();
		
		History::factory(60)->hasUser(1)->hasNotification(1)->create();

        /* User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]); */
    }
}
