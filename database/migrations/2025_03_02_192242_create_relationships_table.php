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
        Schema::create('relationships', function (Blueprint $table) {
            $table->unsignedBigInteger('id', false)->length(20);
            $table->unsignedBigInteger('created_by')->length(20)->notNullable();
            $table->unsignedBigInteger('parent_id')->length(20)->notNullable();
            $table->unsignedBigInteger('child_id')->length(20)->notNullable();
            $table->timestamps();

            // Index
            $table->primary('id');
            $table->index('created_by');
            $table->foreign('parent_id')->references('id')->on('people');
            $table->foreign('child_id')->references('id')->on('people');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('relationships');
    }
};
