<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title ?? 'Inventaris Sekolah' }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/your-code.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* Small extra tweaks for Select2 to match our theme */
        .select2-container--default .select2-selection--single {
            border-radius: var(--radius);
            border-color: var(--border);
            height: 42px;
            display: flex;
            align-items: center;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <div style="padding: 0 1.5rem; margin-bottom: 2rem;">
            <div style="display: flex; align-items: center; gap: 1rem;">
                <i class="fas fa-boxes-stacked" style="font-size: 1.75rem; color: #fff;"></i>
                <span style="font-weight: 700; font-size: 1.25rem; color: #fff;">INVENTARIS</span>
            </div>
        </div>

        <div class="sidebar-header">Menu</div>
        <a href="{{ auth()->user()->role === 'admin' ? route('admin.dashboard') : route('staff.dashboard') }}" class="sidebar-link {{ request()->routeIs('*.dashboard') ? 'active' : '' }}">
            <i class="fas fa-th-large"></i> Dashboard
        </a>

        @if(auth()->user()->role === 'admin')
            <div class="sidebar-header">Items Data</div>
            <a href="{{ route('admin.categories.index') }}" class="sidebar-link {{ request()->is('*/categories*') ? 'active' : '' }}">
                <i class="fas fa-list"></i> Categories
            </a>
            <a href="{{ route('admin.items.index') }}" class="sidebar-link {{ request()->is('*/items*') ? 'active' : '' }}">
                <i class="fas fa-globe"></i> Items
            </a>

            <div class="sidebar-header">Accounts</div>
            <div x-data="{ open: {{ request()->is('*/users*') ? 'true' : 'false' }} }">
                <a href="javascript:void(0)" @click="open = !open" class="sidebar-link {{ request()->is('*/users*') ? 'active' : '' }}" style="justify-content: space-between;">
                    <span><i class="fas fa-user"></i> Users</span>
                    <i class="fas fa-chevron-down" :style="open ? 'transform: rotate(180deg)' : ''" style="transition: transform 0.3s; font-size: 0.75rem;"></i>
                </a>
                <div x-show="open" x-transition style="padding-left: 1rem;">
                    <a href="{{ route('admin.users.index', ['role' => 'admin']) }}" class="sidebar-link {{ request()->get('role') === 'admin' ? 'active' : '' }}" style="font-size: 0.875rem;">
                        <i class="fas fa-circle" style="font-size: 0.5rem;"></i> Admin
                    </a>
                    <a href="{{ route('admin.users.index', ['role' => 'staff']) }}" class="sidebar-link {{ request()->get('role') === 'staff' ? 'active' : '' }}" style="font-size: 0.875rem;">
                        <i class="fas fa-circle" style="font-size: 0.5rem;"></i> Operator
                    </a>
                </div>
            </div>
        @else
            <div class="sidebar-header">Items Data</div>
            <a href="{{ route('staff.items.index') }}" class="sidebar-link {{ request()->is('*/items*') ? 'active' : '' }}">
                <i class="fas fa-globe"></i> Items
            </a>
            <a href="{{ route('staff.lendings.index') }}" class="sidebar-link {{ request()->is('*/lendings*') ? 'active' : '' }}">
                <i class="fas fa-sync-alt"></i> Lending
            </a>
            <div x-data="{ open: {{ request()->is('*/profile*') ? 'true' : 'false' }} }">
                <a href="javascript:void(0)" @click="open = !open" class="sidebar-link {{ request()->is('*/profile*') ? 'active' : '' }}" style="justify-content: space-between;">
                    <span><i class="fas fa-user"></i> Users</span>
                    <i class="fas fa-chevron-down" :style="open ? 'transform: rotate(180deg)' : ''" style="transition: transform 0.3s; font-size: 0.75rem;"></i>
                </a>
                <div x-show="open" x-transition style="padding-left: 1rem;">
                    <a href="{{ route('staff.profile.edit') }}" class="sidebar-link {{ request()->is('*/profile*') ? 'active' : '' }}" style="font-size: 0.875rem;">
                        <i class="fas fa-circle" style="font-size: 0.5rem;"></i> Edit
                    </a>
                </div>
            </div>
        @endif

        <div style="margin-top: auto; padding: 1rem;">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="sidebar-link" style="width: 100%; border: none; background: transparent; cursor: pointer; text-align: left;">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </button>
            </form>
        </div>
    </div>

    <div class="main-content">
        <header class="top-bar">
            <div style="display: flex; align-items: center; gap: 1.5rem;">
                {{-- <button style="background: none; border: none; font-size: 1.25rem; color: var(--text-muted); cursor: pointer;"><i class="fas fa-bars"></i></button> --}}
                <div style="display: flex; align-items: center; gap: 1rem;">
                    <img src="https://ui-avatars.com/api/?name={{ auth()->user()->name }}&background=EBF4FF&color=7F9CF5" alt="Avatar" style="width: 40px; border-radius: 50%;">
                    <span style="font-weight: 600; font-size: 1.125rem;">Welcome Back, {{ auth()->user()->name }}</span>
                </div>
            </div>
            <div style="display: flex; align-items: center; gap: 2rem;">
                <span style="font-weight: 600; color: var(--text-muted);">{{ now()->format('d F, Y') }}</span>
                <div style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer;">
                    <i class="fas fa-user-circle" style="font-size: 1.5rem;"></i>
                    <span style="font-weight: 600;">{{ auth()->user()->name }}</span>
                    <i class="fas fa-chevron-down" style="font-size: 0.75rem;"></i>
                </div>
            </div>
        </header>

        <div class="content-body animate-fade-in">
            <!-- Breadcrumb / Task Message -->
            <div class="card" style="margin-bottom: 2rem; padding: 1.25rem; font-size: 0.875rem; font-weight: 600;">
                Check menu in sidebar
            </div>

            @if(session('success'))
                <div id="alert-container" style="margin-bottom: 2rem;">
                    <div class="card" style="border-left: 4px solid var(--secondary); display: flex; align-items: center; gap: 0.75rem; padding: 1rem;">
                        <i class="fas fa-check-circle" style="color: var(--secondary);"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            @yield('content')
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                width: '100%'
            });

            // Browser alert for password as requested
            let successMsg = "{{ session('success') }}";
            if (successMsg.includes('Password:')) {
                alert(successMsg);
            }
        });

        // Auto hide alerts
        setTimeout(() => {
            $('#alert-container').fadeOut();
        }, 5000);
    </script>
    @stack('scripts')
</body>
</html>
