
# 🐾 MeAdote

**MeAdote** é uma plataforma web desenvolvida para facilitar a adoção de animais, conectando ONGs, tutores e possíveis adotantes.

## 📋 Índice

- [🔧 Requisitos](#requisitos)
- [📦 Instalação](#instalação)
- [⚙️ Configuração](#configuração)
- [☁️ Escolha entre Disco Local e Cloudinary](#escolha-entre-disco-local-e-cloudinary)
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

## ☁️ Escolha entre Disco Local e Cloudinary

Para o armazenamento de imagens no **MeAdote**, você tem a opção de escolher entre salvar localmente ou usar o **Cloudinary**, uma plataforma de gerenciamento de imagens na nuvem. 

### Disco Local (Padrão)

Por padrão, as imagens serão armazenadas localmente no diretório `storage`. Isso é adequado para ambientes de desenvolvimento ou servidores que tenham espaço e infraestrutura para armazenamento local. Para usar o disco local, nenhuma configuração adicional é necessária além da configuração padrão no arquivo `.env`:

```env
FILESYSTEM_DISK=local
```

### Cloudinary

Se preferir usar um serviço de nuvem para armazenar as imagens, como o **Cloudinary**, você precisa configurar sua conta no Cloudinary e atualizar o arquivo `.env` com as credenciais fornecidas por eles.

1. **Primeiro, crie uma conta no [Cloudinary](https://cloudinary.com/).**
2. **Adicione suas credenciais no arquivo `.env`:**

   ```env
   FILESYSTEM_DISK=cloudinary

   CLOUDINARY_CLOUD_NAME=sua_cloud_name
   CLOUDINARY_API_KEY=sua_api_key
   CLOUDINARY_API_SECRET=seu_api_secret
   ```

### Alternando entre Local e Cloudinary

Você pode alternar facilmente entre o armazenamento local e o **Cloudinary** apenas mudando o valor da variável `FILESYSTEM_DISK` no arquivo `.env`. Por exemplo, para usar o disco local, defina:

```env
FILESYSTEM_DISK=local
```

E para usar o **Cloudinary**:

```env
FILESYSTEM_DISK=cloudinary
```

Essa flexibilidade permite que você escolha o melhor método de armazenamento com base nas suas necessidades e no ambiente em que está rodando a aplicação (desenvolvimento, produção, etc.).

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

---

Se tiver qualquer dúvida ou encontrar problemas, fique à vontade para entrar em contato!
