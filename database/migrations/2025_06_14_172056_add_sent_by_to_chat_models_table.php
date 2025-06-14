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
        Schema::table('chat', function (Blueprint $table) {
            $table->string('sent_by')->after('admin_id')->default('admin'); // Default to 'admin' for existing records
        });
    }

    public function down()
    {
        Schema::table('chat', function (Blueprint $table) {
            $table->dropColumn('sent_by');
        });
    }

};
