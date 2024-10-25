<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Pets for ONG Admin
        DB::table('pets')->insert([
            [
                'name' => 'Rex',
                'species' => 'dog',
                'specify_other' => null,
                'gender' => 'male',
                'age' => 'adult',
                'size' => 'medium',
                'is_neutered' => true,
                'special_conditions' => false,
                'special_conditions_description' => null,
                'description' => 'Um cachorro muito amigável e carinhoso.',
                'status' => 'available',
                'user_id' => 3,
                'photo_path' => 'storage/pets/rex.jpg',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Mia',
                'species' => 'cat',
                'specify_other' => null,
                'gender' => 'female',
                'age' => 'senior',
                'size' => 'small',
                'is_neutered' => true,
                'special_conditions' => true,
                'special_conditions_description' => 'Precisa de medicação diária para artrite.',
                'description' => 'Gato calmo e gosta de um ambiente tranquilo.',
                'status' => 'available',
                'user_id' => 3,
                'photo_path' => 'storage/pets/mia.jpg',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Bidu',
                'species' => 'dog',
                'specify_other' => null,
                'gender' => 'male',
                'age' => 'puppy',
                'size' => 'small',
                'is_neutered' => false,
                'special_conditions' => false,
                'special_conditions_description' => null,
                'description' => 'Filhote energético e brincalhão.',
                'status' => 'available',
                'user_id' => 3,
                'photo_path' => 'storage/pets/bidu.jpg',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Pé de Pano',
                'species' => 'other',
                'specify_other' => 'Cavalo',
                'gender' => 'male',
                'age' => 'adult',
                'size' => 'large',
                'is_neutered' => false,
                'special_conditions' => false,
                'special_conditions_description' => null,
                'description' => 'Cavalo gentil resgatado, precisa de um lar tranquilo.',
                'status' => 'available',
                'user_id' => 5,
                'photo_path' => 'storage/pets/pedepano.jpg',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);

        // Pets for Tutor João da Silva
        DB::table('pets')->insert([
            [
                'name' => 'Thor',
                'species' => 'dog',
                'specify_other' => null,
                'gender' => 'male',
                'age' => 'adult',
                'size' => 'large',
                'is_neutered' => true,
                'special_conditions' => false,
                'special_conditions_description' => null,
                'description' => 'Cachorro grande, adora correr e brincar no parque.',
                'status' => 'available',
                'user_id' => 5,
                'photo_path' => 'storage/pets/thor.jpg',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Luna',
                'species' => 'cat',
                'specify_other' => null,
                'gender' => 'female',
                'age' => 'puppy',
                'size' => 'small',
                'is_neutered' => false,
                'special_conditions' => true,
                'special_conditions_description' => 'Necessita de uma dieta especial.',
                'description' => 'Filhote carinhosa e muito curiosa.',
                'status' => 'available',
                'user_id' => 5,
                'photo_path' => 'storage/pets/luna.jpg',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);

        // Pets for Tutor Maria Oliveira
        DB::table('pets')->insert([
            [
                'name' => 'Max',
                'species' => 'dog',
                'specify_other' => null,
                'gender' => 'male',
                'age' => 'senior',
                'size' => 'medium',
                'is_neutered' => true,
                'special_conditions' => true,
                'special_conditions_description' => 'Precisa de remédios para o coração.',
                'description' => 'Cachorro idoso, muito tranquilo e companheiro.',
                'status' => 'available',
                'user_id' => 4,
                'photo_path' => 'storage/pets/max.jpg',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Bella',
                'species' => 'cat',
                'specify_other' => null,
                'gender' => 'female',
                'age' => 'adult',
                'size' => 'small',
                'is_neutered' => true,
                'special_conditions' => false,
                'special_conditions_description' => null,
                'description' => 'Gata adorável e adora ser acariciada.',
                'status' => 'available',
                'user_id' => 4,
                'photo_path' => 'storage/pets/bella.jpg',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Maple',
                'species' => 'other',
                'specify_other' => 'Coelho',
                'gender' => 'female',
                'age' => 'adult',
                'size' => 'small',
                'is_neutered' => false,
                'special_conditions' => true,
                'special_conditions_description' => 'Precisa de cuidados especiais com a dieta.',
                'description' => 'Coelha amorosa, precisa de um lar tranquilo e cuidados com a dieta.',
                'status' => 'available',
                'user_id' => 4,
                'photo_path' => 'storage/pets/maple.jpg',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);

        // Pets for ONG Amigos dos Animais
        DB::table('pets')->insert([
            [
                'name' => 'Lucky',
                'species' => 'dog',
                'specify_other' => null,
                'gender' => 'male',
                'age' => 'adult',
                'size' => 'medium',
                'is_neutered' => true,
                'special_conditions' => false,
                'special_conditions_description' => null,
                'description' => 'Cão resgatado, muito leal e cheio de energia.',
                'status' => 'available',
                'user_id' => 6,
                'photo_path' => 'storage/pets/lucky.jpg',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Simba',
                'species' => 'cat',
                'specify_other' => null,
                'gender' => 'male',
                'age' => 'adult',
                'size' => 'small',
                'is_neutered' => true,
                'special_conditions' => false,
                'special_conditions_description' => null,
                'description' => 'Gato independente e curioso, gosta de explorar.',
                'status' => 'available',
                'user_id' => 6,
                'photo_path' => 'storage/pets/simba.jpg',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);

        // Pet "Donatello"
        DB::table('pets')->insert([
            [
                'name' => 'Donatello',
                'species' => 'other',
                'specify_other' => 'Tartaruga',
                'gender' => 'male',
                'age' => 'adult',
                'size' => 'medium',
                'is_neutered' => false,
                'special_conditions' => false,
                'special_conditions_description' => null,
                'description' => 'Uma tartaruga tranquila que adora água.',
                'status' => 'available',
                'user_id' => 5,
                'photo_path' => 'storage/pets/donatello.jpg',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);
    }
}
