<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentmetasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('commentmetas', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('comment_id')->unsigned()->nullable();
            $table->string('meta_key')->nullable();
            $table->string('meta_value')->nullable();
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
        Schema::dropIfExists('commentmetas');
    }
}
