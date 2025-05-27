<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Absensi - Welcome</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <!-- Styles -->
    <style>
        /* Basic Reset */
        body, html {
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
            background-color: #f4f7f6;
            color: #333;
            line-height: 1.6;
            scroll-behavior: smooth;
        }
        .container {
            width: 90%;
            max-width: 1200px;
            margin: auto;
            overflow: hidden;
            padding: 0 20px;
        }
        /* Navigation */
        nav {
            background: #fff;
            color: #333;
            padding: 1rem 0;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
        }
        nav .container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        nav a {
            color: #333;
            text-decoration: none;
            font-weight: 600;
        }
        nav .logo {
            font-size: 1.5rem;
            font-weight: 700;
            color: #2a9d8f; /* A nice teal color */
        }
        nav ul {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            align-items: center;
        }
        nav ul li {
            margin-left: 20px;
        }
        nav ul li a:not(.btn) {
             padding: 5px 10px;
        }
        nav ul li a:not(.btn):hover {
            color: #e76f51; /* A contrasting accent color */
        }

        /* Hero Section */
        .hero {
            background: linear-gradient(rgba(42, 157, 143, 0.8), rgba(42, 157, 143, 0.9)), url('https://source.unsplash.com/random/1920x1080/?technology,office') no-repeat center center/cover;
            /* Replace with your actual image or use a solid color: background: #2a9d8f; */
            color: #fff;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding-top: 80px; /* Account for fixed navbar height */
            box-sizing: border-box;
        }
        .hero-content h1 {
            font-size: 3.5rem;
            margin-bottom: 1rem;
            font-weight: 700;
        }
        .hero-content p {
            font-size: 1.2rem;
            margin-bottom: 2rem;
            font-weight: 300;
            max-width: 700px;
            margin-left: auto;
            margin-right: auto;
        }
        .btn {
            display: inline-block;
            background: #e76f51;
            color: #fff !important; /* Ensure text color is white */
            padding: 12px 25px;
            text-decoration: none;
            border-radius: 5px;
            font-weight: 600;
            transition: background-color 0.3s ease, transform 0.2s ease;
            border: none;
            cursor: pointer;
        }
        .btn:hover {
            background: #d15a39;
            transform: translateY(-2px);
        }
        .btn-secondary {
            background: #fff;
            color: #2a9d8f !important; /* Ensure text color */
            margin-left: 10px;
            border: 1px solid #2a9d8f;
        }
        .btn-secondary:hover {
            background: #e9f5f3;
        }

        /* Sections */
        .section {
            padding: 80px 0;
            text-align: center;
        }
        .section-light {
            background: #fff;
        }
        .section-dark {
            background: #e9f5f3; /* Light teal background */
        }
        .section h2 {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            color: #264653; /* Darker teal/blue */
        }
        .section .lead {
            font-size: 1.1rem;
            color: #555;
            max-width: 700px;
            margin: 0 auto 40px auto;
        }

        /* Features Section */
        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 30px;
            margin-top: 40px;
        }
        .feature-item {
            background: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            text-align: left;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .feature-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.12);
        }
        .feature-item i {
            font-size: 2.5rem;
            color: #2a9d8f;
            margin-bottom: 15px;
            display: block;
        }
        .feature-item h3 {
            font-size: 1.5rem;
            color: #264653;
            margin-bottom: 10px;
        }
        .feature-item p {
            font-size: 0.95rem;
            color: #555;
        }

        /* Call to Action Section */
        .cta {
            background: #264653;
            color: #fff;
        }
        .cta h2 {
            color: #fff;
        }
        .cta p {
            font-size: 1.2rem;
            margin-bottom: 2rem;
        }

        /* Footer */
        footer {
            background: #333;
            color: #fff;
            text-align: center;
            padding: 2rem 0;
        }
        footer p {
            margin: 0.5rem 0;
        }

        /* Responsive */
        @media(max-width: 768px) {
            nav .container {
                flex-direction: column;
            }
            nav .logo {
                margin-bottom: 10px;
            }
            nav ul {
                margin-top: 10px;
                flex-direction: column;
                align-items: center;
                width: 100%;
            }
            nav ul li {
                margin: 8px 0;
                width: 100%;
                text-align: center;
            }
            nav ul li a.btn {
                display: block;
                width: auto;
                margin: 5px auto;
            }
            .hero-content h1 {
                font-size: 2.5rem;
            }
            .hero-content p {
                font-size: 1rem;
            }
            .section h2 {
                font-size: 2rem;
            }
        }
    </style>
    <!-- Font Awesome for icons (optional, replace with your preferred icon library or SVGs) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
    <nav>
        <div class="container">
            <a href="{{ url('/') }}" class="logo">Sistem Absensi</a>
            <ul>
                <li><a href="#features">Fitur</a></li>
                <li><a href="#about">Tentang Kami</a></li>
                <li><a href="#contact">Hubungi Kami</a></li>
                @if (Route::has('login'))
                    @auth
                        <li><a href="{{ Auth::user()->role === 'Admin' ? url('/admin/dashboard') : url('/pimpinan/dashboard') }}" class="btn btn-secondary">Dashboard</a></li>
                    @else
                        <li><a href="{{ route('login') }}" class="btn">Log In</a></li>
                        @if (Route::has('register'))
                            <li><a href="{{ route('register') }}" class="btn btn-secondary" style="margin-left:0; margin-top: 5px;">Register</a></li>
                        @endif
                    @endauth
                @endif
            </ul>
        </div>
    </nav>

    <header class="hero">
        <div class="hero-content container">
            <h1>Selamat Datang di Sistem Absensi</h1>
            <p>Platform Manajemen Absensi Canggih untuk operasional yang lancar dan produktivitas yang meningkat.</p>
            <a href="{{ route('login') }}" class="btn">Mulai Sekarang</a>
            <a href="#features" class="btn btn-secondary">Pelajari Lebih Lanjut</a>
        </div>
    </header>

    <section id="features" class="section section-light">
        <div class="container">
            <h2>Fitur Utama</h2>
            <p class="lead">Temukan berbagai alat dan fungsionalitas canggih yang ditawarkan Sistem Absensi untuk menyederhanakan manajemen kehadiran Anda.</p>
            <div class="features-grid">
                <div class="feature-item">
                    <i class="fas fa-cogs"></i>
                    <h3>Manajemen Absensi Efisien</h3>
                    <p>Kelola semua data kehadiran, jadwal, dan laporan dari dasbor terpusat dengan kontrol yang intuitif.</p>
                </div>
                <div class="feature-item">
                    <i class="fas fa-chart-line"></i>
                    <h3>Analitik Kehadiran Mendalam</h3>
                    <p>Dapatkan wawasan berharga dengan laporan dan analitik komprehensif untuk membuat keputusan berbasis data terkait kehadiran.</p>
                </div>
                <div class="feature-item">
                    <i class="fas fa-users"></i>
                    <h3>Pemantauan Real-time</h3>
                    <p>Pantau status kehadiran secara langsung dan dapatkan notifikasi instan untuk setiap aktivitas absensi.</p>
                </div>
                 <div class="feature-item">
                    <i class="fas fa-shield-alt"></i>
                    <h3>Aman & Andal</h3>
                    <p>Dibangun dengan mengutamakan keamanan, memastikan data Anda aman dan platform selalu tersedia untuk digunakan.</p>
                </div>
            </div>
        </div>
    </section>

    <section id="about" class="section section-dark">
        <div class="container">
            <h2>Tentang Sistem Absensi</h2>
            <p class="lead">Kami berdedikasi untuk menyediakan solusi manajemen absensi terbaik untuk bisnis modern. Platform kami dirancang agar kuat, dapat diskalakan, dan mudah digunakan, membantu Anda mencapai tujuan efisiensi kehadiran.</p>
            <p>Dengan pengalaman bertahun-tahun di industri ini, Sistem Absensi dibangun di atas fondasi inovasi dan desain yang berpusat pada pengguna. Kami terus berupaya untuk meningkatkan dan beradaptasi dengan kebutuhan pengguna kami yang terus berkembang.</p>
        </div>
    </section>

    <section id="contact" class="section cta">
        <div class="container">
            <h2>Siap Meningkatkan Manajemen Absensi Anda?</h2>
            <p>Bergabunglah dengan ribuan pengguna yang puas dan transformasikan cara Anda mengelola kehadiran.</p>
            <a href="{{ Route::has('register') ? route('register') : route('login') }}" class="btn">Daftar Sekarang</a>
        </div>
    </section>

    <footer>
        <div class="container">
            <p>&copy; {{ date('Y') }} Absensi System. Hak Cipta Dilindungi.</p>
            <p>Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})</p>
        </div>
    </footer>

</body>
</html>
