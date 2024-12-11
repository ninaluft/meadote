
# 🐾 MeAdote

**MeAdote** é uma plataforma web desenvolvida para facilitar a adoção de animais, conectando ONGs, tutores e possíveis adotantes.

## 📋 Índice

- [🔧 Requisitos](#requisitos)
- [📦 Instalação](#instalação)
- [⚙️ Configuração](#configuração)
- [☁️ Armazenamento de Imagens com Cloudinary e Verificação com Clarifai](#armazenamento-de-imagens-com-cloudinary-e-verificação-com-clarifai)
- [💬 Configuração do Pusher para Mensagens em Tempo Real](#configuração-do-pusher-para-mensagens-em-tempo-real)
- [🚀 Como Executar](#como-executar)
- [🛠️ Rodando as Migrações](#rodando-as-migrações)

## 🔧 Requisitos

Antes de começar, certifique-se de ter as seguintes ferramentas instaladas em sua máquina:

- [Node.js](https://nodejs.org/) (versão LTS recomendada) 🟢
- [Composer](https://getcomposer.org/) 🛠️
- [PHP](https://www.php.net/downloads.php) (versão 8.0 ou superior) 💻
- [MySQL](https://www.mysql.com/downloads/) ou qualquer outro banco de dados compatível 🗄️
- [Git](https://git-scm.com/) 🧰

Além disso, é recomendado ter um ambiente local para desenvolvimento PHP, como:

- [XAMPP](https://www.apachefriends.org/index.html) 🐘 ou
- [Laragon](https://laragon.org/) ⚡

## 📦 Instalação

1. **Clone o repositório para a sua máquina local:**

   ```bash
   git clone https://github.com/ninaluft/meadote.git
   ```

2. **Navegue até o diretório do projeto:**

   ```bash
   cd meadote
   ```

3. **Instale as dependências PHP com o Composer:**

   ```bash
   composer install
   ```

4. **Instale as dependências JavaScript com o NPM:**

   ```bash
   npm install
   ```

## ⚙️ Configuração

5. **Crie uma cópia do arquivo `.env.example` e renomeie para `.env`:**

   ```bash
   cp .env.example .env
   ```

6. **Gere uma chave de aplicação Laravel:**

   ```bash
   php artisan key:generate
   ```

7. **Abra o arquivo `.env` e configure as informações do banco de dados:**

   ```env
   APP_URL=http://127.0.0.1:8000

   APP_LOCALE=pt_BR
   
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=meadote
   DB_USERNAME=seu_usuario
   DB_PASSWORD=sua_senha
   ```

8. **Configure outras variáveis, como o ambiente (`APP_ENV`), a URL da aplicação (`APP_URL`), etc., conforme necessário.**

## ☁️ Armazenamento de Imagens com Cloudinary e Verificação com Clarifai

O **MeAdote** utiliza o **Cloudinary** para armazenamento e gerenciamento de imagens na nuvem, e o **Clarifai** para verificação de segurança nas imagens. Esse sistema verifica se as imagens carregadas atendem aos requisitos de moderação, ajudando a manter a plataforma apropriada para todos os usuários.

### Configuração do Cloudinary e Clarifai

1. **Primeiro, crie uma conta no [Cloudinary](https://cloudinary.com/) e no [Clarifai](https://www.clarifai.com/).**
2. **Adicione suas credenciais no arquivo `.env`:**

   ```env
   FILESYSTEM_DISK=cloudinary

   CLOUDINARY_URL=cloudinary://<your_api_key>:<your_api_secret>@<your_cloud_name>
   CLARIFAI_API_KEY=your_clarifai_api_key
   ```

Com essa configuração, todas as imagens são carregadas diretamente para o Cloudinary. O Clarifai é utilizado automaticamente para avaliar o conteúdo das imagens antes de finalizarem o upload, removendo imagens que não estejam em conformidade com as diretrizes de segurança.

## 💬 Configuração do Pusher para Mensagens em Tempo Real

O **MeAdote** usa o **Pusher** para funcionalidades de mensagens e notificações em tempo real, proporcionando uma comunicação instantânea entre os usuários.

### Configuração do Pusher

1. **Crie uma conta no [Pusher](https://pusher.com/) e crie um novo aplicativo no painel de controle.**
2. **No arquivo `.env`, adicione as credenciais do Pusher:**

   ```env
   BROADCAST_DRIVER=pusher
   BROADCAST_CONNECTION=pusher

   PUSHER_APP_ID=your_pusher_app_id
   PUSHER_APP_KEY=your_pusher_app_key
   PUSHER_APP_SECRET=your_pusher_app_secret
   PUSHER_APP_CLUSTER=your_pusher_cluster
   ```

Com essas configurações, a plataforma estará pronta para enviar e receber notificações e mensagens em tempo real.

## 🚀 Como Executar

9. **Compile os arquivos front-end:**

   ```bash
   npm run dev
   ```

   Para compilar para produção:

   ```bash
   npm run build
   ```

10. **Inicie o servidor local Laravel:**

    ```bash
    php artisan serve
    ```

11. **Acesse a aplicação em seu navegador:**

    ```
    http://127.0.0.1:8000/
    ```

## 🛠️ Rodando as Migrações

Para criar as tabelas no banco de dados, execute as migrações:

```bash
php artisan migrate
```

Para popular o banco de dados:

```bash
php artisan db:seed 
```


http://ForTheBadge.com/images/badges/built-with-love.svg

---

Se tiver qualquer dúvida ou encontrar problemas, fique à vontade para entrar em contato!
