<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('friends', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id', unsigned: true);
            $table->bigInteger('friend_id', unsigned: true);
            $table->boolean('status')->default(false);
            $table->timestamps();

//            $table->index(['user_id', 'friend_id']);

            $table->foreign('user_id')
                ->references('id')
                ->on('users');
            $table->foreign('friend_id')
                ->references('id')
                ->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('friends');
    }
};
