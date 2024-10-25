<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Posts do Admin
        DB::table('posts')->insert([

            [
                'user_id' => 1, // Admin
                'title' => 'Dicas para a Adaptação do Seu Novo Pet Adotado em Casa',
                'content' => '
                    <p>Adotar um animal de estimação é um ato de amor que muda a vida tanto para o pet quanto para a nova família. No entanto, a adaptação inicial do animal em um novo ambiente pode ser um pouco desafiadora. Aqui estão algumas dicas importantes para garantir que a transição seja tranquila e confortável para todos.</p>

                    <h3>1. Prepare um Espaço Seguro para o Pet</h3>
                    <p>Assim que chegar em casa, ofereça ao seu novo amigo um espaço dedicado onde ele possa se sentir seguro e confortável. Pode ser um canto da casa com uma caminha e alguns brinquedos. Isso ajuda o animal a ter um lugar onde se sentir protegido e à vontade.</p>

                    <h3>2. Respeite o Tempo do Pet</h3>
                    <p>Cada animal tem seu próprio ritmo de adaptação. Alguns se sentirão à vontade rapidamente, enquanto outros podem levar dias ou semanas. Seja paciente e respeite o tempo necessário para que seu novo amigo confie em você e se acostume ao novo lar.</p>

                    <h3>3. Estabeleça uma Rotina</h3>
                    <p>Rotinas ajudam os animais a se sentirem seguros. Defina horários regulares para alimentação, passeios e brincadeiras. Isso proporciona uma sensação de previsibilidade que os ajudará a entender o que esperar e se adaptar melhor ao ambiente.</p>

                    <h3>4. Apresentação Gradual aos Membros da Família</h3>
                    <p>Se você tem outros pets ou crianças em casa, apresente o novo membro da família de forma gradual. Faça apresentações calmas e monitoradas, permitindo que todos se acostumem uns com os outros aos poucos. Evite forçar o contato e sempre fique atento a sinais de desconforto.</p>

                    <h3>5. Use Reforço Positivo</h3>
                    <p>Sempre que o seu novo pet tiver um comportamento desejável, recompense-o com carinho, petiscos e elogios. Isso cria associações positivas com o novo ambiente e incentiva o bom comportamento.</p>

                    <h3>6. Envolva o Pet em Atividades Diárias</h3>
                    <p>Participar da rotina da casa ajuda o animal a se sentir parte da família. Inclua-o nas atividades diárias, como passeios no parque, momentos de relaxamento e até pequenos treinos de obediência. Isso fortalecerá o vínculo entre você e seu pet.</p>

                    <h3>7. Tenha Paciência com Pequenos Acidentes</h3>
                    <p>No início, é possível que ocorram pequenos acidentes, como xixi fora do lugar. Lembre-se de que seu novo amigo está se adaptando e pode estar confuso. Não o repreenda de forma severa. Ao invés disso, redirecione-o com calma e reforce positivamente o comportamento correto.</p>

                    <h3>8. Proporcione Enriquecimento Ambiental</h3>
                    <p>Brinquedos, arranhadores e até quebra-cabeças para animais são ótimas maneiras de manter o pet mentalmente estimulado. Isso não só os distrai, mas também ajuda a evitar comportamentos indesejados causados pelo tédio.</p>

                    <h3>9. Visite o Veterinário</h3>
                    <p>Agende uma consulta com um veterinário logo após a adoção para garantir que o seu pet está saudável. Essa também é uma ótima oportunidade para discutir questões sobre nutrição e cuidados preventivos.</p>

                    <h3>10. Muita Paciência e Amor</h3>
                    <p>A adaptação pode ser um processo que exige muita paciência. Lembre-se de que o seu novo pet precisa se sentir amado e seguro. Dê carinho, atenção e crie um ambiente cheio de afeto. Em pouco tempo, ele será parte da família.</p>

                    <p>Adotar um animal é um gesto incrível e, com essas dicas   <p>Adotar um animal é um gesto incrível e, com essas dicas, você estará mais preparado para garantir que seu novo amigo se adapte de forma tranquila e feliz ao novo lar. Lembre-se: cada animal é único, e o tempo de adaptação varia. Aproveite cada momento e celebre cada progresso que seu novo pet fizer!</p>

                    <p>Essas dicas podem ajudar a tornar a transição para o novo lar mais tranquila para seu pet adotado, garantindo que ele se sinta seguro e acolhido em sua nova família.</p>
                ',
                'image_path' => 'storage/posts/adaptation_tips.jpg', // Caminho para a imagem do post
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'user_id' => 1, // Admin
                'title' => 'Importância da Castração para o Controle Populacional de Animais',
                'content' => '
                    <p>A castração é uma das principais ferramentas no controle populacional de cães e gatos...</p>
                    <h3>1. Benefícios da Castração</h3>
                    <p>A castração evita a reprodução descontrolada e ajuda a prevenir problemas de saúde...</p>
                    <h3>2. Redução do Abandono</h3>
                    <p>A castração contribui para a redução do abandono de animais nas ruas...</p>
                    <p>Adotar medidas de controle populacional, como a castração, é uma responsabilidade de todos os tutores de animais...</p>
                ',
                'image_path' => 'storage/posts/castration_benefits.jpg', // Caminho para a imagem do post
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'user_id' => 1, // Admin
                'title' => 'Cuidados Essenciais para Manter seu Pet Feliz e Saudável',
                'content' => '
                    <p>Ter um pet é uma grande responsabilidade, mas também uma fonte imensa de alegria e companheirismo. Para garantir que seu amigo de quatro patas viva uma vida longa e saudável, é importante seguir alguns cuidados essenciais. Confira as principais dicas para cuidar bem do seu pet:</p>

                    <h3>1. Alimentação Balanceada</h3>
                    <p>A alimentação é a base para a saúde do seu pet. Certifique-se de oferecer uma dieta balanceada, com rações de qualidade que atendam às necessidades específicas do seu animal, de acordo com a idade, porte e raça. Evite alimentos humanos como chocolate, cebola e alho, que são tóxicos para os pets.</p>

                    <h3>2. Água Fresca Sempre Disponível</h3>
                    <p>Manter uma tigela com água fresca e limpa é essencial para a hidratação do seu pet. Troque a água várias vezes ao dia, especialmente em dias quentes, para garantir que seu amigo não fique desidratado.</p>

                    <h3>3. Exercícios e Atividades Físicas</h3>
                    <p>Os pets precisam se exercitar regularmente. Passeios diários ajudam não só a manter o peso ideal, mas também proporcionam estímulos mentais e previnem o estresse e o tédio. Gatos também se beneficiam de brincadeiras que estimulem seu instinto de caça, como brinquedos com penas e ratinhos de mentira.</p>

                    <h3>4. Cuidados com a Saúde</h3>
                    <p>Visitas regulares ao veterinário são fundamentais para garantir que seu pet esteja em boa saúde. Realize os check-ups anuais, mantenha as vacinas em dia e faça a vermifugação regularmente. O veterinário também poderá orientar sobre a necessidade de suplementos e outros cuidados especiais.</p>

                    <h3>5. Higiene e Bem-Estar</h3>
                    <p>Banhos e escovação são importantes para manter a pelagem do seu pet saudável e livre de parasitas. Cada animal tem suas particularidades - cães geralmente precisam de banhos mais frequentes do que gatos. A escovação, por outro lado, ajuda a remover pelos mortos e previne problemas como nós e acúmulo de sujeira.</p>

                    <h3>6. Atenção e Afeto</h3>
                    <p>Pets são animais sociais e precisam de atenção e carinho para se sentirem parte da família. Reserve um tempo todos os dias para brincar, acariciar e interagir com seu pet. Isso não só fortalece o vínculo entre vocês, mas também contribui para o bem-estar mental do animal.</p>

                    <h3>Conclusão</h3>
                    <p>Cuidar de um pet vai muito além de alimentá-lo e dar água. É necessário dedicação, amor e compromisso para garantir que ele seja feliz e saudável. Com esses cuidados básicos, seu amigo peludo certamente terá uma vida longa e cheia de bons momentos ao seu lado!</p>
                ',
                'image_path' => 'storage/posts/pet_care.jpg', // Caminho para a imagem do post
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);
    }
}
