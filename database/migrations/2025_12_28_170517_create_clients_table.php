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
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->string('civility')->nullable(); // Civilité (M., Mme, etc.)
            $table->string('company')->nullable(); // Société
            $table->string('last_name'); // Nom
            $table->string('first_name'); // Prénom
            $table->text('address')->nullable(); // Adresse postale
            $table->string('postal_code')->nullable(); // Code Postal
            $table->string('city')->nullable(); // Ville
            $table->string('country')->nullable(); // Pays
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
