<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('notes', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('content');
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->foreignId('user_id')
                ->constrained() //! sirve para crear la relacion con la tabla users, no es necesario especificar la tabla, laravel lo hace automaticamente
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreignId('category_id')
                ->nullable()
                ->constrained() //! sirve para crear la relacion con la tabla users, no es necesario especificar la tabla, laravel lo hace automaticamente
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notes');
    }
};
