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
        Schema::create('companies', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ceo')->nullable();
            $table->integer('no_of_offices')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedInteger('industry_id')->nullable();
            $table->unsignedInteger('ownership_type_id')->nullable();
            $table->unsignedInteger('company_size_id')->nullable();
            $table->integer('established_in')->nullable();
            $table->text('details')->nullable();
            $table->string('website')->nullable();
            $table->string('location')->nullable();
            $table->boolean('is_featured')->default(0);
            $table->string('fax')->nullable();
            $table->string('facebook_url')->nullable();
            $table->string('twitter_url')->nullable();
            $table->string('linkedin_url')->nullable();
            $table->string('google_plus_url')->nullable();
            $table->string('pinterest_url')->nullable();
            $table->string('unique_id', 170)->unique();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('industry_id')->references('id')->on('industries')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreign('ownership_type_id')->references('id')->on('ownership_types')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreign('company_size_id')->references('id')->on('company_sizes')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('companies');
    }
};
