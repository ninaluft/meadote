<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Linhas de linguagem de validação
    |--------------------------------------------------------------------------
    |
    | As seguintes linhas de idioma contêm as mensagens de erro padrão usadas
    | pela classe de validação. Algumas dessas regras possuem várias versões,
    | como as regras de tamanho. Sinta-se à vontade para ajustar cada uma
    | dessas mensagens aqui.
    |
    */


    'accepted' => 'O campo :attribute deve ser aceito.',
    'accepted_if' => 'O campo :attribute deve ser aceito quando :other for :value.',
    'active_url' => 'O campo :attribute não contém um URL válido.',
    'after' => 'O campo :attribute deve conter uma data posterior a :date.',
    'after_or_equal' => 'O campo :attribute deve conter uma data posterior ou igual a :date.',
    'alpha' => 'O campo :attribute deve conter somente letras.',
    'alpha_dash' => 'O campo :attribute deve conter somente letras, números, traços e sublinhados.',
    'alpha_num' => 'O campo :attribute deve conter somente letras e números.',
    'array' => 'O campo :attribute deve ser um array.',
    'before' => 'O campo :attribute deve conter uma data anterior à :date.',
    'before_or_equal' => 'O campo :attribute deve conter uma data anterior ou igual à :date.',
    'between' => [
        'numeric' => 'O campo :attribute deve ter um valor entre :min e :max.',
        'file' => 'O arquivo :attribute deve ter entre :min e :max kilobytes.',
        'string' => 'O campo :attribute deve ter entre :min e :max caracteres.',
        'array' => 'O campo :attribute deve conter entre :min e :max itens.',
    ],
    'boolean' => 'O campo :attribute deve ser verdadeiro ou falso.',
    'confirmed' => 'A confirmação do campo :attribute não confere.',
    'current_password' => 'A senha está incorreta.',
    'date' => 'O campo :attribute não contém uma data válida.',
    'date_equals' => 'O campo :attribute deve ser uma data igual a :date.',
    'date_format' => 'A data informada para o campo :attribute não respeita o formato :format.',
    'different' => 'Os campos :attribute e :other devem ser diferentes.',
    'digits' => 'O campo :attribute deve conter :digits dígitos.',
    'digits_between' => 'O campo :attribute deve conter entre :min e :max dígitos.',
    'dimensions' => 'O campo :attribute tem dimensões de imagem inválidas.',
    'distinct' => 'O campo :attribute contém um valor duplicado.',
    'email' => 'O campo :attribute deve conter um endereço de email válido.',
    'ends_with' => 'O campo :attribute deve terminar com um dos seguintes valores: :values.',
    'exists' => 'O valor selecionado para o campo :attribute é inválido.',
    'file' => 'O campo :attribute deve conter um arquivo.',
    'filled' => 'O campo :attribute é obrigatório.',
    'gt' => [
        'numeric' => 'O campo :attribute deve ser maior que :value.',
        'file' => 'O arquivo :attribute deve ser maior que :value kilobytes.',
        'string' => 'O campo :attribute deve conter mais de :value caracteres.',
        'array' => 'O campo :attribute deve conter mais de :value itens.',
    ],
    'gte' => [
        'numeric' => 'O campo :attribute deve ser maior ou igual a :value.',
        'file' => 'O arquivo :attribute deve ser maior ou igual a :value kilobytes.',
        'string' => 'O campo :attribute deve conter :value ou mais caracteres.',
        'array' => 'O campo :attribute deve conter :value itens ou mais.',
    ],
    'image' => 'O campo :attribute deve conter uma imagem.',
    'in' => 'O campo :attribute não contém um valor válido.',
    'in_array' => 'O campo :attribute não existe em :other.',
    'integer' => 'O campo :attribute deve conter um número inteiro.',
    'ip' => 'O campo :attribute deve conter um IP válido.',
    'ipv4' => 'O campo :attribute deve conter um IPv4 válido.',
    'ipv6' => 'O campo :attribute deve conter um IPv6 válido.',
    'json' => 'O campo :attribute deve conter uma string JSON válida.',
    'lt' => [
        'numeric' => 'O campo :attribute deve ser menor que :value.',
        'file' => 'O arquivo :attribute deve ser menor que :value kilobytes.',
        'string' => 'O campo :attribute deve conter menos de :value caracteres.',
        'array' => 'O campo :attribute deve conter menos de :value itens.',
    ],
    'lte' => [
        'numeric' => 'O campo :attribute deve ser menor ou igual a :value.',
        'file' => 'O arquivo :attribute deve ser menor ou igual a :value kilobytes.',
        'string' => 'O campo :attribute deve conter :value ou menos caracteres.',
        'array' => 'O campo :attribute não deve conter mais que :value itens.',
    ],
    'max' => [
        'numeric' => 'O campo :attribute não pode ser superior a :max.',
        'file' => 'A foto não pode ter mais que :max kilobytes.',
        'string' => 'O campo :attribute não pode conter mais que :max caracteres.',
        'array' => 'O campo :attribute não pode conter mais que :max itens.',
    ],
    'mimes' => 'O campo :attribute deve conter um arquivo do tipo: :values.',
    'mimetypes' => 'O campo :attribute deve conter um arquivo do tipo: :values.',
    'min' => [
        'numeric' => 'O campo :attribute deve ter pelo menos :min.',
        'file' => 'O arquivo :attribute deve ter pelo menos :min kilobytes.',
        'string' => 'O campo :attribute deve conter pelo menos :min caracteres.',
        'array' => 'O campo :attribute deve conter pelo menos :min itens.',
    ],
    'multiple_of' => 'O campo :attribute deve ser um múltiplo de :value.',
    'not_in' => 'O valor selecionado para o campo :attribute é inválido.',
    'not_regex' => 'O formato do campo :attribute é inválido.',
    'numeric' => 'O campo :attribute deve conter um número.',
    'password' => 'A senha está incorreta.',
    'present' => 'O campo :attribute deve estar presente.',
    'prohibited' => 'O campo :attribute é proibido.',
    'prohibited_if' => 'O campo :attribute é proibido quando :other é :value.',
    'prohibited_unless' => 'O campo :attribute é proibido a menos que :other esteja em :values.',
    'prohibits' => 'O campo :attribute proíbe :other de estar presente.',
    'regex' => 'O formato do campo :attribute é inválido.',
    'required' => 'O campo :attribute é obrigatório.',
    'required_if' => 'O campo :attribute é obrigatório quando :other é :value.',
    'required_unless' => 'O campo :attribute é obrigatório a menos que :other esteja em :values.',
    'required_with' => 'O campo :attribute é obrigatório quando :values está presente.',
    'required_with_all' => 'O campo :attribute é obrigatório quando :values estão presentes.',
    'required_without' => 'O campo :attribute é obrigatório quando :values não está presente.',
    'required_without_all' => 'O campo :attribute é obrigatório quando nenhum dos :values estão presentes.',
    'same' => 'Os campos :attribute e :other devem corresponder.',
    'size' => [
        'numeric' => 'O campo :attribute deve ser :size.',
        'file' => 'O arquivo :attribute deve ter :size kilobytes.',
        'string' => 'O campo :attribute deve conter :size caracteres.',
        'array' => 'O campo :attribute deve conter :size itens.',
    ],
    'starts_with' => 'O campo :attribute deve começar com um dos seguintes valores: :values.',
    'string' => 'O campo :attribute deve ser uma string.',
    'timezone' => 'O campo :attribute deve ser um fuso horário válido.',
    'unique' => 'O valor informado para o campo :attribute já está em uso.',
    'uploaded' => 'Falha no upload do arquivo :attribute.',
    'url' => 'O formato da URL de :attribute é inválido.',
    'uuid' => 'O campo :attribute deve ser um UUID válido.',

    /*
    |--------------------------------------------------------------------------
    | Linhas de linguagem de validação customizadas
    |--------------------------------------------------------------------------
    |
    | Aqui você pode especificar mensagens de validação customizadas para atributos,
    | utilizando a convenção "attribute.rule" para nomear as linhas. Isso torna
    | rápido especificar uma linha de linguagem personalizada para uma regra
    | de atributo específica.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'mensagem-personalizada',
            'date_of_birth' => [
                'before' => 'O campo :attribute deve conter uma data anterior à :date.',
                'after' => 'O campo :attribute deve conter uma data posterior à :date.',

            ],


        ],
        'event_date' => [
            'after_or_equal' => 'A data do evento deve ser hoje ou uma data futura.',
        ],

    ],


    /*
    |--------------------------------------------------------------------------
    | Atributos de validação customizados
    |--------------------------------------------------------------------------
    |
    | As seguintes linhas de idioma são usadas para trocar os espaços reservados
    | do atributo por algo mais amigável ao leitor, como "Endereço de E-mail"
    | em vez de "email". Isso simplesmente nos ajuda a tornar nossa mensagem
    | mais expressiva.
    |
    */

    'attributes' => [
        'name' => 'nome de usuário',
        'email' => 'e-mail',
        'password' => 'senha',
        'password_confirmation' => 'confirmação de senha',
        'cpf' => 'CPF',
        'cnpj' => 'CNPJ',
        'temporary_housing' => 'lar temporário',
        'full_name' => 'nome completo',
        'date_of_birth' => 'data de nascimento',
        'ong_name' => 'nome da ONG',
        'responsible_name' => 'nome do responsável',
        'responsible_cpf' => 'CPF do responsável',
        'about_me' => 'sobre mim',
        'about_ong' => 'sobre a ONG',
        'phone' => 'telefone',
        'cep' => 'CEP',
        'city' => 'cidade',
        'state' => 'estado',
        'terms' => 'termos de serviço',
    ],



];
