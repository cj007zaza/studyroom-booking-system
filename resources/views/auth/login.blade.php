@extends('layout')

@section('title', 'เข้าสู่ระบบ - ระบบจองห้อง Study Room')

@section('content')
<div class="row justify-content-center py-4">
    <div class="col-md-5">
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="card-body p-4 p-md-5">
                <div class="text-center mb-4">
                    <div class="mb-3">
                        <img src="{{ asset('images/cmru_logo.png') }}" alt="โลโก้ มหาวิทยาลัยราชภัฏเชียงใหม่" style="height: 64px; width: auto; object-fit: contain;">
                    </div>
                    <h3 class="fw-bold mb-1" style="color: var(--color-neutral-heading);">เข้าสู่ระบบ</h3>
                    <p class="text-secondary small">ระบบจองห้อง Study Room มหาวิทยาลัยราชภัฏเชียงใหม่</p>
                </div>

                <form action="{{ route('login.submit') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="student_id" class="form-label fw-semibold text-dark">
                            รหัสนักศึกษา หรือ Username ผู้ดูแลระบบ
                        </label>
                        <input type="text" name="student_id" id="student_id" 
                               class="form-control form-control-lg @error('student_id') is-invalid @enderror" 
                               placeholder="รหัสนักศึกษา หรือ Username" 
                               value="{{ old('student_id') }}" required autofocus>
                        @error('student_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="password" class="form-label fw-semibold text-dark">
                            รหัสผ่าน
                        </label>
                        <input type="password" name="password" id="password" 
                               class="form-control form-control-lg @error('password') is-invalid @enderror" 
                               placeholder="กรอกรหัสผ่าน" required>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary btn-lg w-100 fw-bold mb-3 shadow-sm" style="min-height: 48px;">
                        เข้าสู่ระบบ
                    </button>

                    <div class="text-center">
                        <span class="text-secondary">ยังไม่มีบัญชีใช่หรือไม่?</span>
                        <a href="{{ route('register') }}" class="text-decoration-none fw-semibold text-primary ms-1">ลงทะเบียนนักศึกษาใหม่</a>
                    </div>
                </form>

                <hr class="my-4" style="border-color: var(--color-neutral-border);">

                <!-- ข้อมูลบัญชีตัวอย่างสำหรับการนำเสนอ Live Demo หน้าชั้นเรียน -->
                <div class="bg-light p-3 rounded-3 border small">
                    <div class="fw-bold text-secondary mb-2 d-flex align-items-center gap-1">
                        <i class="bi bi-info-circle text-primary"></i> ข้อมูลบัญชีสำหรับทดสอบระบบ:
                    </div>
                    <ul class="mb-0 ps-3 text-secondary">
                        <li><strong>นักศึกษา:</strong> รหัส <code>67123456</code> / รหัสผ่าน <code>123456</code></li>
                        <li><strong>ผู้ดูแลระบบ:</strong> รหัส <code>admin</code> / รหัสผ่าน <code>admin1234</code></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
