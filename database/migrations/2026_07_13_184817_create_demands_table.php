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
        Schema::create('demands', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');

            $table->string('requester');

            $table->foreignId('responsible_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->string('system');
            $table->string('status');
            $table->string('priority');
            $table->date('demand_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('demands');
    }
};