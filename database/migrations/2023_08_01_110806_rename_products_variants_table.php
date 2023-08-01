<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::rename('products_variants', 'product_variants');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
 public function down()
{
    Schema::rename('product_variants', 'products_variants');
}

};
