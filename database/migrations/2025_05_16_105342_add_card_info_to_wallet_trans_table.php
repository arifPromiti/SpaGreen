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
        Schema::table('wallet_trans', function (Blueprint $table) {
            $table->string('name')->nullable()->after('balance');
            $table->string('card_number')->nullable()->after('name');
            $table->string('card_exp_date')->nullable()->after('card_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('wallet_trans', function (Blueprint $table) {
            $table->dropColumn('name');
            $table->dropColumn('card_number');
            $table->dropColumn('card_exp_date');
        });
    }
};
