<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdoptionFormSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('adoption_forms')->insert([
            [
                'submitter_user_id' => 1,
                'submitter_name' => 'João da Silva',
                'pet_id' => 1,
                'pet_name' => 'Rex',
                'species' => 'dog',
                'responsible_user_id' => 3,
                'responsible_user_name' => 'ONG Patinhas do Bem',
                'cpf' => '123.456.789-00',
                'birth_date' => '1985-06-15',
                'cep' => '99470-000',
                'city' => 'Não-Me-Toque',
                'state' => 'RS',
                'street' => 'Rua Principal',
                'number' => '123',
                'complement' => 'Casa A',
                'neighborhood' => 'Centro',
                'phone' => '54999999999',
                'email' => 'joao.silva@example.com',
                'marital_status' => 'Casado',
                'profession' => 'Engenheiro',
                'residence_type' => 'house',
                'residence_ownership' => 'owned',
                'outdoor_space' => true,
                'safety_measures' => true,
                'number_of_residents' => 3,
                'has_children' => true,
                'children_details' => 'Dois filhos, 8 e 10 anos',
                'has_other_pets' => false,
                'other_pets_details' => null,
                'other_animals_pets' => null, // Certifique-se de que esse campo está presente e preenchido
                'adoption_reason' => 'Queremos um companheiro para a família.',
                'long_term_commitment' => true,
                'willing_to_castrate' => true,
                'accept_future_visits' => true,
                'declaration_of_truth' => true,
                'status' => 'pending',
                'is_read' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'submitter_user_id' => 2,
                'submitter_name' => 'Maria Oliveira',
                'pet_id' => 2,
                'pet_name' => 'Mia',
                'species' => 'cat',
                'responsible_user_id' => 3,
                'responsible_user_name' => 'ONG Patinhas do Bem',
                'cpf' => '987.654.321-00',
                'birth_date' => '1990-02-20',
                'cep' => '99010-000',
                'city' => 'Passo Fundo',
                'state' => 'RS',
                'street' => 'Rua das Flores',
                'number' => '45',
                'complement' => 'Apto 203',
                'neighborhood' => 'Jardim América',
                'phone' => '54988888888',
                'email' => 'maria.oliveira@example.com',
                'marital_status' => 'Solteira',
                'profession' => 'Professora',
                'residence_type' => 'apartment',
                'residence_ownership' => 'rented',
                'outdoor_space' => false,
                'safety_measures' => true,
                'number_of_residents' => 1,
                'has_children' => false,
                'children_details' => null,
                'has_other_pets' => true,
                'other_pets_details' => 'Um cachorro pequeno, muito dócil',
                'other_animals_pets' => null, // Certifique-se de que esse campo está presente e preenchido
                'adoption_reason' => 'Adoro gatos e quero dar uma nova chance a Mia.',
                'long_term_commitment' => true,
                'willing_to_castrate' => true,
                'accept_future_visits' => true,
                'declaration_of_truth' => true,
                'status' => 'approved',
                'is_read' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'submitter_user_id' => 3,
                'submitter_name' => 'Carlos Souza',
                'pet_id' => 3,
                'pet_name' => 'Thor',
                'species' => 'dog',
                'responsible_user_id' => 5,
                'responsible_user_name' => 'João da Silva',
                'cpf' => '111.222.333-44',
                'birth_date' => '1987-12-05',
                'cep' => '90010-001',
                'city' => 'Porto Alegre',
                'state' => 'RS',
                'street' => 'Av. Central',
                'number' => '456',
                'complement' => 'Casa B',
                'neighborhood' => 'Zona Sul',
                'phone' => '51999999999',
                'email' => 'carlos.souza@example.com',
                'marital_status' => 'Divorciado',
                'profession' => 'Designer',
                'residence_type' => 'house',
                'residence_ownership' => 'owned',
                'outdoor_space' => true,
                'safety_measures' => true,
                'number_of_residents' => 2,
                'has_children' => false,
                'children_details' => null,
                'has_other_pets' => false,
                'other_pets_details' => null,
                'other_animals_pets' => null, // Certifique-se de que esse campo está presente e preenchido
                'adoption_reason' => 'Sempre quis ter um cachorro grande para companhia.',
                'long_term_commitment' => true,
                'willing_to_castrate' => true,
                'accept_future_visits' => false,
                'declaration_of_truth' => true,
                'status' => 'rejected',
                'rejection_reason' => 'Não atende às exigências da ONG.',
                'is_read' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);



    }
}
