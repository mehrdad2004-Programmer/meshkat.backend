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
        if(!Schema::hasTable("payment")){
           Schema::create("payment", function(Blueprint $table){
            $table->id();
            $table->string("tr_code");
            $table->string("username");
            $table->float("amount", 12, 2);
            $table->date("date");
            $table->string("time");
            $table->string("authority");
            $table->string("ref_id");
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
        Schema::dropIfExists("payment");
    }
};
