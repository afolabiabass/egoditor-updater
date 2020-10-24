<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQrStatisticsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('qr_statistics', function (Blueprint $table) {
            $table->id();
            $table->string('ip_address')->nullable();
            $table->string('subnet_mask')->nullable();

            $table->string('continent_code', 2)->nullable();
            $table->string('country_code', 2)->nullable();
            $table->string('state')->nullable();
            $table->string('district')->nullable();
            $table->string('city')->nullable();
            $table->string('zip_code')->nullable();

            $table->float('latitude')->nullable();
            $table->float('longitude')->nullable();

            $table->integer('geo_name_id')->nullable();
            $table->float('gmt_offset')->nullable();

            $table->string('timezone')->nullable();
            $table->string('weather_code')->nullable();

            $table->string('isp')->nullable();
            $table->integer('as_number')->nullable();
            $table->string('link_type')->nullable();
            $table->string('organization')->nullable();

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
        Schema::dropIfExists('qr_statistics');
    }
}
