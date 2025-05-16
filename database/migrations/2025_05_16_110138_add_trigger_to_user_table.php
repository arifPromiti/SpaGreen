<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $this->down();
        DB::unprepared('
            CREATE TRIGGER `tg_create_wallet` AFTER INSERT ON `users`
                FOR EACH ROW BEGIN

            DECLARE v_user_id BIGINT;
            DECLARE v_wallet_id BIGINT;

            set v_user_id = new.id;
            SELECT id INTO v_wallet_id FROM wallets WHERE user_id = v_user_id;

            IF v_wallet_id is NULL THEN
                INSERT INTO wallets (user_id,created_at) VALUES (v_user_id,CURRENT_TIMESTAMP);
            END IF;

            END
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP TRIGGER IF EXISTS tg_create_wallet');
    }
};
