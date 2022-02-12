<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOrderInLaradocPages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('laradoc_pages', function (Blueprint $table) {
            $table->string('group')->after('parent_id')->nullable();
            $table->integer('order')->after('parent_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('laradoc_pages', function (Blueprint $table) {
            $table->dropColumn('group');
            $table->dropColumn('order');
        });
    }
}
