<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventaris Sekolah - Selamat Datang</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite(['resources/css/app.css'])
    <style>
        body {
            overflow-x: hidden;
            background: #fff;
        }
        .hero {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 10%;
            background: radial-gradient(circle at 10% 20%, rgba(79, 70, 229, 0.05) 0%, rgba(255,255,255,1) 50%);
        }
        .hero-text {
            max-width: 600px;
        }
        .hero-text h1 {
            font-size: 4rem;
            font-weight: 800;
            line-height: 1.1;
            margin-bottom: 1.5rem;
            color: var(--text-main);
        }
        .hero-text p {
            font-size: 1.25rem;
            color: var(--text-muted);
            margin-bottom: 2rem;
        }
        .hero-image {
            width: 45%;
            position: relative;
        }
        .hero-image img {
            width: 100%;
            border-radius: 30px;
            box-shadow: var(--shadow-lg);
            animation: float 6s ease-in-out infinite;
        }
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
            100% { transform: translateY(0px); }
        }
        nav {
            position: fixed;
            top: 0;
            width: 100%;
            padding: 2rem 10%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            z-index: 100;
        }
    </style>
</head>
<body>
    <nav class="glass">
        <div style="font-size: 1.5rem; font-weight: 700; color: var(--primary);">
            <i class="fas fa-boxes-stacked"></i> INVENTARIS
        </div>
        <button onclick="showLogin()" class="btn btn-primary">
            <i class="fas fa-sign-in-alt"></i> Login
        </button>
    </nav>

    <section class="hero">
        <div class="hero-text animate-fade-in">
            <h1>Kelola Aset Sekolah dengan <span style="color: var(--primary);">Cerdas.</span></h1>
            <p>Sistem inventarisasi modern untuk mempermudah peminjaman, pemantauan stok, dan pelaporan barang secara real-time.</p>
            <div style="display: flex; gap: 1rem;">
                <button onclick="showLogin()" class="btn btn-primary" style="padding: 1rem 2rem; font-size: 1rem;">Mulai Sekarang</button>
                <button class="btn btn-secondary" style="padding: 1rem 2rem; font-size: 1rem; background: transparent; border: 1px solid var(--border); color: var(--text-main);">Pelajari Lebih Lanjut</button>
            </div>
        </div>
        <div class="hero-image">
            <img src="https://images.unsplash.com/photo-1586528116311-ad8dd3c8310d?auto=format&fit=crop&q=80&w=1000" alt="Inventory">
        </div>
    </section>

    <!-- Modal Login -->
    <div id="loginModal" class="modal-backdrop {{ session('show_login_modal') || $errors->any() ? 'show' : '' }}">
        <div class="modal-content">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
                <h2 style="font-size: 1.5rem; font-weight: 700;">Login ke Akun Anda</h2>
                <button onclick="hideLogin()" style="background: none; border: none; font-size: 1.25rem; cursor: pointer; color: var(--text-muted);"><i class="fas fa-times"></i></button>
            </div>

            @if($errors->any())
                <div style="background: #fef2f2; border: 1px solid #fee2e2; padding: 1rem; border-radius: var(--radius); margin-bottom: 1.5rem; color: var(--danger); font-size: 0.875rem;">
                    @foreach($errors->all() as $error)
                        <p><i class="fas fa-exclamation-triangle"></i> {{ $error }}</p>
                    @endforeach
                </div>
            @endif

            @if(session('error'))
                <div style="background: #fef2f2; border: 1px solid #fee2e2; padding: 1rem; border-radius: var(--radius); margin-bottom: 1.5rem; color: var(--danger); font-size: 0.875rem;">
                    <p><i class="fas fa-exclamation-triangle"></i> {{ session('error') }}</p>
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label class="form-label">Email Address</label>
                    <input type="email" name="email" class="form-control" placeholder="example@mail.com" required value="{{ old('email') }}">
                </div>
                <div class="form-group">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                </div>
                <button type="submit" class="btn btn-primary" style="width: 100%; padding: 1rem; font-size: 1rem; margin-top: 1rem;">
                    Masuk
                </button>
            </form>
        </div>
    </div>

    <script>
        function showLogin() {
            document.getElementById('loginModal').classList.add('show');
        }
        function hideLogin() {
            document.getElementById('loginModal').classList.remove('show');
        }

        // Close modal on backdrop click
        document.getElementById('loginModal').addEventListener('click', function(e) {
            if (e.target === this) hideLogin();
        });
    </script>
</body>
</html>
