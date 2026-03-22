<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->id();

            $table->string('code')->unique();
            $table->string('name');

            $table->enum('type', [
                'asset',
                'liability',
                'equity',
                'income',
                'expense'
            ]);

            $table->timestamps();

            $table->foreignId('parent_id')
                ->nullable()
                ->constrained('accounts')
                ->cascadeOnDelete();
        });

        // 🔥 Starter Data (แบบปลอดภัย)
        $now = now();

        $assetId = DB::table('accounts')->insertGetId([
            'code' => '1000',
            'name' => 'สินทรัพย์',
            'type' => 'asset',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        $liabilityId = DB::table('accounts')->insertGetId([
            'code' => '2000',
            'name' => 'หนี้สิน',
            'type' => 'liability',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        $equityId = DB::table('accounts')->insertGetId([
            'code' => '3000',
            'name' => 'ทุน',
            'type' => 'equity',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        $incomeId = DB::table('accounts')->insertGetId([
            'code' => '4000',
            'name' => 'รายได้',
            'type' => 'income',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        $expenseId = DB::table('accounts')->insertGetId([
            'code' => '5000',
            'name' => 'ค่าใช้จ่าย',
            'type' => 'expense',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        // 🔹 child
        DB::table('accounts')->insert([
            [
                'code' => '1100',
                'name' => 'เงินสด',
                'type' => 'asset',
                'parent_id' => $assetId,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'code' => '1200',
                'name' => 'เงินฝากธนาคาร',
                'type' => 'asset',
                'parent_id' => $assetId,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'code' => '2100',
                'name' => 'เจ้าหนี้การค้า',
                'type' => 'liability',
                'parent_id' => $liabilityId,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'code' => '4100',
                'name' => 'รายได้จากการขาย',
                'type' => 'income',
                'parent_id' => $incomeId,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'code' => '5100',
                'name' => 'ค่าใช้จ่ายทั่วไป',
                'type' => 'expense',
                'parent_id' => $expenseId,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accounts');
    }
}
