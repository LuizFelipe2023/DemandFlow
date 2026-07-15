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
        Schema::create('demand_histories', function (Blueprint $table) {
            $table->id();

            $table->foreignId('demand_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete(); 

            $table->string('type')
                ->default('COMMENT');

            $table->text('description');

            $table->string('user_name')
                ->nullable();

            $table->string('old_status')
                ->nullable();

            $table->string('new_status')
                ->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('demand_histories');
    }
};