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
        Schema::create('shopping', function(Blueprint $table){
            $table->id();
            $table->string("username");
            $table->date("date");
            $table->time("time");
            $table->string("tr_code")->unique();
            $table->string("status")->default("pending");
            $table->timestamps();

            $table->foreign("username")
                ->references("username")
                ->on("users")
                ->onDelete("cascade")
                ->onUpdate("cascade");

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("shopping");
    }
};
