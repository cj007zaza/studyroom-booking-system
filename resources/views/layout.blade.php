<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'ระบบจองห้อง Study Room')</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <!-- Google Fonts: Prompt -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --color-primary: #1e40af;
            --color-primary-hover: #1d4ed8;
            --color-primary-subtle: #eff6ff;
            --color-secondary: #7c3aed;
            --color-secondary-hover: #6d28d9;
            --color-secondary-light: #f5f3ff;
            --color-neutral-bg: #f8fafc;
            --color-neutral-surface: #ffffff;
            --color-neutral-subtle: #f1f5f9;
            --color-neutral-text: #334155;
            --color-neutral-heading: #0f172a;
            --color-neutral-border: #e2e8f0;
            --color-neutral-border-focus: #93c5fd;

            --radius-sm: 6px;
            --radius-md: 10px;
            --radius-lg: 16px;
            --radius-xl: 22px;
            --radius-pill: 9999px;

            --shadow-subtle: 0 1px 3px 0 rgba(15, 23, 42, 0.05), 0 1px 2px -1px rgba(15, 23, 42, 0.05);
            --shadow-card: 0 4px 10px -2px rgba(15, 23, 42, 0.04), 0 2px 4px -2px rgba(15, 23, 42, 0.03);
            --shadow-hover: 0 14px 26px -6px rgba(15, 23, 42, 0.09), 0 4px 10px -2px rgba(15, 23, 42, 0.04);
            --shadow-float: 0 20px 30px -8px rgba(15, 23, 42, 0.12), 0 8px 12px -4px rgba(15, 23, 42, 0.06);

            --ease-standard: cubic-bezier(0.16, 1, 0.3, 1);
        }

        *, *::before, *::after {
            box-sizing: border-box;
        }

        body {
            font-family: 'Prompt', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background-color: var(--color-neutral-bg);
            color: var(--color-neutral-text);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        /* Navbar Refinements (Single Line at Desktop, Height <= 72px) */
        .navbar-main {
            background: linear-gradient(135deg, #0f172a 0%, #1e3a8a 100%);
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            min-height: 68px;
        }

        .navbar-brand {
            font-weight: 700;
            letter-spacing: -0.3px;
            color: #ffffff !important;
            display: inline-flex;
            align-items: center;
            gap: 0.65rem;
            transition: opacity 0.2s var(--ease-standard);
        }
        .navbar-brand:hover {
            opacity: 0.95;
        }
        .navbar-logo {
            height: 42px;
            width: auto;
            object-fit: contain;
            filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.25));
            transition: transform 0.2s var(--ease-standard);
        }
        .navbar-brand:hover .navbar-logo {
            transform: scale(1.04);
        }

        .nav-link {
            font-size: 0.925rem;
            font-weight: 500;
            color: rgba(255, 255, 255, 0.85) !important;
            padding: 0.5rem 0.85rem !important;
            border-radius: var(--radius-md);
            transition: all 0.2s var(--ease-standard);
        }
        .nav-link:hover {
            color: #ffffff !important;
            background-color: rgba(255, 255, 255, 0.09);
        }
        .nav-link.active {
            color: #ffffff !important;
            background-color: rgba(255, 255, 255, 0.16);
            font-weight: 600;
        }

        /* Cards and Surfaces */
        .card {
            border-radius: var(--radius-lg);
            border: 1px solid var(--color-neutral-border);
            background-color: var(--color-neutral-surface);
            box-shadow: var(--shadow-card);
            transition: transform 0.22s var(--ease-standard), box-shadow 0.22s var(--ease-standard), border-color 0.22s var(--ease-standard);
        }
        .card-hover:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow-hover);
            border-color: #cbd5e1;
        }

        /* Status Badges */
        .badge-pending { 
            background-color: #fef3c7; 
            color: #92400e; 
            border: 1px solid #fde68a;
            border-radius: var(--radius-pill); 
            font-weight: 600;
            padding: 0.35rem 0.75rem;
        }
        .badge-approved { 
            background-color: #d1fae5; 
            color: #065f46; 
            border: 1px solid #a7f3d0;
            border-radius: var(--radius-pill); 
            font-weight: 600;
            padding: 0.35rem 0.75rem;
        }
        .badge-rejected { 
            background-color: #ffe4e6; 
            color: #9f1239; 
            border: 1px solid #fecdd3;
            border-radius: var(--radius-pill); 
            font-weight: 600;
            padding: 0.35rem 0.75rem;
        }
        .badge-cancelled { 
            background-color: #f1f5f9; 
            color: #475569; 
            border: 1px solid #e2e8f0;
            border-radius: var(--radius-pill); 
            font-weight: 500;
            padding: 0.35rem 0.75rem;
        }
        
        /* Faculty of Education (หอพักครุศาสตร์) Branding Tokens */
        .btn-faculty {
            background-color: var(--color-secondary);
            border-color: var(--color-secondary);
            color: #ffffff;
            font-weight: 600;
            border-radius: var(--radius-md);
            transition: all 0.2s var(--ease-standard);
        }
        .btn-faculty:hover, .btn-faculty:focus {
            background-color: var(--color-secondary-hover);
            border-color: var(--color-secondary-hover);
            color: #ffffff;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(124, 58, 237, 0.25);
        }
        .btn-outline-faculty {
            background-color: transparent;
            border-color: var(--color-secondary);
            color: var(--color-secondary);
            font-weight: 600;
            border-radius: var(--radius-md);
            transition: all 0.2s var(--ease-standard);
        }
        .btn-outline-faculty:hover, .btn-outline-faculty:focus {
            background-color: var(--color-secondary);
            border-color: var(--color-secondary);
            color: #ffffff;
            transform: translateY(-1px);
        }
        .badge-faculty {
            background-color: var(--color-secondary);
            color: #ffffff;
            border-radius: var(--radius-pill);
            padding: 4px 12px;
            font-weight: 600;
            font-size: 0.785rem;
        }
        .badge-faculty-subtle {
            background-color: var(--color-secondary-light);
            color: var(--color-secondary);
            border: 1px solid rgba(124, 58, 237, 0.2);
            border-radius: var(--radius-pill);
            padding: 4px 12px;
            font-weight: 600;
            font-size: 0.785rem;
        }

        /* Core Buttons */
        .btn-primary {
            background-color: var(--color-primary);
            border-color: var(--color-primary);
            font-weight: 600;
            border-radius: var(--radius-md);
            transition: all 0.2s var(--ease-standard);
        }
        .btn-primary:hover, .btn-primary:focus {
            background-color: var(--color-primary-hover);
            border-color: var(--color-primary-hover);
            transform: translateY(-1px);
            box-shadow: 0 4px 14px rgba(30, 64, 175, 0.25);
        }
        .btn-outline-primary {
            border-color: var(--color-primary);
            color: var(--color-primary);
            font-weight: 600;
            border-radius: var(--radius-md);
            transition: all 0.2s var(--ease-standard);
        }
        .btn-outline-primary:hover, .btn-outline-primary:focus {
            background-color: var(--color-primary);
            color: #ffffff;
            transform: translateY(-1px);
        }

        /* Form Inputs with WCAG AA Polish */
        .form-control, .form-select {
            border-radius: var(--radius-md);
            border: 1.5px solid var(--color-neutral-border);
            padding: 0.625rem 0.875rem;
            font-size: 0.95rem;
            color: var(--color-neutral-heading);
            background-color: #ffffff;
            transition: border-color 0.18s var(--ease-standard), box-shadow 0.18s var(--ease-standard);
        }
        .form-control:focus, .form-select:focus {
            border-color: var(--color-primary);
            box-shadow: 0 0 0 3px rgba(30, 64, 175, 0.12);
            outline: none;
        }

        /* Tables */
        .table {
            --bs-table-bg: transparent;
            font-size: 0.925rem;
        }
        .table thead th {
            font-size: 0.8125rem;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            color: #64748b;
            font-weight: 600;
            border-bottom: 1.5px solid var(--color-neutral-border);
            padding-top: 0.875rem;
            padding-bottom: 0.875rem;
            background-color: #f8fafc;
        }
        .table tbody td {
            padding-top: 1rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid #f1f5f9;
        }

        /* Accessibility: Reduced Motion */
        @media (prefers-reduced-motion: reduce) {
            *, ::before, ::after {
                animation-duration: 0.01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: 0.01ms !important;
                scroll-behavior: auto !important;
            }
            .card-hover:hover, .btn:hover {
                transform: none !important;
            }
        }

        footer {
            margin-top: auto;
            background: #ffffff;
            border-top: 1px solid var(--color-neutral-border);
        }
    </style>
    @yield('styles')
</head>
<body>
    <!-- แถบเมนูด้านบน (Navbar) -->
    <nav class="navbar navbar-expand-lg navbar-dark navbar-main sticky-top">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <img src="{{ asset('images/cmru_logo.png') }}" alt="ตราสัญลักษณ์ มหาวิทยาลัยราชภัฏเชียงใหม่" class="navbar-logo">
                <span>Study Room Booking</span>
            </a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false" aria-label="เปิด/ปิดแถบเมนูนำทาง">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 align-items-lg-center">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">
                            หน้าแรก
                        </a>
                    </li>
                    @if(!Auth::check() || Auth::user()->role !== 'admin')
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('bookings.create') ? 'active' : '' }}" href="{{ route('bookings.create') }}">
                                จองห้อง Study Room
                            </a>
                        </li>
                    @endif
                    @auth
                        @if(Auth::user()->role === 'admin')
                            <li class="nav-item">
                                <a class="nav-link text-warning fw-bold {{ request()->routeIs('admin.bookings*') ? 'active' : '' }}" href="{{ route('admin.bookings') }}">
                                    จัดการคำขอจอง 
                                    @php $pendingBadge = \App\Models\Booking::where('status', 'pending')->count(); @endphp
                                    @if($pendingBadge > 0)
                                        <span class="badge bg-danger ms-1">{{ $pendingBadge }}</span>
                                    @endif
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-white {{ request()->routeIs('rooms.index') ? 'active' : '' }}" href="{{ route('rooms.index') }}">
                                    จัดการห้อง
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-white {{ request()->routeIs('rooms.create') ? 'active' : '' }}" href="{{ route('rooms.create') }}">
                                    เพิ่มห้องใหม่
                                </a>
                            </li>
                        @endif
                    @endauth
                </ul>

                <ul class="navbar-nav ms-auto align-items-lg-center gap-2">
                    @guest
                        <li class="nav-item">
                            <a class="btn btn-outline-light btn-sm px-3" href="{{ route('login') }}">
                                เข้าสู่ระบบ
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="btn btn-light text-primary btn-sm px-3 fw-semibold shadow-sm" href="{{ route('register') }}">
                                สมัครสมาชิก
                            </a>
                        </li>
                    @else
                        <li class="nav-item text-white me-2 d-flex align-items-center">
                            @if(Auth::user()->role === 'admin')
                                <span class="badge bg-warning text-dark fw-bold me-1 px-2 py-1">ผู้ดูแลระบบ</span>
                                <span class="fw-medium text-white">{{ trim(str_replace(['ผู้ดูแลระบบ', 'ผู้ดูแลระบบ '], '', Auth::user()->name)) ?: 'Admin' }}</span>
                            @else
                                <span class="badge bg-light text-dark me-1 border">นักศึกษา</span>
                                <span class="fw-medium text-white">{{ Auth::user()->name }}</span>
                                @if(Auth::user()->student_id)
                                    <small class="text-white-50 ms-1">รหัส {{ Auth::user()->student_id }}</small>
                                @endif
                            @endif
                        </li>
                        <li class="nav-item">
                            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-outline-light btn-sm" onclick="return confirm('ต้องการออกจากระบบหรือไม่?')">
                                    ออกจากระบบ
                                </button>
                            </form>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <!-- แจ้งเตือนข้อความสถานะ (Flash Messages & Validation Errors) -->
    <div class="container mt-3">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show d-flex align-items-center gap-2 border-0 shadow-sm" role="alert" style="background-color: #ecfdf5; color: #065f46; border-left: 4px solid #10b981 !important;">
                <i class="bi bi-check-circle-fill fs-5 text-success"></i>
                <div class="fw-medium">{{ session('success') }}</div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center gap-2 border-0 shadow-sm" role="alert" style="background-color: #fff1f2; color: #9f1239; border-left: 4px solid #f43f5e !important;">
                <i class="bi bi-exclamation-triangle-fill fs-5 text-danger"></i>
                <div class="fw-medium">{{ session('error') }}</div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(isset($errors) && $errors->any())
            <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm" role="alert" style="background-color: #fff1f2; color: #9f1239; border-left: 4px solid #f43f5e !important;">
                <div class="fw-bold mb-1"><i class="bi bi-x-circle-fill me-1"></i> พบข้อผิดพลาด กรุณาตรวจสอบ:</div>
                <ul class="mb-0 ps-3">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
    </div>

    <!-- ส่วนเนื้อหาหลัก (Main Content) -->
    <main class="container my-4 flex-grow-1">
        @yield('content')
    </main>

    <!-- ส่วนท้ายเว็บ (Footer) -->
    <footer class="py-4 text-center">
        <div class="container">
            <p class="mb-1 fw-medium text-dark">ระบบจองห้อง Study Room | มหาวิทยาลัยราชภัฏเชียงใหม่</p>
            <small style="color: #475569;">พัฒนาด้วย Laravel & Bootstrap 5 | โครงงานรายวิชา WWW - กำหนดนำเสนอ 23 กันยายน 2569</small>
        </div>
    </footer>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>
