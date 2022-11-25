<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('best_seller_books', function (Blueprint $table) {
            $table->id();
            $table->integer('list_id');
            $table->text('title');
            $table->text('author');
            $table->integer('book_rank');
            $table->integer('weeks_on_list');
            $table->text('image');
            $table->json('buy_links');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('best_seller_books');
    }
};
