<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crud Karyawan</title>
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

            .text-primary {
                padding-right: 30px;
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
                    <h1 class="text-primary" style="margin-left:30px;">Crud Karyawan</h1>
                </div>

                <div class="col-md-9 col-lg-10 px-md-4">
                    <button class="btn btn-primary mb-3" data-bs-toggle="modal"
                        data-bs-target="#tambahKaryawanModal">Tambah Karyawan</button>

                    @if ($errors->any())
                        <div id="success-alert" class="alert alert-danger fixed fixed-to">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>
                                        {{ $error }}
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <table class="table table-bordered table-hover">
                        <thead class="bg-primary text-white">
                            <tr>
                                <th>Username</th>
                                <th>Role</th>
                                <th>Jabatan</th>
                                <th>NIK</th>
                                <th>Jenis Kelamin</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($karyawan as $item)
                                <tr>
                                    <td>{{ $item->username }}</td>
                                    <td>{{ $item->role }}</td>
                                    <td>{{ $item->jabatan->jabatan ?? 'Tidak Ditemukan' }}</td>
                                    <td>{{ $item->nik }}</td>
                                    <td>{{ $item->kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                                    <td>
                                        <!-- Tombol Edit dan Hapus -->
                                        <button class="btn btn-warning btn-edit" data-id="{{ $item->id }}"
                                            data-nama="{{ $item->username }}" data-role="{{ $item->role }}"
                                            data-jabatan="{{ $item->jabatan->id_jabatan }}" data-nik="{{ $item->nik }}"
                                            data-kelamin="{{ $item->kelamin }}" data-bs-toggle="modal"
                                            data-bs-target="#editKaryawanModal">Edit</button>
                                        <form action="{{ route('karyawan.deletes') }}?id={{ $item->id }}" method="POST"
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

    <!-- Modal Tambah Karyawan -->
    <div class="modal fade" id="tambahKaryawanModal" tabindex="-1" aria-labelledby="tambahKaryawanModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahKaryawanModalLabel">Tambah Karyawan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="formTambahKaryawan" method="POST" action="{{ route('karyawan.store') }}">
                    @csrf
                    @method('post')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="namaKaryawan" class="form-label">Nama Karyawan</label>
                            <input type="text" class="form-control" id="namaKaryawan" name="username" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="password" name="password" required>
                                <button type="button" class="input-group-text" id="togglePasswordTambah"
                                    style="border-left: none;">
                                    <i class="fa fa-eye" id="toggleIconEdit"></i>
                                </button>
                            </div>
                            <small class="form-text text-muted">Masukan minimal 8 digit</small>
                        </div>

                        <div class="mb-3">
                            <label for="role" class="form-label">Role</label>
                            <select placeholder="" class="form-select" id="role" name="role" required>
                                <option value="" disabled selected>Pilih Role</option>
                                <option value="admin">Admin</option>
                                <option value="karyawan">Karyawan</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="jabatan" class="form-label">Jabatan</label>
                            <select placeholder="jabatan" class="form-select" id="jabatan" name="id_jabatan" required>
                                <option value="" disabled selected>Pilih Jabatan</option>
                                @foreach($jabatans as $jabatan)

                                    <option value="{{ $jabatan->id_jabatan }}">{{ $jabatan->jabatan }}</option>
                                @endforeach
                            </select>
                        </div>


                        <!-- Input NIK -->
                        <div class="mb-3">
                            <label for="nik" class="form-label">NIK</label>
                            <div class="input-group">
                                <input type="text" name="nik" class="form-control" id="nik" required>
                            </div>
                            <option value="">Masukan minimal 16 digit</option>
                        </div>

                        <!-- Input Kelamin -->
                        <div class="mb-3">
                            <label for="editkelamin" class="form-label">Kelamin</label>
                            <select class="form-select" id="editkelamin" name="kelamin" required>
                                <option value="" disabled selected>Pilih Jenis Kelamin</option>
                                <option value="P">Perempuan</option>
                                <option value="L">Laki-Laki</option>
                            </select>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </form>


    <!-- Modal Edit Karyawan -->
    <div class="modal fade" id="editKaryawanModal" tabindex="-1" aria-labelledby="editKaryawanModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editKaryawanModalLabel">Edit Karyawan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formEditKaryawan" method="POST" action="">
                        @csrf
                        @method('PUT')
                        <input type="hidden" id="editKaryawanId" name="id">
                        <div class="mb-3">
                            <label for="editNamaKaryawan" class="form-label">Nama Karyawan</label>
                            <input type="text" class="form-control" id="editNamaKaryawan" name="username" required>
                        </div>
                        <div class="mb-3">
                            <label for="passwordEdit" class="form-label">Password</label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="passwordEdit" name="password" required>
                                <button type="button" class="input-group-text" id="togglePasswordEdit"
                                    style="border-left: none;">
                                    <i class="fa fa-eye" id="toggleIconEdit"></i>
                                </button>
                            </div>
                            <small class="form-text text-muted">Masukan minimal 8 digit</small>
                        </div>
                        <div class="mb-3">
                            <label for="editRole" class="form-label">Role</label>
                            <select class="form-select" id="editRole" name="role" required>
                                <option value="" disabled selected>Pilih Role</option>
                                <option value="admin">Admin</option>
                                <option value="karyawan">Karyawan</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="editJabatan" class="form-label">Jabatan</label>
                            <select class="form-select" id="editJabatan" name="id_jabatan" required>
                                <option value="" disabled selected>Pilih Jabatan</option>
                                @foreach($jabatans as $jabatan)
                                    <option value="{{ $jabatan->id_jabatan }}">{{ $jabatan->jabatan }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="editnik" class="form-label">NIK</label>
                            <input type="text" class="form-control" id="editnik" name="nik" required>
                        </div>
                        <div class="mb-3">
                            <label for="editkelamin" class="form-label">Kelamin</label>
                            <select class="form-select" id="editkelamin" name="kelamin" required>
                                <option value="" disabled selected>Pilih Jenis Kelamin</option>
                                <option value="P">Perempuan</option>
                                <option value="L">Laki-Laki</option>
                            </select>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>



    <script>

        //create dan efek mata
        document.getElementById('togglePasswordEdit').addEventListener('click', function () {
            const passwordInput = document.getElementById('passwordEdit');
            const toggleIcon = document.getElementById('toggleIconEdit');
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                console.log("pressed")
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        });

        //create dan efek mata
        document.getElementById('togglePasswordTambah').addEventListener('click', function () {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.getElementById('toggleIconEdit');
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                console.log("pressed")
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        });

        //sistem edit
        document.addEventListener('DOMContentLoaded', function () {
            const editButtons = document.querySelectorAll('.btn-edit');
            const editForm = document.getElementById('formEditKaryawan');
            const editKaryawanModal = new bootstrap.Modal(document.getElementById('editKaryawanModal'));

            editButtons.forEach(button => {
                button.addEventListener('click', function () {
                    const id = this.getAttribute('data-id');
                    const username = this.getAttribute('data-nama');
                    const role = this.getAttribute('data-role');
                    const jabatanId = this.getAttribute('data-jabatan');
                    const nik = this.getAttribute('data-nik');
                    const kelamin = this.getAttribute('data-kelamin');

                    editForm.setAttribute('action', `/karyawan/update/${id}`);

                    // Populate form fields
                    document.getElementById('editKaryawanId').value = id;
                    document.getElementById('editNamaKaryawan').value = username;
                    document.getElementById('editRole').value = role;
                    document.getElementById('editJabatan').value = jabatanId;
                    document.getElementById('editnik').value = nik;
                    document.getElementById('editkelamin').value = kelamin;

                    // Show modal
                    editKaryawanModal.show();
                });
            });
        });


        // js hamburger
        const hamburger = document.getElementById('hamburger-btn');
        const closeBtn = document.getElementById('close-btn');
        const sidebar = document.getElementById('sidebar');

        hamburger.addEventListener('click', function () {
            sidebar.classList.toggle('show');
            closeBtn.classList.toggle('show');
        });

        closeBtn.addEventListener('click', function () {
            sidebar.classList.remove('show');
            closeBtn.classList.remove('show');
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

    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>

</body>

</html>