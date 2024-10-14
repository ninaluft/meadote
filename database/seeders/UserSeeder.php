<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin users as ONG
        $admin1 = DB::table('users')->insertGetId([
            'user_type' => 'admin',
            'name' => 'Admin',
            'email' => 'admin@meadote.com',
            'password' => Hash::make('00000000'),
            'city' => 'Porto Alegre',
            'state' => 'RS',
            'cep' => '90010-001', // CEP válido de Porto Alegre, RS
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        $admin2 = DB::table('users')->insertGetId([
            'user_type' => 'admin',
            'name' => 'Sistema',
            'email' => 'sistema@meadote.com',
            'password' => Hash::make('00000000'),
            'city' => 'São Paulo',
            'state' => 'SP',
            'cep' => '01001-000', // CEP válido de São Paulo, SP
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        $ong1 = DB::table('users')->insertGetId([
            'user_type' => 'ong',
            'name' => 'ongpatinhas',
            'email' => 'ongpatinhas@ong.com',
            'password' => Hash::make('00000000'),
            'city' => 'Carazinho',
            'state' => 'RS',
            'cep' => '99500-000', // CEP válido de Carazinho, RS
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        $ong2 = DB::table('users')->insertGetId([
            'user_type' => 'ong',
            'name' => 'Resgate Felino',
            'email' => 'resgatefelino@ong.com',
            'password' => Hash::make('12345678'),
            'city' => 'Curitiba',
            'state' => 'PR',
            'cep' => '80010-000', // CEP válido de Curitiba, PR
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        $ong3 = DB::table('users')->insertGetId([
            'user_type' => 'ong',
            'name' => 'Cuidadores de Patas',
            'email' => 'cuidadorespatas@ong.com',
            'password' => Hash::make('87654321'),
            'city' => 'Florianópolis',
            'state' => 'SC',
            'cep' => '88010-001', // CEP válido de Florianópolis, SC
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        // Create ONG records for the users created above
        DB::table('ongs')->insert([
            [
                'user_id' => $admin1,
                'ong_name' => 'Admin ONG',
                'phone' => '123456789',
                'responsible_name' => 'Admin Responsible',
                'responsible_cpf' => '000.000.000-00',
                'cnpj' => '00.000.000/0000-00',
                'about_ong' => 'ONG administrada pelo Admin do sistema.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'user_id' => $admin2,
                'ong_name' => 'Sistema ONG',
                'phone' => '987654321',
                'responsible_name' => 'Sistema Responsible',
                'responsible_cpf' => '111.111.111-11',
                'cnpj' => '11.111.111/1111-11',
                'about_ong' => 'Usuário do sistema responsável por ações automatizadas.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'user_id' => $ong1,
                'ong_name' => 'ONG Patinhas do bem',
                'phone' => '5499887766',
                'responsible_name' => 'Marina Luft',
                'responsible_cpf' => '952.201.300-56',
                'cnpj' => '30.416.418/0001-45',
                'about_ong' => 'ONG Patinhas do Bem dedicada ao resgate de animais.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'user_id' => $ong2,
                'ong_name' => 'Resgate Felino',
                'phone' => '41999887766',
                'responsible_name' => 'Carlos Menezes',
                'responsible_cpf' => '4576.189.490-42',
                'cnpj' => '87.314.279/0001-66',
                'about_ong' => 'ONG especializada no resgate de felinos em Curitiba.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'user_id' => $ong3,
                'ong_name' => 'Cuidadores de Patas',
                'phone' => '4899887766',
                'responsible_name' => 'Ana Costa',
                'responsible_cpf' => '532.426.050-98',
                'cnpj' => '49.767.426/0001-64',
                'about_ong' => 'ONG que oferece abrigo e cuidados para animais resgatados em Florianópolis.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);

        // Create tutor users
        $tutor1 = DB::table('users')->insertGetId([
            'user_type' => 'tutor',
            'name' => 'João da Silva',
            'email' => 'joao.silva@meadote.com',
            'password' => Hash::make('00000000'),
            'city' => 'Não-Me-Toque',
            'state' => 'RS',
            'cep' => '99470-000', // CEP válido de Não-Me-Toque, RS
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        $tutor2 = DB::table('users')->insertGetId([
            'user_type' => 'tutor',
            'name' => 'ninaluft',
            'email' => 'ninaluft@gmail.com',
            'password' => Hash::make('00000000'),
            'city' => 'Passo Fundo',
            'state' => 'RS',
            'cep' => '99010-000', // CEP válido de Passo Fundo, RS
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        $tutor3 = DB::table('users')->insertGetId([
            'user_type' => 'tutor',
            'name' => 'Paula Souza',
            'email' => 'paula.souza@meadote.com',
            'password' => Hash::make('00000000'),
            'city' => 'Rio de Janeiro',
            'state' => 'RJ',
            'cep' => '20010-000', // CEP válido de Rio de Janeiro, RJ
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        $tutor4 = DB::table('users')->insertGetId([
            'user_type' => 'tutor',
            'name' => 'Carlos Dias',
            'email' => 'carlos.dias@meadote.com',
            'password' => Hash::make('00000000'),
            'city' => 'Belo Horizonte',
            'state' => 'MG',
            'cep' => '30110-001', // CEP válido de Belo Horizonte, MG
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        // Create Tutor records for the users created above
        DB::table('tutors')->insert([
            [
                'user_id' => $tutor1,
                'full_name' => 'João da Silva',
                'date_of_birth' => '1990-05-15',
                'temporary_housing' => true,
                'cpf' => '467.932.690-54',
                'about_me' => 'Amante dos animais e tutor dedicado.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'user_id' => $tutor2,
                'full_name' => 'Marina Luft',
                'date_of_birth' => '1989-11-14',
                'temporary_housing' => false,
                'cpf' => '374.472.860-95',
                'about_me' => 'Tenho experiência com cães e gatos e adoro ajudar.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'user_id' => $tutor3,
                'full_name' => 'Paula Souza',
                'date_of_birth' => '1991-08-22',
                'temporary_housing' => true,
                'cpf' => '492.525.600-92',
                'about_me' => 'Adoro cuidar de animais e oferecer lar temporário.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'user_id' => $tutor4,
                'full_name' => 'Carlos Dias',
                'date_of_birth' => '1987-02-10',
                'temporary_housing' => false,
                'cpf' => '547.374.050-27',
                'about_me' => 'Pai de dois cães resgatados, sempre disposto a ajudar.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
