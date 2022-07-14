<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBloggerSupervisor extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blogger_supervisor', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('blogger_id');
            $table->unsignedInteger('supervisor_id');
            $table->foreign('blogger_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('supervisor_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('blogger_supervisor');
    }
}
