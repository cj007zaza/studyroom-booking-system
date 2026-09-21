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
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->string('building'); // หอพัก เช่น หอพักครุศาสตร์, หอพักแม่ริม
            $table->string('room_name'); // เช่น ครุศาสตร์ 1, หอแม่ริม 1
            $table->integer('capacity')->default(6); // ความจุคน
            $table->string('facilities')->nullable(); // อุปกรณ์อำนวยความสะดวก
            $table->string('image')->nullable(); // รูปภาพห้อง (ตามบทเรียน Chapter 8)
            $table->string('status')->default('available'); // available, maintenance
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
