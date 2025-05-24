@extends('layouts.master')
@section('title', 'atlantis')
@section('content')


    <h1>Welcome Admin!</h1>
    <div class="continer ms-4">
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button class="btn btn-danger" type="submit">Logout</button>
    </form>
    </div>



<!-- <!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <h2>Selamat Datang, Admin!</h2>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-danger mt-3">Logout</button>
        </form>
    </div>
</body>
</html> -->

@endsection
