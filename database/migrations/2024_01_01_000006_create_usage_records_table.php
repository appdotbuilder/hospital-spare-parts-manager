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
        Schema::create('usage_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('spare_part_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->integer('quantity_used')->comment('Quantity used');
            $table->string('purpose')->comment('Purpose of usage');
            $table->text('notes')->nullable()->comment('Additional notes');
            $table->date('usage_date')->comment('Date of usage');
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending')->comment('Request status');
            $table->foreignId('approved_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('approved_at')->nullable()->comment('Approval timestamp');
            $table->timestamps();
            
            $table->index(['spare_part_id', 'usage_date']);
            $table->index('user_id');
            $table->index('status');
            $table->index('usage_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usage_records');
    }
};