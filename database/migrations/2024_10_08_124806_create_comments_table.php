<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Relaciona com a tabela de usuários
            $table->foreignId('post_id')->constrained()->onDelete('cascade'); // Relaciona com a tabela de posts
            $table->text('content'); // O conteúdo do comentário
            $table->timestamps(); // Para registrar quando o comentário foi criado/atualizado
        });
    }

    public function down()
    {
        Schema::dropIfExists('comments');
    }

};
