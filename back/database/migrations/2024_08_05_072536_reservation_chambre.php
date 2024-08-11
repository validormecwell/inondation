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
        Schema::create('reservation_chambres', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ID_Chambre')->constrained('chambres');
            $table->foreignId('type_Chambre')->constrained('chambres');
            $table->string('Nom_Client');
            $table->string('Telephone');
            $table->date('Date_Debut');
            $table->date('Date_Fin');
            $table->integer('Nombre_Nuits');
            $table->decimal('Prix_Total', 10, 2);
            $table->enum('Statut', ['libre', 'occuper']);
           // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('reservation_chambres', function (Blueprint $table) {
            $table->dropTimestamps(); // Supprime les colonnes created_at et updated_at
        });
    }
};
