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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            
            // 1. user_id (Foreign Key reference, linking to the 'users' table)
            // Assumes user_id is an unsigned BigInt, matching the default 'id' column type.
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); 
            
            // 2. amount (Decimal to handle currency)
            $table->decimal('amount', 10, 2); 
            
            // 3. payment_method, 4. status
            $table->string('payment_method');
            $table->string('status')->default('pending');
            
            // 5. transaction_id (Unique and nullable)
            $table->string('transaction_id')->unique()->nullable();
            
            // 6. created_at, 7. updated_at (Laravel default timestamps)
            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
