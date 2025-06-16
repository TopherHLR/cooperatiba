<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('order_history', function (Blueprint $table) {
            $table->boolean('is_current')->default(false)->after('is_read'); // or after any column you prefer
        });
    }

    public function down()
    {
        Schema::table('order_history', function (Blueprint $table) {
            $table->dropColumn('is_current');
        });
    }
};
