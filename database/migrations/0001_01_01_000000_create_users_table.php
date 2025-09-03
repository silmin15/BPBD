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
        Schema::create('users', function (Blueprint $table) {
            $table->id();

            // Wajib
            $table->string('name');
            $table->string('email')->unique();

            // Akun langsung aktif & bisa dites
            $table->timestamp('email_verified_at')->nullable(); // akan kita isi saat create oleh Super Admin
            $table->string('password');                         // diisi manual oleh Super Admin

            // Profil tambahan (yang tadinya di migration kedua)
            $table->string('username')->nullable()->unique();
            $table->string('phone')->nullable();

            // Kontrol & audit ringan
            $table->boolean('is_active')->default(true);
            $table->boolean('must_change_password')->default(false); // kalau mau paksa ganti pass di login pertama, set true saat create
            $table->timestamp('last_login_at')->nullable();
            $table->string('last_login_ip')->nullable();

            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};