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
        Schema::create('pool_tables', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->decimal('price_per_hour', 15, 2);
            $table->tinyInteger('status')->default(1);
            $table->integer('x');
            $table->integer('y');
            $table->enum('orientation', ['horizontal', 'vertical']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pool_tables');
    }
};
