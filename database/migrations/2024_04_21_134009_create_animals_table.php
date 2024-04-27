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
        Schema::create('animals', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('type_id')->comment('動物分類');
            $table->string('name')->comment('動物的暱稱');
            $table->date('birthday')->nullable()->comment('生日');
            $table->string('area')->nullable()->comment('所在地區');
            $table->boolean('fix')->default(false)->comment('結紮情形');
            $table->text('description')->nullable()->comment('簡單敘述');
            $table->text('personality')->nullable()->comment('動物個性');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('animals');
    }
};
