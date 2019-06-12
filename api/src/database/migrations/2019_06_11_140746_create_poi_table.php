<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePoiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('poi', function (Blueprint $table) {
            $table->integer('id')->unique()->primary();
            $table->string('id_sitra1')->nullable();
            $table->string('type')->nullable();
            $table->text('type_detail')->nullable();
            $table->string('name')->nullable();
            $table->string('address')->nullable();
            $table->integer('zip_code')->nullable();
            $table->string('town')->nullable();
            $table->string('phone')->nullable();
            $table->string('fax')->nullable();
            $table->string('fax_phone')->nullable();
            $table->string('email')->nullable();
            $table->string('website')->nullable();
            $table->string('facebook')->nullable();
            $table->string('rank')->nullable();
            $table->text('opening_times')->nullable();
            $table->text('price')->nullable();
            $table->double('pricemin')->nullable();
            $table->double('pricemax')->nullable();
            $table->string('author')->nullable();
            $table->integer('gid')->nullable();
            $table->dateTime('creation_date')->nullable();
            $table->dateTime('last_update')->nullable();
            $table->dateTime('last_update_fme')->nullable();
            $table->double('latitude')->nullable();
            $table->double('longitude')->nullable();

            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
            $table->engine = 'InnoDB';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('poi');
    }
}
