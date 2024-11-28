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
        Schema::table('users', function (Blueprint $table) {
        DB::statement("INSERT INTO `users` (`id`, `name`, `username`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
        (1, 'root', 'root', 'admin@root.com', NULL, '$2y$12\$QSyWfFxOAerWrHCRboBREupB8WMN6Nhx6DBQP0d4El3VZJWm8yXz2', 'soz3yLbcYdOAjiCPYzBEHuMpn15yeiX5ilAqDdTQDJGzYL5bNN3wdjNDqGe7', '2024-11-24 14:15:21', '2024-11-24 14:15:21')");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('users')->truncate();
    }
};
