<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTermRelationshipTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('term_relationship', function (Blueprint $table) {
            $table->foreignId('term_taxanomy_id');
            $table->foreignId('object_id');
            $table->integer('term_order')->nullable()->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('term_relationship');
    }
}
