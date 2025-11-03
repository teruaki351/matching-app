<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends \Illuminate\Database\Migrations\Migration {
    public function up(): void {
        Schema::table('account', function (Blueprint $table) {
            $table->string('avatar_path')->nullable()->after('display_name');
        });
    }
    public function down(): void {
        Schema::table('account', function (Blueprint $table) {
            $table->dropColumn('avatar_path');
        });
    }
};
