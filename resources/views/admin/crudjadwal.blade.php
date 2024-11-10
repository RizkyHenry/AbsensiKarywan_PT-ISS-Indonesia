<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crud Jabatan</title>
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
                margin-left: -14px;
                margin-top: -35px;
                background: blue;
                color: white;
            }

            .close-btn.show {
                display: block;
                color: red;
                margin-top: -30px;
                font-size: 48px;
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
                    <img src="logo-iss.jpg" alt="Logo ISS" class="logo">
                    <h2 class="text-center text-white">Dashboard Admin</h2>
                    <ul class="nav flex-column align-items-center">
                        <li class="nav-item">
                            <a class="nav-link text-white" href="dashboard">
                                <i class="bi bi-calendar-check"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="karyawan">
                                <i class="bi bi-list-check"></i> Crud Karyawan
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="jabatan">
                                <i class="bi bi-list-check"></i> Crud Jabatan
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="jadwal">
                                <i class="bi bi-list-check"></i> Crud Jadwal
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="../terimarequest/{{ $user->id }}">
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
                    <h1 class="text-primary" style="margin-left:30px;">Crud Jadwal</h1>
                </div>

                <div class="col-md-9 col-lg-10 px-md-4">
                    <button class="btn btn-primary mb-3" data-bs-toggle="modal"
                        data-bs-target="#tambahJadwalModal">Tambah Jadwal</button>

                    <!-- Tabel Jadwal -->
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="bg-primary text-white">
                                <tr>
                                    <th>ID</th>
                                    <th>Jabatan</th>
                                    <th>Jadwal Hadir</th>
                                    <th>Jadwal Pulang</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($jadwals as $jadwal)
                                    <tr>
                                        <td>{{ $jadwal->id_jadwal }}</td>
                                        <td>{{ $jadwal->jabatan->jabatan }}</td>
                                        <td>{{ $jadwal->jadwal_hadir }}</td>
                                        <td>{{ $jadwal->jadwal_pulang }}</td>
                                        <td>
                                            <button class="btn btn-warning btn-edit" data-id="{{ $jadwal->id_jadwal }}"
                                                data-jabatan-id="{{ $jadwal->id_jabatan }}"
                                                data-jadwal-hadir="{{ $jadwal->jadwal_hadir }}"
                                                data-jadwal-pulang="{{ $jadwal->jadwal_pulang }}" data-bs-toggle="modal"
                                                data-bs-target="#editJadwalModal">
                                                Edit
                                            </button>

                                            <form action="{{ route('jadwal.destroy', $jadwal->id_jadwal) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
            </main>
        </div>
    </div>

    <!-- Modal Tambah Jadwal -->
    <div class="modal fade" id="tambahJadwalModal" tabindex="-1" aria-labelledby="tambahJadwalModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahJadwalModalLabel">Tambah Jadwal</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('jadwal.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="jabatan" class="form-label">Pilih Jabatan</label>
                            <select name="id_jabatan" id="jabatan" class="form-select">
                                <option value="" disabled selected>Pilih Jabatan</option>
                                @foreach($jabatans as $jabatan)
                                    <option value="{{ $jabatan->id_jabatan }}">{{ $jabatan->jabatan }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="jadwal_hadir" class="form-label">Jadwal Hadir</label>
                            <input type="time" class="form-control" id="jadwal_hadir" name="jadwal_hadir" required
                                step="60">
                        </div>
                        <div class="mb-3">
                            <label for="jadwal_pulang" class="form-label">Jadwal Pulang</label>
                            <input type="time" class="form-control" id="jadwal_pulang" name="jadwal_pulang" required
                                step="60">
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
<!-- Modal Edit Jadwal -->
<div class="modal fade" id="editJadwalModal" tabindex="-1" aria-labelledby="editJadwalModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editJadwalModalLabel">Edit Jadwal</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editJadwalForm" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="edit_jabatan" class="form-label">Pilih Jabatan</label>
                        <select name="id_jabatan" id="edit_jabatan" class="form-select">
                            <option value="" disabled selected>Pilih Jabatan</option>
                            @foreach($jabatans as $jabatan)
                                <option value="{{ $jabatan->id_jabatan }}">{{ $jabatan->jabatan }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="edit_jadwal_hadir" class="form-label">Jadwal Hadir</label>
                        <input type="time" class="form-control" id="edit_jadwal_hadir" name="jadwal_hadir" required step="60">
                    </div>

                    <div class="mb-3">
                        <label for="edit_jadwal_pulang" class="form-label">Jadwal Pulang</label>
                        <input type="time" class="form-control" id="edit_jadwal_pulang" name="jadwal_pulang" required step="60">
                    </div>

                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- JavaScript to Fill Modal with Correct Data -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const editButtons = document.querySelectorAll('.btn-edit');
        const editForm = document.getElementById('editJadwalForm');
        const jabatanSelect = document.getElementById('edit_jabatan');
        const jadwalHadirInput = document.getElementById('edit_jadwal_hadir');
        const jadwalPulangInput = document.getElementById('edit_jadwal_pulang');

        editButtons.forEach(button => {
            button.addEventListener('click', function () {
                const id = this.getAttribute('data-id');
                const jabatanId = this.getAttribute('data-jabatan-id');
                const jadwalHadir = this.getAttribute('data-jadwal-hadir');
                const jadwalPulang = this.getAttribute('data-jadwal-pulang');

                // Update form action URL to include the correct id
                editForm.action = `/crudjadwal/${id}`;

                // Set form values based on the selected jadwal data
                jabatanSelect.value = jabatanId;
                jadwalHadirInput.value = jadwalHadir;
                jadwalPulangInput.value = jadwalPulang;
            });
        });
    });
</script>
    <script>





        // Handling sidebar toggle
        const sidebar = document.getElementById('sidebar');
        const hamburgerBtn = document.getElementById('hamburger-btn');
        const closeBtn = document.getElementById('close-btn');

        hamburgerBtn.addEventListener('click', () => {
            sidebar.classList.toggle('show');
            document.getElementById('main-content').classList.toggle('shift');
        });

        closeBtn.addEventListener('click', () => {
            sidebar.classList.remove('show');
            document.getElementById('main-content').classList.remove('shift');
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
</body>

</html>