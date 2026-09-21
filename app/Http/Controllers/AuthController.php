<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    // แสดงหน้าเข้าสู่ระบบ (Login)
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route('home');
        }
        return view('auth.login');
    }

    // จัดการข้อมูลการเข้าสู่ระบบ (พร้อม Rate Limiting ป้องกัน Brute Force)
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'student_id' => 'required|string',
            'password' => 'required|string',
        ], [
            'student_id.required' => 'กรุณากรอกรหัสนักศึกษา หรือบัญชีผู้ดูแลระบบ',
            'password.required' => 'กรุณากรอกรหัสผ่าน',
        ]);

        // Rate Limiting: จำกัด 5 ครั้ง/นาที ต่อ student_id + IP
        $throttleKey = Str::lower($credentials['student_id']) . '|' . $request->ip();

        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            return back()->withErrors([
                'student_id' => "เข้าสู่ระบบผิดพลาดหลายครั้งเกินไป กรุณารอ {$seconds} วินาที แล้วลองใหม่อีกครั้ง",
            ])->onlyInput('student_id');
        }

        if (Auth::attempt(['student_id' => $credentials['student_id'], 'password' => $credentials['password']])) {
            RateLimiter::clear($throttleKey);
            $request->session()->regenerate();

            if (Auth::user()->role === 'admin') {
                return redirect()->route('admin.bookings')->with('success', 'ยินดีต้อนรับ ผู้ดูแลระบบ เข้าสู่ระบบสำเร็จ');
            }

            return redirect()->route('home')->with('success', 'เข้าสู่ระบบสำเร็จ ยินดีต้อนรับคุณ ' . Auth::user()->name);
        }

        RateLimiter::hit($throttleKey, 60);

        return back()->withErrors([
            'student_id' => 'รหัสนักศึกษา หรือรหัสผ่านไม่ถูกต้อง กรุณาลองใหม่อีกครั้ง',
        ])->onlyInput('student_id');
    }

    // แสดงหน้าลงทะเบียนนักศึกษา (Register)
    public function showRegister()
    {
        if (Auth::check()) {
            return redirect()->route('home');
        }
        return view('auth.register');
    }

    // บันทึกข้อมูลการสมัครสมาชิก
    public function register(Request $request)
    {
        $validated = $request->validate([
            'prefix' => 'required|string|in:นาย,นางสาว,นาง',
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'student_id' => 'required|string|unique:users,student_id|regex:/^[0-9]{8}$/',
            'faculty' => 'required|string',
            'major' => 'required|string',
            'year_level' => 'required|string',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'password' => 'required|string|min:6|confirmed',
        ], [
            'prefix.required' => 'กรุณาเลือกคำนำหน้าชื่อ',
            'prefix.in' => 'คำนำหน้าชื่อต้องเป็น นาย, นางสาว หรือ นาง',
            'first_name.required' => 'กรุณากรอกชื่อจริง',
            'last_name.required' => 'กรุณากรอกนามสกุล',
            'student_id.required' => 'กรุณากรอกรหัสนักศึกษา',
            'student_id.unique' => 'รหัสนักศึกษานี้ลงทะเบียนไว้ในระบบแล้ว',
            'student_id.regex' => 'รหัสนักศึกษาต้องเป็นตัวเลข 8 หลัก เช่น 67123456',
            'faculty.required' => 'กรุณาเลือกคณะ',
            'major.required' => 'กรุณาเลือกสาขาวิชา',
            'year_level.required' => 'กรุณาเลือกชั้นปี',
            'password.required' => 'กรุณากรอกรหัสผ่าน',
            'password.min' => 'รหัสผ่านต้องมีความยาวอย่างน้อย 6 ตัวอักษร',
            'password.confirmed' => 'การยืนยันรหัสผ่านไม่ตรงกัน',
        ]);

        $fullName = $validated['prefix'] . $validated['first_name'] . ' ' . $validated['last_name'];

        $user = User::create([
            'student_id' => $validated['student_id'],
            'name' => $fullName,
            'email' => $validated['email'] ?? null,
            'faculty' => $validated['faculty'],
            'major' => $validated['major'],
            'year_level' => $validated['year_level'],
            'phone' => $validated['phone'] ?? null,
            'role' => 'student',
            'password' => Hash::make($validated['password']),
        ]);

        Auth::login($user);

        return redirect()->route('home')->with('success', 'สมัครสมาชิกและเข้าสู่ระบบสำเร็จเรียบร้อย');
    }

    // ออกจากระบบ (Logout)
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'ออกจากระบบเรียบร้อยแล้ว');
    }
}
