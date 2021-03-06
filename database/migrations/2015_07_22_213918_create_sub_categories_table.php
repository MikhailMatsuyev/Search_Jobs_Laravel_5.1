<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sub_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('parent_id');
            $table->integer('priority');
            $table->string('title');
            $table->string('slug');
            $table->string('scroll_type');
            $table->tinyInteger('show_in_menu');
            $table->tinyInteger('show_in_sidebar');
            $table->tinyInteger('show_in_footer');
            $table->string('seo_keywords');
            $table->text('seo_description');
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
        Schema::dropIfExists("sub_categories");
    }
}
