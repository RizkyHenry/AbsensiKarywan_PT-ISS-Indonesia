<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kalender Absensi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        /* General styling for calendar status colors with white text */
        .hadir,
        .telat,
        .izin,
        .sakit,
        .alpha,
        .requested,
        .izin-accepted,
        .sakit-accepted,
        .rejected {
            color: white;
        }

        /* Specific background colors for each status */
        .hadir {
            background-color: green;
        }

        .telat {
            background-color: grey;
        }

        .izin {
            background-color: #0739ff;
        }

        .sakit {
            background-color: #ffc107;
            color: black;
            /* Override to black for better readability on yellow */
        }

        .alpha {
            background-color: red;
        }

        .requested {
            background-color: lightgrey;
            color: black;
            /* Override to black for readability on light grey */
        }

        /* Accepted status styles */
        .izin-accepted {
            background-color: #0739ff;
        }

        .sakit-accepted {
            background-color: #ffc107;
            color: black;
            /* Override to black for readability on yellow */
        }

        /* Rejected status style */
        .rejected {
            background-color: red;
        }


        body {
            background-color: #f0f8ff;
        }

        .calendar-day.izin {
            background-color: #0739ff;
            /* border to  izin days */
            position: relative;
        }

        .calendar-day.rejected {
            color: white;
        }

        .izin-info {
            position: absolute;
            top: 2px;
            left: 2px;
            font-size: 10px;
            color: #333;
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

            .awal {
                padding-right: 50px;
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


        .calendar-day {
            width: 100px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid #ddd;
            margin: 5px;
            transition: background-color 0.3s;
        }

        .btn-hadir {
            background-color: #28a745;
            /* Warna hijau */
            color: #fff;
        }

        .btn-hadir:hover {
            background-color: #90EE90;
            /* Warna hijau terang saat hover */
        }

        .btn-telat {
            background-color: #6c757d;
            /* Warna abu-abu */
            color: #fff;
        }

        .btn-telat:hover {
            background-color: #cfd3d7;
            /* Warna abu-abu terang saat hover */
        }

        .btn-izin {
            background-color: #007bff;
            /* Warna biru */
            color: #fff;
        }

        .btn-izin:hover {
            background-color: #6f8cc5;
            /* Warna biru terang saat hover */
        }

        .btn-sakit {
            background-color: #ffc107;
            /* Warna kuning */
            color: white;
        }

        .btn-sakit:hover {
            background-color: #ffeaa7;
            /* Warna kuning terang saat hover */
        }

        .btn-alpa {
            background-color: #dc3545;
            /* Warna merah */
            color: #fff;
        }

        .btn-alpa:hover {
            background-color: #ff6b81;
            /* Warna merah terang saat hover */
        }

        .calendar-container {
            display: flex;
            flex-wrap: wrap;
            gap: 5px;
        }

        .custom-light-green {
            background-color: #90EE90;
            /* Warna hijau terang */
            color: white;
            /* Warna teks */
            border: none;
            /* Menghilangkan border default */
        }

        .custom-light-green:hover {
            background-color: #76c7a8;
            /* Warna saat hover */
        }

        .hadirr {
            background-color: #28a745;
            /* Warna hijau untuk hadir */
            color: white;
        }

        .telat {
            background-color: #4e4f51;
            /* Warna abu-abu untuk telat */
            color: white;
        }

        .izin {
            background-color: #007bff;
            /* Warna biru untuk izin */
            color: white;
        }

        .sakit {
            background-color: #ffc107;
            /* Warna kuning untuk sakit */
            color: black;
        }

        .alpha {
            background-color: #dc3545;
            /* Warna merah untuk alpa */
            color: white;
        }

        .none {
            background-color: #ddd;
            /* Warna default untuk tanggal tanpa status */
            color: black;
        }

        .calendar-container {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 10px;
        }

        .calendar-header {
            display: contents;
            /* Memastikan header tetap sejajar */
        }

        .calendar-day-name,
        .calendar-day {
            padding-left: 39px;

        }

        .calendar-day-none,
        .calendar-day {
            padding: 6px;

        }
    </style>
</head>
@if (Session::has('success'))
    <div id="success-alert" class="alert alert-success">
        {{ Session::get('success') }}
    </div>
@endif

<body>


    <main id="main-content" class="main-content col-md-9 ms-sm-auto col-lg-10 px-md-4">
        <div
            class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <button class="hamburger" id="hamburger-btn">&#9776;</button>
            <h1 class="text-primary awal" style="margin-left:50px;">Kalender Absensi</h1>
        </div>


        <div class="container-fluid">
            <div class="row">
                <nav id="sidebar" class="col-md-3 col-lg-2 bg-primary sidebar">
                    <button class="close-btn" id="close-btn">&times;</button>
                    <div class="position-sticky pt-3">
                        <img src="logo-iss.jpg" alt="Logo ISS" class="logo">
                        <h2 class="text-center text-white">Kalender Absensi</h2>
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
                <div class="container mt-5">
                    <h2 class="text-primary text-center">Jumlah Status</h2>
                    <div class="d-flex justify-content-center mb-3">
                        <p><span class="btn btn-success me-2" onclick="filterStatus('hadir')">Hadir

                            </span></p>
                        <p><span class="btn btn-secondary me-2" onclick="filterStatus('telat')">Telat

                            </span></p>
                        <p><span class="btn btn-primary me-2" onclick="filterStatus('izin')">Izin

                            </span></p>
                        <p><span class="btn btn-warning me-2" style="color: white;"
                                onclick="filterStatus('sakit')">Sakit

                            </span></p>

                        <p class="btn btn-danger me-2">Alpha<span hidden id="alphaCount"></span></p>
                    </div>
                </div>
                <div>
                    <select id="monthSelect" onchange="updateCalendar()">
                        @for ($m = 1; $m <= 12; $m++)
                            <option value="{{ $m }}" {{ $m == ($currentMonth ?? date('n')) ? 'selected' : '' }}>
                                {{ \Carbon\Carbon::create()->month($m)->format('F') }}
                            </option>
                        @endfor
                    </select>

                    <select id="yearSelect" onchange="updateCalendar()">
                        @for ($y = ($currentYear ?? now()->year) - 5; $y <= ($currentYear ?? now()->year) + 5; $y++)
                            <option value="{{ $y }}" {{ $y == ($currentYear ?? now()->year) ? 'selected' : '' }}>{{ $y }}
                            </option>
                        @endfor
                    </select>
                </div>


                <div class="calendar-container" id="calendar"></div>
            </div>




            <script>
                // Update jumlah alpha setelah kalender diperbarui
                function updateAlphaCount() {
                    let countAlpha = 0;  // Hitung alpha di sisi klien

                    // Perhitungan status alpha
                    absensiData.forEach(item => {
                        if (!item.kehadiran_absen && moment(item.tanggal_absen).isBefore(moment().format('YYYY-MM-DD'))) {
                            countAlpha++;  // Hitung alpha
                        }
                    });

                    // Update elemen alphaCount dengan jumlah alpha
                    const initialAlpha = parseInt(document.getElementById('alphaCount').textContent);  // Nilai awal dari server
                    document.getElementById('alphaCount').textContent = initialAlpha + countAlpha;  // Tambahkan jumlah alpha yang dihitung
                }
                document.addEventListener("DOMContentLoaded", function () {
                    const absensiData = @json($dataAbsensi);  // Data absensi
                    const latestTanggalAbsen = @json($latestTanggalAbsen);  // Tanggal absen terakhir
                    const initialAlphaCount = parseInt(document.getElementById('alphaCount').textContent);  // Nilai awal dari server
                    let izinData = [];  // Inisialisasi data izin

                    // Fungsi untuk mendapatkan rentang tanggal dari izin
                    function getDateRange(startDate, endDate) {
                        let dates = [];
                        let currentDate = moment(startDate);
                        while (currentDate.isSameOrBefore(moment(endDate))) {
                            dates.push(currentDate.format('YYYY-MM-DD'));
                            currentDate.add(1, 'days');
                        }
                        return dates;
                    }

                    // Fungsi untuk menampilkan kalender
                    function updateCalendar() {
                        const month = parseInt(document.getElementById('monthSelect').value);
                        const year = parseInt(document.getElementById('yearSelect').value);

                        const totalDays = new Date(year, month, 0).getDate();
                        const firstDayOfMonth = new Date(year, month - 1, 1).getDay();
                        const calendar = document.getElementById('calendar');
                        calendar.innerHTML = '';  // Bersihkan isi kalender

                        // Buat header nama hari di kalender
                        const header = document.createElement('div');
                        header.className = 'calendar-header';
                        ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'].forEach(dayName => {
                            const dayElement = document.createElement('div');
                            dayElement.className = 'calendar-day-name';
                            dayElement.textContent = dayName;
                            header.appendChild(dayElement);
                        });
                        calendar.appendChild(header);

                        // Tambahkan elemen kosong buat alignment
                        for (let blank = 0; blank < firstDayOfMonth; blank++) {
                            const emptyDay = document.createElement('div');
                            emptyDay.className = 'calendar-day empty';
                            calendar.appendChild(emptyDay);
                        }


                        let countAlpha = 0;  // Tambahkan variabel untuk menghitung alpha
                        const today = moment().format('YYYY-MM-DD');  // Tanggal hari ini

                        for (let day = 1; day <= totalDays; day++) {
                            const dayElement = document.createElement('div');
                            dayElement.className = 'calendar-day';
                            const dateString = `${year}-${month.toString().padStart(2, '0')}-${day.toString().padStart(2, '0')}`;
                            dayElement.setAttribute('data-date', dateString);

                            const attendance = absensiData.find(item => item.tanggal_absen === dateString);
                            const status = attendance ? attendance.kehadiran_absen : null;

                            // Cek jika tidak ada kehadiran_absen dan tanggal lebih kecil dari hari ini
                            if (!status && moment(dateString).isBefore(today)) {
                                dayElement.classList.add('alpha');
                                dayElement.setAttribute('data-status', 'alpha');
                                countAlpha++;  // Increment countAlpha
                            } else if (status) {
                                dayElement.classList.add(status);
                                dayElement.setAttribute('data-status', status);
                            }

                            // Terapkan status izin tanpa batasan tanggal
                            const izinStart = attendance ? attendance.izin_tanggal_mulai : null;
                            const izinEnd = attendance ? attendance.izin_tanggal_selesai : null;
                            if (izinStart && izinEnd) {
                                const izinDates = getDateRange(izinStart, izinEnd);
                                if (izinDates.includes(dateString)) {
                                    dayElement.classList.add('izin');
                                    const izinInfo = document.createElement('span');
                                    izinInfo.className = 'izin-info';
                                    izinInfo.textContent = `Izin: ${izinStart} - ${izinEnd}`;
                                    dayElement.appendChild(izinInfo);
                                }
                            }

                            // Terapkan status sakit tanpa batasan tanggal
                            const sakitStart = attendance ? attendance.sakit_tanggal_mulai : null;
                            const sakitEnd = attendance ? attendance.sakit_tanggal_selesai : null;
                            if (sakitStart && sakitEnd) {
                                const sakitDates = getDateRange(sakitStart, sakitEnd);
                                if (sakitDates.includes(dateString)) {
                                    dayElement.classList.add('sakit');
                                    const sakitInfo = document.createElement('span');
                                    sakitInfo.className = 'sakit-info';
                                    sakitInfo.textContent = `Sakit: ${sakitStart} - ${sakitEnd}`;
                                    dayElement.appendChild(sakitInfo);
                                }
                            }


                            dayElement.textContent = day;
                            calendar.appendChild(dayElement);
                        }

                        // Update jumlah alpha setelah kalender diperbarui
                        // Update jumlah alpha setelah kalender diperbarui
                        document.getElementById('alphaCount').textContent = initialAlphaCount + countAlpha;
                    }


                    // Ambil data izin dan terapkan status ke kalender
                    fetch('/kalender/get-izin-data')
                        .then(response => response.json())
                        .then(data => {
                            izinData = data;  // Simpan data izin
                            applyIzinStatus();  // Terapkan status setelah data diambil
                        })
                        .catch(error => console.error("Error mengambil data izin:", error));

                    // Terapkan status izin ke kalender
                    function applyIzinStatus() {
                        izinData.forEach(izin => {
                            izin.dates.forEach(date => {
                                const dateElement = document.querySelector(`[data-date="${date}"]`);
                                if (dateElement) {
                                    switch (izin.status) {
                                        case 'Diterima':
                                            dateElement.classList.add(izin.jenis_izin === 'sakit' ? 'sakit-accepted' : 'izin-accepted');
                                            break;
                                        case 'Ditolak':
                                            dateElement.classList.add('rejected');
                                            break;
                                        case 'Direquest':
                                            dateElement.classList.add('requested');
                                            break;
                                        default:
                                            dateElement.style.backgroundColor = 'transparent';
                                    }
                                }
                            });
                        });
                    }

                    let lastStatus = 'all';
                    // Filter kalender berdasarkan status yang dipilih
                    function filterStatus(status) {
                        const days = document.querySelectorAll('.calendar-day');
                        if (lastStatus === status) {
                            days.forEach(day => day.style.display = 'flex');
                            lastStatus = 'all';
                        } else {
                            days.forEach(day => {
                                const dayStatus = day.getAttribute('data-status');
                                day.style.display = (dayStatus === status || status === 'all') ? 'flex' : 'none';
                            });
                            lastStatus = status;
                        }
                    }

                    // Ambil data absensi untuk bulan dan tahun yang dipilih
                    function fetchAbsensiData(month, year) {
                        $.ajax({
                            url: '/get-absensi',
                            method: 'GET',
                            data: { month, year },
                            success: function (response) {
                                absensiData.length = 0;
                                response.forEach(item => absensiData.push(item));
                                updateCalendar();
                            },
                            error: function (error) {
                                console.error("Error mengambil data absensi:", error);
                            }
                        });
                    }

                    // Event listener untuk perubahan bulan dan tahun
                    document.getElementById('monthSelect').addEventListener('change', function () {
                        const month = parseInt(this.value);
                        const year = parseInt(document.getElementById('yearSelect').value);
                        fetchAbsensiData(month, year);
                    });

                    document.getElementById('yearSelect').addEventListener('change', function () {
                        const year = parseInt(this.value);
                        const month = parseInt(document.getElementById('monthSelect').value);
                        fetchAbsensiData(month, year);
                    });

                    updateCalendar();  // Render awal kalender
                });
            </script>


            <script>
                // Responsive sidebar
                const hamburgerBtn = document.getElementById('hamburger-btn');
                const closeBtn = document.getElementById('close-btn');
                const sidebar = document.getElementById('sidebar');

                // Toggle Sidebar for mobile
                if (hamburgerBtn) {
                    hamburgerBtn.addEventListener('click', function () {
                        sidebar.classList.add('show');
                        closeBtn.classList.add('show'); // Show close button
                    });
                }

                if (closeBtn) {
                    closeBtn.addEventListener('click', function () {
                        sidebar.classList.remove('show');
                        closeBtn.classList.remove('show'); // Hide close button
                    });
                }

                // Alert function for success or danger alerts
                document.addEventListener('DOMContentLoaded', function () {
                    // Get alert elements by ID
                    const successAlert = document.getElementById('success-alert');
                    const dangerAlert = document.getElementById('danger-alert');

                    // Check if successAlert exists
                    if (successAlert) {
                        // Set timer to remove element after 2 seconds (2000 milliseconds)
                        setTimeout(function () {
                            successAlert.remove();
                        }, 2000);
                    }

                    // Check if dangerAlert exists
                    if (dangerAlert) {
                        // Set timer to remove element after 2 seconds (2000 milliseconds)
                        setTimeout(function () {
                            dangerAlert.remove();
                        }, 2000);
                    }
                });
            </script>

            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/moment@2.29.1/moment.min.js"></script>

</body>

</html>