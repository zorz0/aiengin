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
            $table->integer('id', true);
            $table->integer('tokens')->unsigned()->default(0);
            $table->integer('words_generated')->unsigned()->default(0);
            $table->decimal('balance', 10, 6)->default(0.000000);
            $table->boolean('banned')->default(0)->index();
            $table->string('session_id')->nullable();
            $table->string('name');
            $table->string('password');
            $table->string('email')->nullable()->unique();
            $table->boolean('email_verified')->default(0)->index();
            $table->string('email_verified_code')->nullable()->index();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('remember_token')->nullable();
            $table->string('logged_ip', 46)->nullable();
            $table->timestamp('last_activity')->nullable()->index();
            $table->timestamp('last_seen_notif')->nullable()->index();
            $table->timestamp('notification')->nullable();
            $table->timestamps();
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
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
