<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SupportRequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        DB::table('support_requests')->insert([
            [
                'user_id' => 3,
                'subject' => 'Dúvidas sobre como cadastrar um evento',
                'status' => 'closed',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'user_id' => 4,
                'subject' => 'Problema ao cadastrar um pet',
                'status' => 'open',
                'created_at' => Carbon::now()->subDays(2),
                'updated_at' => Carbon::now()->subDays(2),
            ],
        ]);

        // Associar mensagens às solicitações criadas
        DB::table('support_messages')->insert([
            [
                'support_request_id' => 1, // Referente à primeira solicitação (ONG Patinhas do bem)
                'user_id' => 3, // Usuário (ONG Patinhas do bem) enviando a mensagem
                'message' => 'Poderiam me orientar sobre como posso cadastrar um evento no sistema?',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'support_request_id' => 1, // Resposta do admin
                'user_id' => 1, // Admin respondendo
                'message' => 'Para cadastrar um evento, vá ao painel de administração, clique em "Eventos" e siga as instruções.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'support_request_id' => 2, // Referente à segunda solicitação (Outro usuário)
                'user_id' => 4, // Outro usuário (Tutor ou ONG)
                'message' => 'Estou tentando cadastrar um pet, mas o sistema apresenta erro.',
                'created_at' => Carbon::now()->subDays(2),
                'updated_at' => Carbon::now()->subDays(2),
            ],
            [
                'support_request_id' => 2, // Resposta do admin
                'user_id' => 1, // Admin respondendo
                'message' => 'Verifique se todos os campos obrigatórios foram preenchidos corretamente. Se o erro continuar, entre em contato novamente.',
                'created_at' => Carbon::now()->subDays(1),
                'updated_at' => Carbon::now()->subDays(1),
            ],
        ]);
    }
}
