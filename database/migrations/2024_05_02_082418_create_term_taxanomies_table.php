<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTermTaxanomiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('term_taxanomies', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('term_id')->unsigned()->nullable();
            $table->string('taxanomy')->nullable();
            $table->text('description')->nullable();
            $table->bigInteger('parent_id')->unsigned()->nullable();
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
        Schema::dropIfExists('term_taxanomies');
    }
}
