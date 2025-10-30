<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('food', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('owner_phone')->nullable(); 
            $table->date('expiry_date');
            $table->integer('quantity')->default(1);
            $table->text('notes')->nullable();

            
            $table->timestamp('sms_sent_on_qty_reached')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('food'); 
    }
};
