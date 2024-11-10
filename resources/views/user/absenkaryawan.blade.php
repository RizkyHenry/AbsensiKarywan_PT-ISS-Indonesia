<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Absensi Karyawan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.2.3/css/bootstrap.min.css">

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
                margin-top: -43px;
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

        .alert alert-danger {
            --bs-alert-color: #fff;
            --bs-alert-bg: #f00;
            --bs-alert-border-color: #fff;
            z-index: 9999999;
            text-align: center;
        }

        /* Card style for modal */
        .card {
            border: none;
        }
    </style>
</head>

<body>
    @if ($errors->any())
        <div id="danger-alert" class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if (session('success'))
        <div id="success-alert" class="alert alert-success">
            {{ Session::get('success') }}
        </div>
    @endif



    <main id="main-content" class="main-content col-md-9 ms-sm-auto col-lg-10 px-md-4">
        <div
            class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <button class="hamburger" id="hamburger-btn">&#9776;</button>
            <h1 class="text-primary" style="margin-left:30px;">Absensi</h1>
        </div>


        <div class="container-fluid">
            <div class="row">
                <nav id="sidebar" class="col-md-3 col-lg-2 bg-primary sidebar">
                    <button class="close-btn" id="close-btn">&times;</button>
                    <div class="position-sticky pt-3">
                        <img src="logo-iss.jpg" alt="Logo ISS" class="logo">
                        <h2 class="text-center text-white">Absen Karyawan</h2>
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

                <div class="main-content col">
                    <div class="container">
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">Klik Untuk
                            Absensi</button>

                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="bg-primary text-white">
                                    <tr>
                                        <th>Username</th>
                                        <th>Jabatan</th>
                                        <th>Kehadiran</th>
                                        <th>Tanggal Absen</th>
                                        <th>Detail</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($absensi as $item)
                                        @if (is_object($item)) <!-- Check if $item is an object -->
                                            <tr>
                                                <td>{{ $item->user->username }}</td>
                                                <td>{{ $item->jabatan->jabatan ?? 'Jabatan tidak ditemukan' }}</td>
                                                <td>{{ $item->kehadiran_absen }}</td>
                                                <td>{{ $item->tanggal_absen }}</td>
                                                <td>
                                                    @if($item->id_detail)
                                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                                            data-bs-target="#detailModal"
                                                            data-foto="./storage/{{ $item->detail->foto_selfie }}"
                                                            data-hadir_datang="{{ $item->detail->hadir_datang }}"
                                                            data-hadir_pulang="{{ $item->detail->hadir_pulang }}"
                                                            data-id_jabatan="{{ $item->jabatan->id_jabatan }}">
                                                            <small style="color:white;">Lihat detail</small>
                                                        </button>
                                                    @else
                                                        Detail tidak ditemukan
                                                    @endif

                                                    <!-- Button absen pulang  -->
                                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                                        data-bs-target="#pulangModal" data-id="{{ $item->id_absensi }}">
                                                        Absen Pulang
                                                    </button>
                                                </td>
                                            </tr>
                                        @else
                                            <p>Data absensi tidak tersedia</p> <!-- If item is not an object -->
                                        @endif
                                    @empty
                                        <p>Belum ada data absensi untuk pengguna ini.</p>
                                        <!-- If the $absensi collection is empty -->
                                    @endforelse


                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Modal Create -->
                <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="createModalLabel">Tambah Absensi</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>

                            <div class="modal-body">
                                <form action="{{ route('absensi.store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="id_jabatan" class="form-label">Jabatan</label>
                                        <input type="hidden" name="id_jabatan" value="{{ $jabatan->id_jabatan }}">
                                        <input type="text" class="form-control" value="{{ $jabatan->jabatan }}"
                                            readonly>
                                    </div>
                                    <div class="mb-3">
                                        <label for="username" class="form-label">Username</label>
                                        <input type="text" class="form-control" name="username" id="username"
                                            value="{{ $user->username }}" readonly>
                                    </div>
                                    <div class="mb-3">
                                        <label for="kehadiran_absen" class="form-label">Kehadiran</label>
                                        @php
                                            $currentTime = Carbon\Carbon::now('Asia/Jakarta');
                                            $hadirThreshold = Carbon\Carbon::parse($latestJadwal->jadwal_hadir, 'Asia/Jakarta');
                                            //telatThreshold artinya maximal waktu telat sampai jam 12.00
                                            $telatThreshold = $hadirThreshold->copy()->setTime(10, 0, 0);
                                            //alphaThreshold artinya lewat dari waktu 12.00 menandakan alpa
                                            $alphaThreshold = $hadirThreshold->copy()->setTime(24, 0, 0);
                                        @endphp

                                        <input type="text" class="form-control" name="kehadiran_absen"
                                            id="kehadiran_absen" value="{{ $currentTime->lessThanOrEqualTo($hadirThreshold) ? 'hadir' :
    ($currentTime->between($hadirThreshold, $telatThreshold) ? 'telat' : 'alpha') }}" readonly>
                                    </div>

                                    <div class="mb-3">
                                        <label for="tanggal_absen" class="form-label">Tanggal Absen</label>
                                        <input type="date" class="form-control" name="tanggal_absen_display"
                                            id="tanggal_absen_display" value="{{ now()->format('Y-m-d') }}" readonly>

                                        <input type="hidden" name="tanggal_absen" id="tanggal_absen"
                                            value="{{ now()->format('Y-m-d\TH:i') }}">
                                    </div>

                                    <script>
                                        function updateDateTime() {
                                            const now = new Date();
                                            const date = now.toISOString().slice(0, 10);
                                            const time = now.toTimeString().slice(0, 5);
                                            document.getElementById('tanggal_absen_display').value = date;
                                            document.getElementById('tanggal_absen').value = `${date}T${time}`;
                                        }
                                        setInterval(updateDateTime, 60000);
                                        updateDateTime();
                                    </script>

                                    <div class="mb-3">
                                        <label for="waktu_absen" class="form-label">Waktu Absen</label>
                                        <span id="waktu_absen" class="form-control" readonly></span>
                                    </div>

                                    <script>
                                        function updateTime() {
                                            const waktuElement = document.getElementById('waktu_absen');
                                            const currentTime = new Date();
                                            const formattedTime = currentTime.toLocaleTimeString();
                                            waktuElement.innerText = formattedTime;
                                        }
                                        setInterval(updateTime, 1000);
                                    </script>

                                    <div class="mb-3">
                                        <label for="foto_selfie" class="form-label">Foto Selfie</label>
                                        <input type="file" class="form-control" name="foto_selfie" id="foto_selfie"
                                            accept="image/*" required>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal Detail -->
                <div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="detailModalLabel">Detail Absensi</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3 d-flex flex-column justify-content-center align-items-center">
                                    <label for="foto_selfie" class="form-label align-self-start">Foto Selfie</label>
                                    <img id="modal-foto_selfie" src="" class="img-fluid mt-2" alt="Foto Selfie"
                                        style="max-width: 200px;">
                                </div>

                                <div class="mb-3">
                                    <label for="hadir_datang" class="form-label">Waktu Hadir (Datang)</label>
                                    <input type="text" class="form-control" id="hadir_datang" readonly>
                                </div>
                                <div class="mb-3">
                                    <label for="hadir_pulang" class="form-label">Waktu Hadir (Pulang)</label>
                                    <input type="text" class="form-control" id="hadir_pulang" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal Absen Pulang -->
                <div class="modal fade" id="pulangModal" tabindex="-1" aria-labelledby="pulangModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="pulangModalLabel">Absen Pulang</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">

                                <form action="{{ route('absensi.store.pulang') }}" method="POST">
                                    @csrf
                                    <!-- Input hidden untuk id_absensi -->
                                    @if($absensi->isNotEmpty())
                                        @foreach($absensi as $item)
                                            <!-- Jika id_absensi ada, tampilkan input tersembunyi -->
                                            <input type="hidden" name="id_absensi" value="{{ $item->id_absensi }}"
                                                id="id_absensi">
                                        @endforeach
                                    
                                    @endif

                                    <div class="mb-3">
                                        <label for="waktu_pulang" class="form-label">Waktu pulang</label>
                                        <input type="datetime-local" class="form-control" name="waktu_pulang"
                                            id="waktu_pulang" readonly>
                                    </div>

                                    <script>
                                        // Update waktu real-time
                                        function updateTime() {
                                            const currentTime = new Date();
                                            const waktuElement = document.getElementById('waktu_pulang');

                                            // Format the current time as "YYYY-MM-DDTHH:MM" for `datetime-local` input
                                            const formattedDateTime = currentTime.toLocaleString("sv-SE", {
                                                year: "numeric",
                                                month: "2-digit",
                                                day: "2-digit",
                                                hour: "2-digit",
                                                minute: "2-digit",
                                                second: "2-digit",
                                                hour12: false
                                            }).replace(" ", "T");

                                            waktuElement.value = formattedDateTime;
                                        }

                                        setInterval(updateTime, 1000);

                                        // Absen pulang 
                                        $('#pulangModal').on('show.bs.modal', function (event) {
                                            var button = $(event.relatedTarget); // Tombol yang memanggil modal
                                            var idAbsensi = button.data('id'); // Ambil data-id dari tombol
                                            var modal = $(this);
                                            modal.find('#id_absensi').val(idAbsensi); // Isi input hidden dengan id_absensi
                                        });
                                    </script>

                                    <button type="submit" class="btn btn-danger">Konfirmasi Pulang</button>
                                </form>



                                <script>
                                    //tampilan model
                                    const detailModal = document.getElementById('detailModal');
                                    detailModal.addEventListener('show.bs.modal', event => {
                                        const button = event.relatedTarget;
                                        const fotoSelfie = button.getAttribute('data-foto');
                                        const hadirDatang = button.getAttribute('data-hadir_datang');
                                        const hadirPulang = button.getAttribute('data-hadir_pulang');

                                        const modalFotoSelfie = detailModal.querySelector('#modal-foto_selfie');
                                        const modalHadirDatang = detailModal.querySelector('#hadir_datang');
                                        const modalHadirPulang = detailModal.querySelector('#hadir_pulang');

                                        modalFotoSelfie.src = fotoSelfie;
                                        modalHadirDatang.value = hadirDatang;
                                        modalHadirPulang.value = hadirPulang;
                                    });



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
                                        const alert_danger = document.getElementsByClassName('alert-danger')[0];

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
                                        // Mengecek jika elemen alert alert-danger ada
                                        if (alert_danger) {
                                            // Mengatur timer untuk menghapus elemen setelah 2 detik (2000 milidetik)
                                            setTimeout(function () {
                                                alert_danger.remove();
                                            }, 2000);
                                        }
                                    });


                                </script>
                                <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                                <script
                                    src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
                                <script
                                    src="https://stackpath.bootstrapcdn.com/bootstrap/5.2.3/js/bootstrap.bundle.min.js"></script>


</body>

</html>