<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('uniform', function (Blueprint $table) {
            $table->integer('new_stock')->default(0)->after('stock_quantity');
        });
    }

    public function down()
    {
        Schema::table('uniform', function (Blueprint $table) {
            $table->dropColumn('new_stock');
        });
    }
};
