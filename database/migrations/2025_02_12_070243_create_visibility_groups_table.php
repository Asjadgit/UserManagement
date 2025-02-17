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
        Schema::create('visibility_groups', function (Blueprint $table) {
            $table->id();
            $table->string('name', 70); // Example: "Sales Team A", "Managers"
            $table->index('name'); // Manually adding an index
            $table->string('description', 255)->nullable(); // Optional description
            $table->foreignId('parent_id')->nullable()->constrained('visibility_groups')->onDelete('cascade'); // Parent group reference
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visibility_groups');
    }
};
