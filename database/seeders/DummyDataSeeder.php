<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DummyDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // buat 5 user baru
        $penulisUsers = User::factory(5)->create(['password'=> Hash::make('password')]);
        
        // berikan role penulis dan buatkan artikel untuk masing masing user
        foreach ($penulisUsers as $user) {
            
            // berikan role penulis
            $user->assignRole('penulis');

            // buat 5 artikel untuk user ini
            Post::factory(5)->create([
                'user_id' => $user->id
            ]);
        }

    }
}
