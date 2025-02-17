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
        Schema::create('visibility_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Define user_id first
            $table->foreignId('visibility_group_id')->nullable()->constrained('visibility_groups')->onDelete('cascade'); // Nullable if no group is assigned
            $table->string('item_type')->index(); // e.g., Leads, Deals, People (Index for performance)
            $table->enum('visibility', ['item_owner', 'visibility_group', 'sub_groups', 'all_users'])->default('visibility_group'); // Default value
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visibility_settings');
    }
};
