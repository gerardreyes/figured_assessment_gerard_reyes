<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class InventoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('inventories')) {
            // Only create table is the table does not exist yet.
            Schema::create('inventories', function (Blueprint $table) {
                $table->id();
                $table->date('transaction_date')->nullable();
                $table->string('type')->nullable();
                $table->integer('quantity')->nullable();
                $table->decimal('unit_price', 8, 2)->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inventories');
    }
}
