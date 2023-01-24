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
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->string('featured_image_url')->nullable();
            $table->string('title');
            $table->string('slug');
            $table->foreignId('category_id')->nullable()->constrained('article_categories')->nullOnDelete();
            $table->text('content');
            $table->boolean('is_hidden')->default(false);
            $table->boolean('is_selected')->default(false);
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
        Schema::dropIfExists('articles');
    }
};
