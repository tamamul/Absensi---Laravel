<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Link ke CSS Bootstrap 4 -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<style>
        body {
            /* Gradasi biru ke putih */
            background: linear-gradient(135deg, #1d3557, #457b9d, #a8dadc);
            height: 100vh;
        }
        .logo {
            max-width: 120px;
            margin-bottom: 20px;
        }
    </style>
<!-- <body class="bg-light"> -->

    <div class="container d-flex justify-content-center align-items-center" style="height: 100vh;">
        <div class="card p-4 shadow-lg" style="width: 400px;">
        <div class="text-center">
        <img src="{{ asset('img/logo.svg.jpg') }}" alt="Logo" class="logo">

                <!-- <img src="{{ asset('img/logo_amp.jpg') }}" alt="Logo" class="logo"> -->

            </div>
            <h2 class="text-center mb-4">Login</h2>

            <!-- Form Login -->
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Input Username -->
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" class="form-control" id="username" name="username" value="{{ old('username') }}" required>
                </div>

                <!-- Input Password -->
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn btn-primary btn-block">Login</button>
            </form>

            <table class="table table-striped mt-3">
            <thead>
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

            <!-- Tampilkan error jika ada -->
            @if ($errors->any())
                <div class="alert alert-danger mt-3">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
    </div>

    <!-- Script untuk Bootstrap 4 JS dan dependensi seperti jQuery dan Popper.js -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
