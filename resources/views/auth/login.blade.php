<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Link ke CSS Bootstrap 4 -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #1d3557, #457b9d, #a8dadc);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #333;
        }
        .card {
            background-color: rgba(255, 255, 255, 0.9); /* Slightly transparent card */
            border: none;
            border-radius: 8px;
            box-shadow: 0 5px 25px rgba(0,0,0,0.15);
        }
        .card-header {
            background-color: transparent;
            border-bottom: none;
        }
        .logo-icon {
            font-size: 4rem; /* Ukuran ikon */
            color: #2a9d8f; /* Warna ikon (teal, sama seperti di landing page) */
            margin-bottom: 20px;
            display: block; /* Agar margin-bottom bekerja dengan baik */
        }
        .card-title {
            font-weight: 600;
            font-size: 1.8rem; /* Slightly smaller title */
            margin-bottom: 5px; /* Reduce space below title */
        }
        .card-subtitle {
            color: #264653; /* Darker teal/blue from landing page */
        }
        .form-control {
            border-radius: 0.25rem;
        }
        .btn-primary {
            background-color: #e76f51; /* Orange/coral from landing page */
            border-color: #e76f51;
            font-weight: 600;
        }
        .btn-primary:hover {
            background-color: #d15a39;
            border-color: #d15a39;
        }
        .btn-outline-secondary {
            color: #2a9d8f; /* Teal from landing page */
            border-color: #2a9d8f;
        }
        .btn-outline-secondary:hover {
            background-color: #2a9d8f;
            color: #fff;
        }
        #credentialsTable {
            display: none; /* Sembunyikan tabel secara default */
        }
    </style>
<body>
    <div class="container">
        <div class="card p-4 mx-auto" style="max-width: 420px;">
            <div class="text-center">
                <i class="fas fa-fingerprint logo-icon"></i> 
            </div>
            <div class="text-center mb-4">
                <h2 class="card-title">Login Sistem AMP</h2>
                <p class="card-subtitle text-muted">Masuk ke akun Anda</p>
            </div>

            <!-- Form Login -->
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Input Username -->
                <div class="form-group">
                    <label for="username" class="font-weight-semibold">Username</label>
                    <input type="text" class="form-control" id="username" name="username" value="{{ old('username') }}" required>
                    @error('username')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <!-- Input Password -->
                <div class="form-group">
                    <label for="password" class="font-weight-semibold">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                     @error('password')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <!-- Remember Me & Forgot Password (Optional) -->
                {{-- <div class="form-group d-flex justify-content-between align-items-center">
                    <div class="form-check">
                        <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }} class="form-check-input">
                        <label class="form-check-label" for="remember">Ingat Saya</label>
                    </div>
                    @if (Route::has('password.request'))
                        <a class="btn btn-link p-0" href="{{ route('password.request') }}">Lupa Password?</a>
                    @endif
                </div> --}}

                <!-- Submit Button -->
                <button type="submit" class="btn btn-primary btn-block mt-4">Login</button>
            </form>

            <div class="text-center mt-3">
                <button id="toggleCredentialsBtn" class="btn btn-sm btn-outline-secondary">Tampilkan Kredensial Demo</button>
            </div>

            <div id="credentialsTable" class="mt-3">
                <p class="text-muted text-center small">Gunakan kredensial berikut untuk demo:</p>
                <table class="table table-sm table-bordered table-hover">
                    <thead class="thead-light">
                        <tr>
                            <th>Username</th>
                            <th>Password</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>admin</td>
                            <td>password123</td>
                        </tr>
                        <tr>
                            <td>pimpinan</td>
                            <td>password123</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            {{-- Error messages are now handled directly below the input fields using @error directive --}}
            {{-- If you have non-field specific errors, the $errors->any() block might still be useful --}}
            {{-- For example, if login fails due to invalid credentials, Laravel typically adds an error for 'username' or 'email' --}}
            {{-- If you have other types of errors, keep the $errors->any() block --}}

            <div class="text-center mt-4">
                <a href="{{ url('/') }}" class="text-muted small"><i class="fas fa-arrow-left"></i> Kembali ke Beranda</a>
            </div>
        </div>
    </div>

    <!-- Script untuk Bootstrap 4 JS dan dependensi seperti jQuery dan Popper.js -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        document.getElementById('toggleCredentialsBtn').addEventListener('click', function() {
            var table = document.getElementById('credentialsTable');
            if (table.style.display === 'none' || table.style.display === '') {
                table.style.display = 'block';
                this.textContent = 'Sembunyikan Kredensial Demo';
            } else {
                table.style.display = 'none';
                this.textContent = 'Tampilkan Kredensial Demo';
            }
        });
    </script>
</body>