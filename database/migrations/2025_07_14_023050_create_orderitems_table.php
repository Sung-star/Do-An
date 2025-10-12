<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orderitems', function (Blueprint $table) {
            $table->id();
            // tạo ra thuộc tính orderid
            // kiểu unsigned biginteger (cùng kiểu với id của bảng orders)
            $table->unsignedBigInteger('orderid');
            // tạo ra thuộc tính productid
            // kiểu unsigned biginteger (cùng kiểu với id của bảng products)
            $table->unsignedBigInteger('productid');
            // số lượng
            $table->integer('quantity');
            // giá
            $table->decimal('price');
            $table->timestamps();
            // khóa ngoại
            // đặt tên cho khóa orders_cateid_foreign
            $table->foreign('productid', 'products_proid_foreign')
                ->references('id')->on('products');
            // khóa ngoại
            // đặt tên cho khóa orders_cateid_foreign
            $table->foreign('orderid', 'orders_orderid_foreign')
                ->references('id')->on('orders');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orderitems');
    }
};
