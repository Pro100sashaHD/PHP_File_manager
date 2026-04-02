<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\File;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user1 = \App\Models\User::where('name', 'User1')->first();
        $user2 = \App\Models\User::where('name', 'User2')->first();
    
        if ($user1) {
            \App\Models\File::create([
                'name' => 'admin_report.pdf',
                'path' => 'uploads/admin_report.pdf',
                'mime_type' => 'application/pdf',
                'size' => 2048576,
                'user_id' => $user1->id,
            ]);
        }
    
        if ($user2) {
            \App\Models\File::create([
                'name' => 'my_notes.txt',
                'path' => 'uploads/my_notes.txt',
                'mime_type' => 'text/plain',
                'size' => 1024,
                'user_id' => $user2->id,
            ]);
        }
    }
}
