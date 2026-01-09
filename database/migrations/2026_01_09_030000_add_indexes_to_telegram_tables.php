<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Índices para telegram_bots
        Schema::table('telegram_bots', function (Blueprint $table) {
            $table->index(['user_id', 'is_active']);
            $table->index(['user_id', 'created_at']);
        });

        // Índices para telegram_channels
        Schema::table('telegram_channels', function (Blueprint $table) {
            $table->index(['user_id', 'is_active']);
            $table->index(['user_id', 'created_at']);
        });

        // Índices para telegram_messages
        Schema::table('telegram_messages', function (Blueprint $table) {
            $table->index(['user_id', 'status']);
            $table->index(['user_id', 'created_at']);
            $table->index(['status', 'scheduled_at']);
        });
    }

    public function down(): void
    {
        Schema::table('telegram_bots', function (Blueprint $table) {
            $table->dropIndex(['user_id', 'is_active']);
            $table->dropIndex(['user_id', 'created_at']);
        });

        Schema::table('telegram_channels', function (Blueprint $table) {
            $table->dropIndex(['user_id', 'is_active']);
            $table->dropIndex(['user_id', 'created_at']);
        });

        Schema::table('telegram_messages', function (Blueprint $table) {
            $table->dropIndex(['user_id', 'status']);
            $table->dropIndex(['user_id', 'created_at']);
            $table->dropIndex(['status', 'scheduled_at']);
        });
    }
};
