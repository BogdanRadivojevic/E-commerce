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
        Schema::create('product_services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('auth_user_id')->constrained('users')->onDelete('cascade');
            $table->string('device_name');
            $table->text('issue_description');
            $table->foreignId('service_user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->decimal('price', 10, 2)->nullable();
            $table->string('status')->default('pending'); // Default to 'pending'
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_services');
    }
};
