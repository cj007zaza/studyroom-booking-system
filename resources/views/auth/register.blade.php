@extends('layout')

@section('title', 'ลงทะเบียนนักศึกษา - ระบบจองห้อง Study Room')

@section('content')
<div class="row justify-content-center py-3">
    <div class="col-md-8 col-lg-7">
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="card-body p-4 p-md-5">
                <div class="text-center mb-4">
                    <div class="mb-3">
                        <img src="{{ asset('images/cmru_logo.png') }}" alt="โลโก้ มหาวิทยาลัยราชภัฏเชียงใหม่" style="height: 64px; width: auto; object-fit: contain;">
                    </div>
                    <h3 class="fw-bold mb-1" style="color: var(--color-neutral-heading);">ลงทะเบียนนักศึกษา</h3>
                    <p class="text-secondary small">กรอกข้อมูลนักศึกษาเพื่อเริ่มใช้งานระบบจองห้อง Study Room</p>
                </div>

                <form action="{{ route('register.submit') }}" method="POST">
                    @csrf

                    <div class="row g-3">
                        <!-- แถวที่ 1: คำนำหน้าชื่อ + ชื่อ + นามสกุล -->
                        <div class="col-md-3">
                            <label for="prefix" class="form-label fw-semibold text-dark">
                                คำนำหน้า <span class="text-danger">*</span>
                            </label>
                            <select name="prefix" id="prefix" class="form-select @error('prefix') is-invalid @enderror" required>
                                <option value="">-- เลือก --</option>
                                <option value="นาย" {{ old('prefix') == 'นาย' ? 'selected' : '' }}>นาย</option>
                                <option value="นางสาว" {{ old('prefix') == 'นางสาว' ? 'selected' : '' }}>นางสาว</option>
                                <option value="นาง" {{ old('prefix') == 'นาง' ? 'selected' : '' }}>นาง</option>
                            </select>
                            @error('prefix')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label for="first_name" class="form-label fw-semibold text-dark">
                                ชื่อ <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="first_name" id="first_name" 
                                   class="form-control @error('first_name') is-invalid @enderror" 
                                   placeholder="ชื่อจริง"
                                   value="{{ old('first_name') }}" required>
                            @error('first_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-5">
                            <label for="last_name" class="form-label fw-semibold text-dark">
                                นามสกุล <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="last_name" id="last_name" 
                                   class="form-control @error('last_name') is-invalid @enderror" 
                                   placeholder="นามสกุล"
                                   value="{{ old('last_name') }}" required>
                            @error('last_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- แถวที่ 2: รหัสนักศึกษา + ชั้นปี -->
                        <div class="col-md-6">
                            <label for="student_id" class="form-label fw-semibold text-dark">
                                รหัสนักศึกษา <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="student_id" id="student_id" 
                                   class="form-control @error('student_id') is-invalid @enderror" 
                                   placeholder="รหัสนักศึกษา 8 หลัก" maxlength="8" 
                                   value="{{ old('student_id') }}" required>
                            @error('student_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="year_level" class="form-label fw-semibold text-dark">
                                ชั้นปี <span class="text-danger">*</span>
                            </label>
                            <select name="year_level" id="year_level" class="form-select @error('year_level') is-invalid @enderror" required>
                                <option value="">-- เลือกชั้นปี --</option>
                                <option value="ปี 1" {{ old('year_level') == 'ปี 1' ? 'selected' : '' }}>ชั้นปีที่ 1</option>
                                <option value="ปี 2" {{ old('year_level') == 'ปี 2' ? 'selected' : '' }}>ชั้นปีที่ 2</option>
                                <option value="ปี 3" {{ old('year_level') == 'ปี 3' ? 'selected' : '' }}>ชั้นปีที่ 3</option>
                                <option value="ปี 4" {{ old('year_level') == 'ปี 4' ? 'selected' : '' }}>ชั้นปีที่ 4</option>
                                <option value="ปี 5 หรือสูงกว่า" {{ old('year_level') == 'ปี 5 หรือสูงกว่า' ? 'selected' : '' }}>ปี 5 หรือสูงกว่า</option>
                            </select>
                            @error('year_level')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- แถวที่ 3: คณะ + สาขาวิชา -->
                        <div class="col-md-6">
                            <label for="faculty" class="form-label fw-semibold text-dark">
                                คณะ <span class="text-danger">*</span>
                            </label>
                            <select name="faculty" id="faculty" class="form-select @error('faculty') is-invalid @enderror" required>
                                <option value="คณะครุศาสตร์" selected>คณะครุศาสตร์</option>
                            </select>
                            @error('faculty')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="major" class="form-label fw-semibold text-dark">
                                สาขาวิชา <span class="text-danger">*</span>
                            </label>
                            <select name="major" id="major" class="form-select @error('major') is-invalid @enderror" required>
                                <option value="">-- กรุณาเลือกสาขาวิชา --</option>
                            </select>
                            @error('major')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- แถวที่ 4: เบอร์โทรศัพท์ + อีเมล -->
                        <div class="col-md-6">
                            <label for="phone" class="form-label fw-semibold text-dark">เบอร์โทรศัพท์ติดต่อ</label>
                            <input type="tel" name="phone" id="phone" 
                                   class="form-control @error('phone') is-invalid @enderror" 
                                   value="{{ old('phone') }}">
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="email" class="form-label fw-semibold text-dark">อีเมล</label>
                            <input type="email" name="email" id="email" 
                                   class="form-control @error('email') is-invalid @enderror" 
                                   value="{{ old('email') }}">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- แถวที่ 5: กำหนดรหัสผ่าน + ยืนยันรหัสผ่าน -->
                        <div class="col-md-6">
                            <label for="password" class="form-label fw-semibold text-dark">
                                กำหนดรหัสผ่าน <span class="text-danger">*</span>
                            </label>
                            <input type="password" name="password" id="password" 
                                   class="form-control @error('password') is-invalid @enderror" 
                                   placeholder="อย่างน้อย 4 ตัวอักษร" required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="password_confirmation" class="form-label fw-semibold text-dark">
                                ยืนยันรหัสผ่านอีกครั้ง <span class="text-danger">*</span>
                            </label>
                            <input type="password" name="password_confirmation" id="password_confirmation" 
                                   class="form-control" placeholder="กรอกรหัสผ่านซ้ำอีกครั้ง" required>
                        </div>
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary btn-lg w-100 fw-bold shadow-sm" style="min-height: 48px;">
                            สมัครสมาชิกและเข้าใช้งานทันที
                        </button>
                    </div>

                    <div class="text-center mt-3">
                        <span class="text-secondary">มีบัญชีอยู่แล้ว?</span>
                        <a href="{{ route('login') }}" class="text-decoration-none fw-semibold text-primary ms-1">เข้าสู่ระบบที่นี่</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // ข้อมูลสาขาวิชาของคณะครุศาสตร์ มหาวิทยาลัยราชภัฏเชียงใหม่
    const majorsByFaculty = {
        "คณะครุศาสตร์": [
            "การประถมศึกษา",
            "การศึกษาปฐมวัย",
            "การศึกษาพิเศษและพลศึกษา",
            "เกษตรศาสตร์",
            "คณิตศาสตร์",
            "คอมพิวเตอร์ศึกษา",
            "เคมี",
            "จิตวิทยาการศึกษาและการแนะแนว",
            "ชีววิทยา",
            "ดนตรีศึกษา",
            "นาฏศิลป์ศึกษา",
            "พลศึกษา",
            "ฟิสิกส์",
            "ภาษาจีน",
            "ภาษาไทย",
            "ภาษาอังกฤษ",
            "วิทยาศาสตร์ทั่วไป",
            "ศิลปศึกษา",
            "สังคมศึกษา",
            "อุตสาหกรรมศิลป์"
        ]
    };

    const facultySelect = document.getElementById('faculty');
    const majorSelect = document.getElementById('major');
    const oldMajor = "{{ old('major') }}";

    function updateMajors() {
        const selectedFaculty = facultySelect.value;
        majorSelect.innerHTML = '<option value="">-- กรุณาเลือกสาขาวิชา --</option>';

        if (selectedFaculty && majorsByFaculty[selectedFaculty]) {
            majorsByFaculty[selectedFaculty].forEach(major => {
                const option = document.createElement('option');
                option.value = major;
                option.textContent = major;
                if (oldMajor === major) {
                    option.selected = true;
                }
                majorSelect.appendChild(option);
            });
        } else {
            majorSelect.innerHTML = '<option value="">-- กรุณาเลือกคณะก่อน --</option>';
        }
    }

    // เมื่อผู้ใช้เลือกคณะ ให้เปลี่ยนรายการสาขาทันที (Dynamic Dropdown)
    facultySelect.addEventListener('change', updateMajors);

    // ทำงานตอนโหลดหน้าเว็บ หากมีค่าเดิมที่เลือกไว้ (เช่น ตอน validate error)
    if (facultySelect.value) {
        updateMajors();
    }
</script>
@endsection
