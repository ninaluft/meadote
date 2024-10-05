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
        // Eventos para a ONG Admin
        DB::table('ong_events')->insert([
            [
                'ong_id' => 1, // ONG Admin
                'title' => 'Feira de Adoção de Animais',
                'description' => 'Venha conhecer e adotar um novo amigo! Teremos vários cães e gatos esperando por um lar amoroso.',
                'event_date' => '2023-10-15',
                'event_time' => '10:00:00',
                'city' => 'Não-Me-Toque',
                'state' => 'RS',
                'cep' => '99470-000', // CEP válido de Não-Me-Toque, RS
                'location' => 'Praça Central, Não-Me-Toque - RS',
                'photo_path' => 'ong-events/feira.jpg', // Caminho para a foto do evento
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'ong_id' => 1, // ONG Admin
                'title' => 'Campanha de Vacinação Gratuita',
                'description' => 'Traga seu pet para uma campanha de vacinação gratuita! Todos os cães e gatos são bem-vindos.',
                'event_date' => '2024-11-01',
                'event_time' => '09:00:00',
                'city' => 'Não-Me-Toque',
                'state' => 'RS',
                'cep' => '99470-000', // CEP válido de Não-Me-Toque, RS
                'location' => 'Parque Municipal, Não-Me-Toque - RS',
                'photo_path' => 'ong-events/vacinacao.jpg', // Caminho para a foto do evento
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);

        // Eventos para a ONG Sistema
        DB::table('ong_events')->insert([
            [
                'ong_id' => 2, // ONG Sistema
                'title' => 'Encontro de Adoção com Palestras',
                'description' => 'Encontro especial com palestras sobre cuidados com pets e adoção responsável. Não perca!',
                'event_date' => '2024-12-05',
                'event_time' => '14:00:00',
                'city' => 'Passo Fundo',
                'state' => 'RS',
                'cep' => '99010-000', // CEP válido de Passo Fundo, RS
                'location' => 'Auditório Municipal, Passo Fundo - RS',
                'photo_path' => 'ong-events/adocao.jpg', // Caminho para a foto do evento
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'ong_id' => 2, // ONG Sistema
                'title' => 'Mutirão de Castração',
                'description' => 'Mutirão para castração de cães e gatos, com preços populares ou gratuitos para famílias de baixa renda.',
                'event_date' => '2023-12-12',
                'event_time' => '08:00:00',
                'city' => 'Carazinho',
                'state' => 'RS',
                'cep' => '99500-000', // CEP válido de Carazinho, RS
                'location' => 'Centro de Zoonoses, Carazinho - RS',
                'photo_path' => 'ong-events/mutirao_castracao.jpg', // Caminho para a foto do evento
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);
    }
}
