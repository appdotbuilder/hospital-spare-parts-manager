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
        Schema::create('spare_parts', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('Spare part name');
            $table->string('code')->unique()->comment('Spare part code');
            $table->integer('quantity')->default(0)->comment('Current stock quantity');
            $table->string('storage_location')->comment('Storage location');
            $table->decimal('price', 15, 2)->comment('Unit price');
            $table->integer('minimum_stock')->default(0)->comment('Minimum stock level');
            $table->foreignId('supplier_id')->nullable()->constrained()->onDelete('set null');
            $table->text('description')->nullable()->comment('Spare part description');
            $table->enum('status', ['active', 'inactive'])->default('active')->comment('Spare part status');
            $table->timestamps();
            
            $table->index('name');
            $table->index('code');
            $table->index('storage_location');
            $table->index('status');
            $table->index('quantity');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('spare_parts');
    }
};