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
        DB::unprepared("
            CREATE TRIGGER `tg_wallet_trans` AFTER INSERT ON `wallet_trans`
                FOR EACH ROW BEGIN

            DECLARE v_wallet_id BIGINT;
            DECLARE v_balance DECIMAL;
            DECLARE wallet_balance DECIMAL;
            DECLARE current_balance DECIMAL;
            DECLARE v_type VARCHAR(10);

            SET v_wallet_id = new.wallet_id;
            SET v_balance = new.balance;
            SET v_type = new.trans_type;

            SELECT balance INTO wallet_balance FROM wallets WHERE id = v_wallet_id;

            IF v_type = 'in' THEN
                SET current_balance = (wallet_balance + v_balance);
            ELSEIF v_type = 'out' THEN
                SET current_balance = (wallet_balance - v_balance);
            ELSE
                SET current_balance = wallet_balance;
            END IF;

            UPDATE wallets
            SET
                balance = current_balance,
                updated_at = CURRENT_TIMESTAMP
            WHERE id = v_wallet_id;

            END
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP TRIGGER IF EXISTS tg_wallet_trans');
    }
};
