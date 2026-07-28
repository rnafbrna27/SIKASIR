<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>SIKASIR</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    <style>

        body{
            background:#f4f6f9;
        }

        .sidebar{
            width:250px;
            min-height:100vh;
            background:#212529;
        }

        .sidebar a{
            color:white;
            text-decoration:none;
            display:block;
            padding:12px 20px;
        }

        .sidebar a:hover{
            background:#343a40;
        }

        .content{
            flex:1;
            padding:25px;
        }

        .navbar-brand{
            font-weight:bold;
        }

    </style>

</head>

<body>

<div class="d-flex">

    <div class="sidebar">

        <div class="text-center text-white py-4">

            <h3>SIKASIR</h3>

            <small>Sistem Kasir</small>

        </div>

        <hr class="text-secondary">

        <a href="{{ route('dashboard') }}">
            <i class="bi bi-speedometer2"></i>
            Dashboard
        </a>

        <a href="{{ route('categories.index') }}">
            <i class="bi bi-tags"></i>
            Kategori
        </a>

        <a href="{{ route('services.index') }}">
            <i class="bi bi-box"></i>
            Layanan
        </a>

        <a href="{{ route('transactions.index') }}">
            <i class="bi bi-cart"></i>
            Transaksi
        </a>

        <a href="{{ route('transactions.report') }}">
            <i class="bi bi-file-earmark-bar-graph"></i>
            Laporan
        </a>

        <hr class="text-secondary">

        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button class="btn btn-danger w-100 rounded-0">
                Logout
            </button>

        </form>

    </div>


    <div class="content">

        <nav class="navbar navbar-expand-lg bg-white rounded shadow-sm mb-4">

            <div class="container-fluid">

                <span class="navbar-brand">

                    Sistem Informasi Pencatatan Pemasukan Kasir

                </span>

                <div class="ms-auto">

                    @auth

                        <strong>{{ Auth::user()->name }}</strong>

                    @endauth

                </div>

            </div>

        </nav>

        @if(session('success'))

            <div class="alert alert-success">

                {{ session('success') }}

            </div>

        @endif

        @if(session('error'))

            <div class="alert alert-danger">

                {{ session('error') }}

            </div>

        @endif

        @yield('content')

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

        </main>
    </div>

    @stack('scripts')


</body>
</html>