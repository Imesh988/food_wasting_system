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
        Schema::create('items', function (Blueprint $table) {
            $table->id();
              if (!Schema::hasColumn('items','barcode')) $table->string('barcode')->nullable();
    if (!Schema::hasColumn('items','batch')) $table->string('batch')->nullable();
    if (!Schema::hasColumn('items','expiry_date')) $table->date('expiry_date')->nullable();
            $table->timestamps();
        });
    }

    
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
