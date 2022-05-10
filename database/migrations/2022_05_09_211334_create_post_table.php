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
        Schema::create('post', function (Blueprint $table) {
            $table->id();
            $table->string('name',100)->nullable()->default('text');/*column:string*/
            $table->biginteger('category_id')->unsigned()->nullable();/*column:integer foranea de tabla categories */
            $table->text('description')->nullable();/* column:text para texarea */
            $table->enum('state',['post','no post'])->default('no_post'); /* opciones select */
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
        Schema::dropIfExists('post');
    }
};
