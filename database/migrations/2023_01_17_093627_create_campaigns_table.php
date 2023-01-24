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
        Schema::create('campaigns', function (Blueprint $table) {
            $table->id();
            $table->string('featured_image_url')->nullable();
            $table->string('title');
            $table->string('slug');
            $table->foreignId('category_id')->nullable()->constrained('campaign_categories')->nullOnDelete();
            $table->text('content');
            $table->unsignedBigInteger('maintenance_fee')->nullable();
            $table->boolean('is_target');
            $table->unsignedBigInteger('target_amount')->nullable();
            $table->json('choice_amount')->nullable();
            $table->boolean('is_limited_time');
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->boolean('is_hidden');
            $table->boolean('is_selected');
            $table->boolean('is_completed');
            $table->foreignId('creator_id')->constrained('users')->cascadeOnDelete();
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
        Schema::dropIfExists('campaigns');
    }
};
