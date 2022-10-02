<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tenant_plans', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedInteger('amount')->default(0);
            $table->char('currency', 3)->default('THB');
            $table->json('data')->nullable();
            $table->timestamp('active_at')->nullable();
            $table->timestamp('expired_at')->nullable();
            $table->boolean('is_default')->default(false);
            $table->boolean('is_recommended')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tenant_plans');
    }
};
