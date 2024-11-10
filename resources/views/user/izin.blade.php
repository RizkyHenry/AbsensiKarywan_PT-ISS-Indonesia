<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Request</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        body {
            background-color: #f0f8ff;
        }

        .table-hover tbody tr:hover {
            background-color: #e0f7fa;
        }

        .modal-header {
            border-bottom: 2px solid #0056b3;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #0056b3;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #003d80;
        }

        .btn-warning {
            background-color: #ffc107;
            border-color: #ffca2c;
        }

        .btn-danger {
            background-color: #dc3545;
            border-color: #c82333;
        }

        .table-responsive {
            margin-top: 2rem;
        }

        .table th,
        .table td {
            vertical-align: middle;
        }

        .modal-content {
            width: 90%;
            margin: auto;
            max-width: 400px;
        }

        .sidebar {
            height: 100vh;
            background-color: #007bff;
            padding: 0;
            position: fixed;
            z-index: 1000;
            top: 0;
            left: 0;
            transition: transform 0.3s ease;
            width: 250px;
            transform: translateX(-250px);
        }

        .sidebar.show {
            transform: translateX(0);
        }

        .sidebar h2 {
            padding: 1rem 0;
            text-align: center;
            font-size: 1.5rem;
        }

        .nav-link {
            font-weight: 500;
            color: #fff;
            padding: 10px 15px;
        }

        .btn {
            margin-top: 10px;
        }

        .nav-link:hover {
            color: #f8f9fa;
            background-color: #0056b3;
        }

        .hamburger,
        .close-btn {
            background: none;
            border: none;
            color: #000;
            font-size: 24px;
            cursor: pointer;
            z-index: 1100;
        }

        .hamburger {
            margin-left: -10px;
        }

        .close-btn {
            display: none;
            position: absolute;
            top: 10px;
            right: 10px;
            color: #fff;
        }

        .main-content {
            margin-left: 0;
            transition: margin-left 0.3s ease;
        }

        /* tampilan mobile */
        @media (max-width: 768px) {
            .hamburger {
                margin-left: 0px;
                margin-top: -7%;
                background: blue;
                color: white;
            }

            .close-btn.show {
                display: block;
                color: red;
                margin-top: -30px;
                font-size: 48px;
            }

            .text-primary {
                padding-right: 35%;
            }

        }

        /* Tampilan desktop */
        @media (min-width: 768px) {
            .hamburger {
                display: none;
            }

            .sidebar {
                transform: translateX(0);
            }

            .flex-md-nowrap {
                margin-left: -2%;
            }

        }



        img.logo {
            max-width: 150px;
            margin: 20px auto;
            display: block;
        }

        .alert-success {
            --bs-alert-color: #fff;
            --bs-alert-bg: #253aaa;
            --bs-alert-border-color: #fff;
            z-index: 9999999;
            text-align: center;
        }

        .alert-danger {
            --bs-alert-color: #fff;
            --bs-alert-bg: #f00;
            --bs-alert-border-color: #fff;
            z-index: 9999999;
            text-align: center;
        }

    </style>
</head>
@if ($errors->any())
    <div id="danger-alert" class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if (session('success'))
    <div id="success-alert" class="alert alert-success">
        {{ Session::get('success') }}
    </div>
@endif

<body>
<main id="main-content" class="main-content col-md-9 ms-sm-auto col-lg-10 px-md-4">
        <div
            class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <button class="hamburger" id="hamburger-btn">&#9776;</button>
            <h1 class="text-primary" style="margin-left:30%;">Pengajuan Izin dan Sakit</h1>
        </div>

    <div class="container-fluid">
        <div class="row">
            <nav id="sidebar" class="col-md-3 col-lg-2 bg-primary sidebar">
                <button class="close-btn" id="close-btn">&times;</button>
                <div class="position-sticky pt-3">
                    <img src="logo-iss.jpg" alt="Logo ISS" class="logo">
                    <h2 class="text-center text-white">Request</h2>
                    <ul class="nav flex-column align-items-center">
                        <li class="nav-item">
                            <a class="nav-link text-white" href="formuser">
                                <i class="bi bi-calendar-check"></i> Dashboard
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link text-white" href="absensi">
                                <i class="bi bi-list-check"></i> Absensi
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="kalender">
                                <i class="bi bi-list-check"></i> Kalender Absensi
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="izin">
                                <i class="bi bi-list-check"></i> Request
                            </a>
                        </li>
                        <form action="{{ route('logout') }}" method="POST">@csrf
                            <button type="submit" class="btn btn-danger">Logout</button>
                        </form>
                    </ul>
                </div>
            </nav>

           <!-- Modal Pengajuan -->
           <div class="container my-5">
    <div class="row">
        <!-- Jika menggunakan kolom sidebar, buat jarak di sini -->
        <div class="col-lg-8 offset-lg-2 col-md-10 offset-md-1 col-12">
            
            <form action="{{ route('izin.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" name="username" id="username"
                        value="{{ $user->username }}" readonly>
                </div>

                <div class="mb-3">
                    <label for="jenis_izin" class="form-label">Jenis Pengajuan</label>
                    <select name="jenis_izin" id="jenis_izin" class="form-select" required>
                        <option value="izin">Izin</option>
                        <option value="sakit">Sakit</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="tanggal_mulai" class="form-label">Tanggal Mulai</label>
                    <input type="date" class="form-control" name="tanggal_mulai" id="tanggal_mulai" required>
                </div>

                <div class="mb-3">
                    <label for="tanggal_selesai" class="form-label">Tanggal Selesai</label>
                    <input type="date" class="form-control" name="tanggal_selesai" id="tanggal_selesai" required>
                </div>

                <div class="mb-3">
                    <label for="keterangan" class="form-label">Keterangan</label>
                    <textarea name="keterangan" id="keterangan" class="form-control" rows="3"
                        placeholder="Alasan pengajuan..." required></textarea>
                </div>

                <div class="mb-3">
                    <label for="foto_bukti" class="form-label">Foto Bukti</label>
                    <input type="file" class="form-control" name="foto_bukti" id="foto_bukti" accept="image/*" required>
                </div>

                <button type="submit" class="btn btn-primary">Ajukan Pengajuan</button>
            </form>
        </div>
    </div>
</div>




            <script>
                   //responsive sidebar
            const hamburgerBtn = document.getElementById('hamburger-btn');
            const closeBtn = document.getElementById('close-btn');
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('main-content');

            // Toggle Sidebar untuk mobile
            if (hamburgerBtn) {
                hamburgerBtn.addEventListener('click', function () {
                    sidebar.classList.add('show');
                    closeBtn.classList.add('show'); // Menampilkan tombol close
                });
            }

            if (closeBtn) {
                closeBtn.addEventListener('click', function () {
                    sidebar.classList.remove('show');
                    closeBtn.classList.remove('show'); // Menyembunyikan tombol close
                });
            }




            //alert 
            document.addEventListener('DOMContentLoaded', function () {
                // Mendapatkan elemen alert dengan ID yang berbeda
                const successAlert = document.getElementById('success-alert');
                const dangerAlert = document.getElementById('danger-alert');

                // Mengecek jika elemen successAlert ada
                if (successAlert) {
                    // Mengatur timer untuk menghapus elemen setelah 2 detik (2000 milidetik)
                    setTimeout(function () {
                        successAlert.remove();
                    }, 2000);
                }

                // Mengecek jika elemen dangerAlert ada
                if (dangerAlert) {
                    // Mengatur timer untuk menghapus elemen setelah 2 detik (2000 milidetik)
                    setTimeout(function () {
                        dangerAlert.remove();
                    }, 2000);
                }
            });


            </script>

            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
                integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
                crossorigin="anonymous"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>

</body>

</html>