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
        if(!Schema::hasTable("access_logs")){
            Schema::create("access_logs", function(Blueprint $table){
                $table->id();
                $table->string("tr_code");
                $table->string("username");
                $table->date("date");
                $table->time("time");
                $table->string("ip_address");
                $table->string("user_agent");
                $table->string("op_type");
                $table->timestamps();

                //relations
                $table->foreign("username")
                    ->references("username")
                    ->on("users")
                    ->onDelete("cascade")
                    ->onUpdate("cascade");

                $table->foreign("tr_code")
                    ->references("tr_code")
                    ->on("products")
                    ->onDelete("cascade")
                    ->onUpdate("cascade");
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("access_logs");
    }
};
