<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('messages')->insert([

            [
                'sender_id' => 3, // ONG Patinhas
                'recipient_id' => 5, // Tutor João da Silva
                'content' => 'Oi João, vi que você está interessado em adotar o Rex. Vamos conversar sobre isso!',
                'is_read' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'sender_id' => 5, // Tutor João da Silva
                'recipient_id' => 3, // ONG Patinhas
                'content' => 'Sim, eu gostaria muito de adotar o Rex! Ele parece incrível.',
                'is_read' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);
    }
}
