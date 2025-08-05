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
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('Supplier name');
            $table->string('code')->unique()->comment('Supplier code');
            $table->text('address')->nullable()->comment('Supplier address');
            $table->string('phone')->nullable()->comment('Phone number');
            $table->string('email')->nullable()->comment('Email address');
            $table->string('contact_person')->nullable()->comment('Contact person name');
            $table->enum('status', ['active', 'inactive'])->default('active')->comment('Supplier status');
            $table->timestamps();
            
            $table->index('name');
            $table->index('code');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('suppliers');
    }
};