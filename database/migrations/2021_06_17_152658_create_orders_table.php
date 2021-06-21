<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->text('comment')->nullable();
            $table->boolean('quickly')->default(false);
            $table->time('to_time')->nullable();
            $table->smallInteger('status')->default(0);
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('promo_code_id')->nullable()->constrained('promo_codes');
            $table->foreignId('payment_type_id')->constrained('payment_types');
            $table->timestamps();
        });

        Schema::table('order_items', function (Blueprint $table) {
            $table->foreignId('order_id')->after('product_id')->constrained('orders');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
