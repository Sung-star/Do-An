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
        Schema::table('orderitems', function (Blueprint $table) {
            $table->string('color')->nullable()->after('price');
            $table->string('version')->nullable()->after('color');
        });
    }

    public function down()
    {
        Schema::table('orderitems', function (Blueprint $table) {
            $table->dropColumn(['color', 'version']);
        });
    }
};
