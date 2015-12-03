<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdRetailerCitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ad_retailer_cities', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('ad_retailer_id')->unsigned();
            $table->integer('ad_city_id')->unsigned();
            $table->boolean('active')->default(false);
            $table->timestamps();

            $table->foreign('ad_retailer_id')->references('id')->on('ad_retailers');
            $table->foreign('ad_city_id')->references('id')->on('ad_cities');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('ad_retailer_cities');
    }
}
