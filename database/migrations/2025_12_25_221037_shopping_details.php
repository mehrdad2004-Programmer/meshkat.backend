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
        Schema::create("shopping_details", function(Blueprint $table){
            $table->id();
            $table->string('tr_code');
            $table->string("p_code");
            $table->timestamps();

            $table->foreign("p_code")
                ->references("tr_code")
                ->on("products")
                ->onDelete("cascade")
                ->onUpdate("cascade");

            $table->foreign("tr_code")
                ->references("tr_code")
                ->on("shopping")
                ->onDelete("cascade")
                ->onUpdate("cascade");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("shopping_details");
    }
};
