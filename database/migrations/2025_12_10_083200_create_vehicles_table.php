<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('nation_id')->constrained('nations')->onDelete('cascade');
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
            $table->string('name');
            $table->string('image')->nullable();
            $table->string('model_file')->nullable(); // Kolom khusus 3D
            $table->integer('production_year');
            $table->integer('quantity');
            $table->string('battles');
            $table->text('description');
            $table->timestamps();
        });
    }
    public function down() { Schema::dropIfExists('vehicles'); }
};