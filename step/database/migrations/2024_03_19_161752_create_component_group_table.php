<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComponentGroupTable extends Migration
{
    public function up()
    {
        Schema::create('component_group', function (Blueprint $table) {
            $table->foreignId('component_id')->constrained('components')->onDelete('cascade');
            $table->foreignId('group_id')->constrained('groups')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('component_group');
    }
}
