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
        Schema::create('manual_payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('status_code')->default(0);
            $table->string('reference')->unique();
            $table->foreignId('payer_id')->constrained('users');
            $table->foreignId('campaign_id')->constrained()->cascadeOnDelete();
            $table->text('receipt_url')->nullable();
            $table->unsignedBigInteger('amount');
            $table->unsignedBigInteger('maintenance_fee');
            $table->string('on_behalf');
            $table->string('wos')->nullable();
            $table->boolean('is_anonim')->default(false);
            $table->foreignId('validator_id')->nullable()->constrained('users');
            $table->string('comment')->nullable();

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
        Schema::dropIfExists('manual_payments');
    }
};
