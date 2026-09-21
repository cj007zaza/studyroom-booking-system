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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('room_id')->constrained()->cascadeOnDelete();
            $table->date('booking_date'); // วันที่จอง
            $table->string('time_slot'); // ช่วงเวลา เช่น 08:30-10:30, 13:00-15:00
            $table->integer('participant_count'); // จำนวนผู้เข้าใช้งาน
            $table->text('purpose'); // วัตถุประสงค์การใช้งาน
            $table->string('status')->default('pending'); // pending, approved, rejected, cancelled
            $table->string('admin_note')->nullable(); // บันทึก/เหตุผลจากแอดมิน
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
