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
    Schema::create('reservas', function (Blueprint $table) {
        $table->id();
        $table->string('nombre_huesped');
        $table->date('fecha_entrada');
        $table->date('fecha_salida');
        
        // Como son dos habitaciones, podemos guardarlo como un string o un enum
        $table->string('habitacion'); 
        
        // Guardamos el precio con decimales (8 dígitos en total, 2 decimales)
        $table->decimal('precio', 8, 2)->nullable(); 
        
        // Aquí diferenciamos si viene del Webhook o si la meten a mano
        $table->string('origen')->default('Manual'); // 'Booking' o 'Manual'
        
        // Campos extra que vienen genial para las reservas manuales
        $table->string('telefono')->nullable();
        $table->string('email')->nullable();
        $table->text('observaciones')->nullable();
        
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservas');
    }
};
