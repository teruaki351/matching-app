<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('account', function (Blueprint $table) {
            // 数値系
            $table->unsignedSmallInteger('height_cm')->nullable()->after('location_pref'); // 身長(cm)
            $table->unsignedTinyInteger('age_years')->nullable()->after('height_cm');      // 年齢(歳) 0-255

            // 文字列系
            $table->string('blood_type', 3)->nullable()->after('age_years');               // A/B/O/AB 等
            $table->string('residence', 100)->nullable()->after('blood_type');             // 居住地（市区町村など自由入力）
            $table->string('hometown', 100)->nullable()->after('residence');               // 出身地
            $table->string('education', 30)->nullable()->after('hometown');                // 学歴（後述の候補をバリデで制御）
        });
    }

    public function down(): void
    {
        Schema::table('account', function (Blueprint $table) {
            $table->dropColumn([
                'height_cm', 'age_years', 'blood_type', 'residence', 'hometown', 'education'
            ]);
        });
    }
};
