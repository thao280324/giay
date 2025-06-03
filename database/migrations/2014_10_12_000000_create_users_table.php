<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            // Tạo cột id kiểu BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY
            $table->id();

            // Các cột dữ liệu khác
            $table->string('name');
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->string('password');

            // Cột level (kiểu TINYINT), mặc định = 0
            $table->tinyInteger('level')->default(0);

            // Thêm cột remember_token (nếu dùng authentication mặc định của Laravel)
            $table->rememberToken();

            // Thêm created_at và updated_at (TIMESTAMP)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
