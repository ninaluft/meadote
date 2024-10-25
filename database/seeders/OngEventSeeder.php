<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class OngEventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Atribua os IDs das ONGs criados no UserSeeder
        $ong1_id = DB::table('ongs')->where('ong_name', 'ONG Patinhas do bem')->value('id');
        $ong2_id = DB::table('ongs')->where('ong_name', 'Resgate Felino')->value('id');
        $ong3_id = DB::table('ongs')->where('ong_name', 'Cuidadores de Patas')->value('id');

        // Eventos para a ONG Patinhas do bem
        DB::table('ong_events')->insert([
            [
                'ong_id' => $ong1_id, // ONG Patinhas do bem
                'title' => 'Feira de Adoção de Animais',
                'description' => 'Venha conhecer e adotar um novo amigo! Teremos vários cães e gatos esperando por um lar amoroso.',
                'event_date' => '2023-10-15',
                'event_time' => '10:00:00',
                'city' => 'Não-Me-Toque',
                'state' => 'RS',
                'cep' => '99470-000',
                'location' => 'Praça Central, Não-Me-Toque - RS',
                'photo_path' => 'storage/ong-events/feira.webp',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'ong_id' => $ong1_id, // ONG Patinhas do bem
                'title' => 'Campanha de Vacinação Gratuita',
                'description' => 'Traga seu pet para uma campanha de vacinação gratuita! Todos os cães e gatos são bem-vindos.',
                'event_date' => '2024-11-01',
                'event_time' => '09:00:00',
                'city' => 'Não-Me-Toque',
                'state' => 'RS',
                'cep' => '99470-000',
                'location' => 'Parque Municipal, Não-Me-Toque - RS',
                'photo_path' => 'storage/ong-events/vacinacao.webp',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);

        // Eventos para a ONG Resgate Felino
        DB::table('ong_events')->insert([
            [
                'ong_id' => $ong2_id, // Resgate Felino
                'title' => 'Encontro de Adoção com Palestras',
                'description' => 'Encontro especial com palestras sobre cuidados com pets e adoção responsável. Não perca!',
                'event_date' => '2024-12-05',
                'event_time' => '14:00:00',
                'city' => 'Curitiba',
                'state' => 'PR',
                'cep' => '80010-000',
                'location' => 'Auditório Municipal, Curitiba - PR',
                'photo_path' => 'storage/ong-events/adocao.jpg',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'ong_id' => $ong3_id, // Cuidadores de Patas
                'title' => 'Mutirão de Castração',
                'description' => 'Mutirão para castração de cães e gatos, com preços populares ou gratuitos para famílias de baixa renda.',
                'event_date' => '2023-12-12',
                'event_time' => '08:00:00',
                'city' => 'Florianópolis',
                'state' => 'SC',
                'cep' => '88010-001',
                'location' => 'Centro de Zoonoses, Florianópolis - SC',
                'photo_path' => 'storage/ong-events/mutirao_castracao.jpeg',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);
    }
}
