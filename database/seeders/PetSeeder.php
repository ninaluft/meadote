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
                'specify_other' => null, // Adicionando specify_other como null
                'gender' => 'male',
                'age' => 'adult',
                'size' => 'medium',
                'is_neutered' => true,
                'special_conditions' => false,
                'special_conditions_description' => null,
                'description' => 'Um cachorro muito amigável e carinhoso.',
                'status' => 'available',
                'user_id' => 3,
                'photo_path' => 'pets/rex.jpg',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Mia',
                'species' => 'cat',
                'specify_other' => null, // Adicionando specify_other como null
                'gender' => 'female',
                'age' => 'senior',
                'size' => 'small',
                'is_neutered' => true,
                'special_conditions' => true,
                'special_conditions_description' => 'Precisa de medicação diária para artrite.',
                'description' => 'Gato calmo e gosta de um ambiente tranquilo.',
                'status' => 'available',
                'user_id' => 3,
                'photo_path' => 'pets/mia.jpg',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Bidu',
                'species' => 'dog',
                'specify_other' => null, // Adicionando specify_other como null
                'gender' => 'male',
                'age' => 'puppy',
                'size' => 'small',
                'is_neutered' => false,
                'special_conditions' => false,
                'special_conditions_description' => null,
                'description' => 'Filhote energético e brincalhão.',
                'status' => 'available',
                'user_id' => 3,
                'photo_path' => 'pets/bidu.jpg',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Pé de Pano',
                'species' => 'other',
                'specify_other' => 'Cavalo', // Especificando a espécie como "Cavalo"
                'gender' => 'male',
                'age' => 'adult',
                'size' => 'large',
                'is_neutered' => false,
                'special_conditions' => false,
                'special_conditions_description' => null,
                'description' => 'Este é o Pé de Pano, um cavalo gentil que passou boa parte de sua vida como puxador de carroça, enfrentando jornadas exaustivas. Após ser resgatado, Valente finalmente recebeu o cuidado e o carinho que sempre mereceu. Hoje, ele está livre do trabalho pesado e precisa de um lar tranquilo onde possa viver o resto de seus dias em paz. Valente é dócil e adora interagir com pessoas, mas devido às condições de seus resgates e idade, ele já não pode mais realizar trabalhos físicos. Ele é perfeito para quem quer oferecer um ambiente seguro e amoroso, onde ele possa descansar e ser feliz.',
                'status' => 'available',
                'user_id' => 5,
                'photo_path' => 'pets/pedepano.jpg',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);

        // Pets for Tutor João da Silva
        DB::table('pets')->insert([
            [
                'name' => 'Thor',
                'species' => 'dog',
                'specify_other' => null, // Adicionando specify_other como null
                'gender' => 'male',
                'age' => 'adult',
                'size' => 'large',
                'is_neutered' => true,
                'special_conditions' => false,
                'special_conditions_description' => null,
                'description' => 'Cachorro grande, adora correr e brincar no parque.',
                'status' => 'available',
                'user_id' => 5,
                'photo_path' => 'pets/thor.jpg',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Luna',
                'species' => 'cat',
                'specify_other' => null, // Adicionando specify_other como null
                'gender' => 'female',
                'age' => 'puppy',
                'size' => 'small',
                'is_neutered' => false,
                'special_conditions' => true,
                'special_conditions_description' => 'Necessita de uma dieta especial.',
                'description' => 'Filhote carinhosa e muito curiosa.',
                'status' => 'available',
                'user_id' => 5,
                'photo_path' => 'pets/luna.jpg',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);

        // Pets for Tutor Maria Oliveira
        DB::table('pets')->insert([
            [
                'name' => 'Max',
                'species' => 'dog',
                'specify_other' => null, // Adicionando specify_other como null
                'gender' => 'male',
                'age' => 'senior',
                'size' => 'medium',
                'is_neutered' => true,
                'special_conditions' => true,
                'special_conditions_description' => 'Precisa de remédios para o coração.',
                'description' => 'Cachorro idoso, muito tranquilo e companheiro.',
                'status' => 'available',
                'user_id' => 4,
                'photo_path' => 'pets/max.jpg',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Bella',
                'species' => 'cat',
                'specify_other' => null, // Adicionando specify_other como null
                'gender' => 'female',
                'age' => 'adult',
                'size' => 'small',
                'is_neutered' => true,
                'special_conditions' => false,
                'special_conditions_description' => null,
                'description' => 'Gata adorável e adora ser acariciada.',
                'status' => 'available',
                'user_id' => 4,
                'photo_path' => 'pets/bella.jpg',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Amora',
                'species' => 'dog',
                'specify_other' => null,
                'gender' => 'female',
                'age' => 'puppy',
                'size' => 'medium',
                'is_neutered' => false,
                'special_conditions' => false,
                'special_conditions_description' => null,
                'description' => 'Filhote alegre e cheia de energia, ideal para uma família ativa.',
                'status' => 'available',
                'user_id' => 3, // ONG Patinhas do bem
                'photo_path' => 'pets/amora.jpg',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Tom',
                'species' => 'cat',
                'specify_other' => null,
                'gender' => 'male',
                'age' => 'adult',
                'size' => 'small',
                'is_neutered' => true,
                'special_conditions' => false,
                'special_conditions_description' => null,
                'description' => 'Gato tranquilo, gosta de ficar em locais calmos e adora receber carinho.',
                'status' => 'available',
                'user_id' => 5, // Tutor João da Silva
                'photo_path' => 'pets/tom.jpg',
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
                'description' => 'Coelha amorosa, precisa de um lar tranquilo e alguém que cuide de sua dieta específica.',
                'status' => 'available',
                'user_id' => 4, // Tutor Maria Oliveira
                'photo_path' => 'pets/maple.jpg',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);

        // Pet "Donatello"
        DB::table('pets')->insert([
            [
                'name' => 'Donatello',
                'species' => 'other',
                'specify_other' => 'Tartaruga', // Especificando a espécie como "Tartaruga"
                'gender' => 'male',
                'age' => 'adult',
                'size' => 'medium',
                'is_neutered' => false,
                'special_conditions' => false,
                'special_conditions_description' => null,
                'description' => 'Uma tartaruga tranquila que adora água.',
                'status' => 'available',
                'user_id' => 5,
                'photo_path' => 'pets/donatello.jpg',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);
    }
}
