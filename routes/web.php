<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\BookingController;

// 1. หน้าแรก แสดงห้อง Study Room และสถิติ
Route::get('/', [HomeController::class, 'index'])->name('home');

// 2. ระบบเข้าสู่ระบบ / ลงทะเบียน / ออกจากระบบ
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// 3. ระบบจองห้องสำหรับนักศึกษาที่เข้าสู่ระบบแล้ว
Route::middleware('auth')->group(function () {
    Route::get('/bookings', [BookingController::class, 'index'])->name('bookings.index');
    Route::get('/bookings/create', [BookingController::class, 'create'])->name('bookings.create');
    Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');
    Route::post('/bookings/{booking}/cancel', [BookingController::class, 'cancel'])->name('bookings.cancel');
});

// 4. ส่วนของผู้ดูแลระบบ (Admin Only - จัดการห้อง CRUD และอนุมัติการจอง)
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    // จัดการห้องพัก (Chapter 8)
    Route::resource('rooms', RoomController::class)->except(['show']);

    // จัดการคำขอจองห้อง
    Route::get('/bookings', [BookingController::class, 'adminIndex'])->name('admin.bookings');
    Route::patch('/bookings/{booking}/status', [BookingController::class, 'updateStatus'])->name('admin.bookings.status');
});
