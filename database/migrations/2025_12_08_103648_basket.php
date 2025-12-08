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
        if(!Schema::hasTable("basket")){
            Schema::create("basket", function(Blueprint $table){
                $table->id();
                $table->string("tr_code");
                $table->date("date");
                $table->time("time");
                $table->string("username");
                $table->string("status");
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("basket");
    }
};
