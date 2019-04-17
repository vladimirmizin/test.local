<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAboutCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('about_comments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('parent_comment_id')->nullable();
            $table->integer('sub_comment_id')->nullable();
            $table->integer('flag')->nullable();
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
        Schema::dropIfExists('about_comments');
    }
}
