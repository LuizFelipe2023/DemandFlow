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
        Schema::table('demands', function (Blueprint $table) {
            $table->boolean('is_audited')->default(false)->after('demand_date');
            $table->boolean('audit_approved')->nullable()->after('is_audited');
            $table->text('justification')->nullable()->after('audit_approved');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('demands', function (Blueprint $table) {
            $table->dropColumn([
                'is_audited',
                'audit_approved',
                'justification',
            ]);
        });
    }
};