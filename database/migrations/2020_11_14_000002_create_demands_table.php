<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDemandsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('demands', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id');
            $table->foreignId('executor_id');
            $table->foreignId('intermediary_id')->nullable();
            $table->enum('status', ['IN_SEARCH', 'IN_PROGRESS', 'COMPLETED', 'CANCELED'])->default('IN_SEARCH');
            $table->timestamps();

            $table->foreign('executor_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('intermediary_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('order_id')->references('id')->on('orders')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('demands');
    }
}
