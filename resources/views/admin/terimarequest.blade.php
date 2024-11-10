<!DOCTYPE html>
<html lang="en">

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

</head>
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
            margin-left: -14px;
            margin-top: -8%;
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
            padding-right: 40px;
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

        .main-content {
            margin-left: 250px;
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
    <div class="container-fluid">
        <div class="row">
            <nav id="sidebar" class="col-md-3 col-lg-2 bg-primary sidebar">
                <button class="close-btn" id="close-btn">&times;</button>
                <div class="position-sticky pt-3">
                    <img src="../logo-iss.jpg" alt="Logo ISS" class="logo">
                    <h2 class="text-center text-white">Crud Jabatan</h2>
                    <ul class="nav flex-column align-items-center">
                        <li class="nav-item">
                            <a class="nav-link text-white" href="../dashboard">
                                <i class="bi bi-calendar-check"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="../karyawan">
                                <i class="bi bi-list-check"></i> Crud Karyawan
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="../jabatan">
                                <i class="bi bi-list-check"></i> Crud Jabatan
                            </a>
                        </li>
                        <li class="nav-item">
                        <a class="nav-link text-white" href="../jadwal">
                            <i class="bi bi-list-check"></i> Crud Jadwal
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="terimarequest">
                            <i class="bi bi-list-check"></i> Requests
                        </a>
                    </li>
                        <form action="{{ route('logout') }}" method="POST">@csrf
                            <button type="submit" class="btn btn-danger">Logout</button>
                        </form>
                    </ul>
                </div>
            </nav>

            <main id="main-content" class="main-content col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div
                    class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <button class="hamburger" id="hamburger-btn">&#9776;</button>
                    <h1 class="text-primary" style="margin-left:30px;">Form Request</h1>
                </div>

                <body>

                    <div class="container my-5">

                      

                        <div class="table-responsive">
                            <table class="table  table-bordered table-hover">
                                <thead class="bg-primary text-white">
                                    <tr>
                                        <th>Request ID</th>
                                        <th>Username</th>
                                        <th>Jenis Pengajuan</th>
                                        <th>Tanggal Mulai</th>
                                        <th>Tanggal Selesai</th>
                                        <th>Keterangan</th>
                                        <th>Status Pengajuan</th>
                                        <th>Foto Bukti</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($allIzin as $izin)
                                        <tr>
                                            <td>{{ $izin->id_izin }}</td>

                                            @foreach($contabsensi as $absen)
                                                @if($absen->id_absensi === $izin->id_absensi)
                                                    @foreach($contuser as $users)
                                                        @if($absen->id === $users->id)
                                                            <td>{{ $users->username }}</td>
                                                            @break
                                                        @endif
                                                    @endforeach
                                                @endif
                                            @endforeach

                                            <td>{{ $izin->jenis_izin }}</td>
                                            <td>{{ $izin->tanggal_mulai }}</td>
                                            <td>{{ $izin->tanggal_selesai }}</td>
                                            <td>{{ $izin->keterangan }}</td>

                                            <td>
                                                <!-- Dropdown untuk mengubah status pengajuan -->
                                                <form action="{{ route('updateStatus', $izin->id_izin) }}" method="POST"
                                                    class="d-inline-block">
                                                    @csrf
                                                    <select name="status" class="form-control"
                                                        onchange="this.form.submit()">
                                                        <option value="Direquest" {{ $izin->status == 'Direquest' ? 'selected' : '' }}>Direquest</option>
                                                        <option value="Diterima" {{ $izin->status == 'Diterima' ? 'selected' : '' }}>Diterima</option>
                                                        <option value="Ditolak" {{ $izin->status == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                                                    </select>
                                                </form>
                                            </td>
                                            <td>
                                                @if($izin->foto_bukti)
                                                    <button 
                                                        class="img-thumbnail" style="cursor: pointer;" data-bs-toggle="modal"
                                                        data-bs-target="#fotoModal"
                                                        onclick="showImage('{{ asset('/' . $izin->foto_bukti) }}')">Bukti Foto</button>
                                                @else
                                                    <p>Bukti izin tidak tersedia.</p>
                                                @endif
                                                <!-- Modal untuk menampilkan gambar -->
                                                <div class="modal fade" id="fotoModal" tabindex="-1"
                                                    aria-labelledby="fotoModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="fotoModalLabel">Bukti Foto</h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <!-- Gambar akan dimasukkan ke sini menggunakan JavaScript -->
                                                                <img class="w-100" id="modalImage" src="" alt="Bukti Izin"
                                                                    class="img-fluid">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>

                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>


                    <!-- Modal Update Status -->
                    <div class="modal fade" id="updateStatusModal" tabindex="-1"
                        aria-labelledby="updateStatusModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="updateStatusModalLabel">Update Status Pengajuan</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form id="updateStatusForm" method="POST" action="" onsubmit="updateFormAction()">
                                        @csrf
                                        <input type="hidden" name="id_izin" id="izinIdInput">
                                        <div class="mb-3">
                                            <label for="statusSelect" class="form-label">Pilih Status Baru</label>
                                            <select class="form-select" name="status" id="statusSelect">
                                                <option value="Disetujui">Diterima</option>
                                                <option value="Ditolak">Ditolak</option>
                                            </select>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <script>
                        function showImage(imageUrl) {
                            const buktiImage = document.getElementById('modalImage');
                            buktiImage.src = imageUrl;
                        }
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

                        document.addEventListener('DOMContentLoaded', function () {
                            const editButtons = document.querySelectorAll('.btn-edit');
                            editButtons.forEach(button => {
                                button.addEventListener('click', function () {
                                    const id = this.dataset.id;
                                    const jabatan = this.dataset.jabatan;

                                    document.getElementById('editJabatan').value = jabatan;
                                    document.getElementById('formEditJabatan').action = `/jabatan/${id}`;
                                });
                            });
                        });




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
                    <script
                        src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>

                    <script>
                        

                    </script>


                </body>

</html>