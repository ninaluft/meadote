<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FaqSeeder extends Seeder
{
    public function run()
    {
        DB::table('faqs')->insert([
            [
                'content' => '
                    <div class="faq-container">
                        <ol class="faq-list">
                            <li class="faq-item">
                                <h3 class="faq-question" style="cursor: pointer;">O que é o MeAdote?</h3>
                                <div class="faq-answer" style="display:none; padding-left: 20px; margin-top: 10px;">
                                    O MeAdote é uma plataforma que facilita o processo de adoção de animais, conectando pessoas que desejam adotar com ONGs e tutores que disponibilizam animais para adoção.
                                </div>
                            </li>
                            <li class="faq-item">
                                <h3 class="faq-question" style="cursor: pointer;">Como posso me cadastrar?</h3>
                                <div class="faq-answer" style="display:none; padding-left: 20px; margin-top: 10px;">
                                    Para se cadastrar, basta acessar o site do MeAdote, clicar no botão de registro e preencher o formulário com seus dados pessoais. Você pode se cadastrar como tutor ou ONG.
                                </div>
                            </li>
                            <li class="faq-item">
                                <h3 class="faq-question" style="cursor: pointer;">Preciso pagar alguma taxa?</h3>
                                <div class="faq-answer" style="display:none; padding-left: 20px; margin-top: 10px;">
                                    Não, o MeAdote é uma plataforma gratuita tanto para quem deseja adotar quanto para quem está disponibilizando animais para adoção.
                                </div>
                            </li>
                            <li class="faq-item">
                                <h3 class="faq-question" style="cursor: pointer;">Quais os requisitos para adoção?</h3>
                                <div class="faq-answer" style="display:none; padding-left: 20px; margin-top: 10px;">
                                    Os requisitos para adoção podem variar, mas normalmente é necessário preencher um formulário de adoção, passar por uma entrevista e, em alguns casos, uma visita ao local onde o animal viverá.
                                </div>
                            </li>
                            <li class="faq-item">
                                <h3 class="faq-question" style="cursor: pointer;">Como posso entrar em contato com uma ONG?</h3>
                                <div class="faq-answer" style="display:none; padding-left: 20px; margin-top: 10px;">
                                    Você pode entrar em contato com uma ONG através da página de perfil da ONG no MeAdote. Lá você encontrará as informações de contato da organização e poderá enviar uma mensagem diretamente.
                                </div>
                            </li>
                            <li class="faq-item">
                                <h3 class="faq-question" style="cursor: pointer;">Posso me tornar voluntário?</h3>
                                <div class="faq-answer" style="display:none; padding-left: 20px; margin-top: 10px;">
                                    Sim! Muitas ONGs parceiras do MeAdote estão sempre à procura de voluntários. Entre em contato diretamente com a ONG para saber como você pode ajudar.
                                </div>
                            </li>
                            <li class="faq-item">
                                <h3 class="faq-question" style="cursor: pointer;">Posso doar para ajudar os animais?</h3>
                                <div class="faq-answer" style="display:none; padding-left: 20px; margin-top: 10px;">
                                    Sim! Você pode fazer doações diretamente para as ONGs parceiras através do MeAdote. Na página de cada ONG há um botão de doação para ajudar na manutenção dos animais e outras necessidades.
                                </div>
                            </li>
                            <li class="faq-item">
                                <h3 class="faq-question" style="cursor: pointer;">Como funciona o processo de adoção?</h3>
                                <div class="faq-answer" style="display:none; padding-left: 20px; margin-top: 10px;">
                                    O processo de adoção no MeAdote envolve encontrar um animal que você gostaria de adotar, preencher um formulário de adoção, passar por uma entrevista, e seguir os procedimentos da ONG ou tutor responsável pelo animal.
                                </div>
                            </li>

                        </ol>

                    </div>

                    <script>
                        document.addEventListener("DOMContentLoaded", function() {
                            document.querySelectorAll(".faq-question").forEach(function(item) {
                                item.addEventListener("click", function() {
                                    var answer = this.nextElementSibling;
                                    answer.style.display = answer.style.display === "none" ? "block" : "none";
                                });
                            });
                        });
                    </script>
                '
            ]
        ]);
    }
}
