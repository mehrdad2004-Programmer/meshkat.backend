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
        if(!Schema::hasTable("products")){
            Schema::create("products", function(Blueprint $table){
                $table->id();
                $table->string("title");
                $table->float("price", 12, 2);
                $table->date("date");
                $table->time("time");
                $table->string("mixture");
                $table->string('tr_code')->unique();
                $table->string("categoury")->index();
                $table->string("thumbnail");
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
