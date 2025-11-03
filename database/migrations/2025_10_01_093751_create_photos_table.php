<?php

// database/migrations/xxxx_xx_xx_xxxxxx_create_photos_table.php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends \Illuminate\Database\Migrations\Migration {
    public function up(): void {
        Schema::create('photos', function (Blueprint $table) {
            $table->id();
            // ← テーブル名が単数の 'account' なので注意
            $table->foreignId('account_id')->constrained('account')->cascadeOnDelete();
            $table->string('path');                       // storageの相対パス
            $table->unsignedTinyInteger('sort_order')->default(1);
            $table->boolean('is_primary')->default(false);
            $table->timestamps();
            $table->index(['account_id','sort_order']);
        });
    }
    public function down(): void { Schema::dropIfExists('photos'); }
};
