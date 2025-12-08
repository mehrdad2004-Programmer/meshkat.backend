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

            //relations
            $table->foreign("username")
                ->on("users")
                ->references("username")
                ->onDelete("cascade")
                ->onUpdate("cascade");

            $table->foreign("tr_code")
                ->on("products")
                ->references("tr_code")
                ->onDelete("cascade")
                ->onUpdate("cascade");


            //indexes
            $table->index('tr_code');
            $table->index("username");
            $table->index("authority");
            $table->index("ref_id");
            $table->index("status");
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
