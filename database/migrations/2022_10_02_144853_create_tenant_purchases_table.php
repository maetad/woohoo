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
        Schema::create('tenant_purchases', function (Blueprint $table) {
            $table->id();
            $table->string('tenant_id')->constrained('tenants');
            $table->foreignId('plan_id')->constrained('tenant_plans');
            $table->enum('status', ['free-trial', 'pending', 'purchased']);
            $table->unsignedInteger('amount')->default(0);
            $table->char('currency', 3)->default('THB');
            $table->timestamp('start_at');
            $table->timestamp('end_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tenant_purchases');
    }
};
