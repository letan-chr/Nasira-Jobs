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
        Schema::create('featured_records', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('owner_id');
            $table->string('owner_type');
            $table->unsignedBigInteger('user_id');
            $table->string('stripe_id');
            $table->dateTime('start_time');
            $table->dateTime('end_time');
            $table->text('meta');
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('featured_records');
    }
};
