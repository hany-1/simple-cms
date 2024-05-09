<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('name')->nullable();
            $table->string('status')->nullable();
            $table->string('post_type')->nullable();
            $table->string('post_password')->nullable(); // can implement password lock feature
            $table->text('content')->nullable();
            $table->tinyInteger('comment_status')->nullable()->default(0);
            $table->bigInteger('author_id')->unsigned()->nullable();
            $table->bigInteger('parent_id')->unsigned()->nullable();
            $table->integer('menu_order')->nullable()->default(0);
            $table->string('post_mime_type')->nullable();
            $table->integer('comment_count')->nullable()->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
