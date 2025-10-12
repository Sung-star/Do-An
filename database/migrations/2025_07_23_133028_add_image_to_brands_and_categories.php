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
        Schema::table('brands', function (Blueprint $table) {
            $table->string('code')->nullable()->after('brandname');
            $table->string('image')->nullable()->after('code');
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->string('code')->nullable()->after('catename');
            $table->string('image')->nullable()->after('code');
        });
    }

    public function down()
    {
        Schema::table('brands', function (Blueprint $table) {
            $table->dropColumn(['code', 'image']);
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn(['code', 'image']);
        });
    }
};
