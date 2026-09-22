<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        try {
            DB::statement("ALTER TABLE rooms MODIFY COLUMN image MEDIUMTEXT NULL");
        } catch (\Exception $e) {
            // Fallback for different SQL dialects
            Schema::table('rooms', function (Blueprint $table) {
                $table->mediumText('image')->nullable()->change();
            });
        }

        // Repair any broken image paths from prior redeploys back to default valid image
        try {
            DB::table('rooms')
                ->where('image', 'like', 'images/rooms/1790%')
                ->update(['image' => 'images/rooms/room_mr1.jpg']);
        } catch (\Exception $e) {
            // Ignore if rooms table query fails
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        try {
            DB::statement("ALTER TABLE rooms MODIFY COLUMN image VARCHAR(255) NULL");
        } catch (\Exception $e) {
            Schema::table('rooms', function (Blueprint $table) {
                $table->string('image', 255)->nullable()->change();
            });
        }
    }
};
