<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>HALO IT - Pusat Bantuan Teknologi</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="halo-welcome">
    <div class="halo-welcome-oval halo-welcome-oval-one"></div>
    <div class="halo-welcome-oval halo-welcome-oval-two"></div>
    <header class="container position-relative py-4">
        <nav class="d-flex align-items-center justify-content-between"><a href="{{ url('/') }}"
                class="d-flex align-items-center gap-2 text-decoration-none text-dark"><span
                    class="halo-brand-mark rounded-3 d-inline-flex align-items-center justify-content-center text-white fw-bold"
                    style="width:42px;height:42px">H</span><strong class="fs-5">HALO IT</strong></a>
            <div class="d-flex align-items-center gap-2">@auth<a
                        href="{{ Auth::user()->role === 'admin' ? route('admin.dashboard') : route('dashboard') }}"
                    class="btn btn-primary rounded-3 px-3">Dashboard</a>@else<a href="{{ route('login') }}"
                        class="btn btn-link text-decoration-none">Masuk</a><a href="{{ route('register') }}"
                    class="btn btn-primary rounded-3 px-3">Daftar</a>@endauth
            </div>
        </nav>
    </header>
    <main class="container position-relative">
        <section class="row align-items-center py-5 py-lg-6 hero-shell">
            <div class="col-lg-7">
                <span class="halo-pill">Pusat bantuan internal</span>
                <h1 class="display-3 fw-bold mt-4 mb-3 lh-sm">Semua kebutuhan IT,<br><span
                        class="text-primary">ditangani dengan lebih tenang.</span></h1>
                <p class="lead text-secondary col-lg-10 mb-4">Laporkan kendala, pantau progres, dan berkomunikasi
                    langsung dengan tim IT perusahaan dalam satu tempat yang terasa ringan dan jelas.</p>

                <div class="d-flex flex-column flex-sm-row gap-3 mt-4">
                    <a href="{{ route('register') }}" class="btn btn-primary btn-lg rounded-4 px-4 shadow-sm">
                        Buat tiket sekarang <span class="ms-2">&rarr;</span>
                    </a>
                    <a href="{{ route('login') }}" class="btn btn-soft btn-lg rounded-4 px-4">Saya sudah punya akun</a>
                </div>

                <div class="halo-trust-list mt-5">
                    <span>&#10003; Respon lebih cepat</span>
                    <span>&#10003; Status transparan</span>
                    <span>&#10003; Riwayat tersimpan</span>
                </div>
            </div>

            <div class="col-lg-5 mt-5 mt-lg-0">
                <div class="halo-welcome-card bg-white p-4 p-lg-4">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <span class="small text-secondary">Pusat kontrol Anda</span>
                            <h2 class="h4 fw-bold mt-2 mb-0">Butuh bantuan?</h2>
                        </div>
                        <span class="halo-welcome-icon">&#9733;</span>
                    </div>

                    <div class="halo-welcome-ticket mt-4 p-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="small fw-semibold">Tiket terbaru</span>
                            <span class="badge rounded-pill bg-success-subtle text-success">Diproses</span>
                        </div>
                        <strong class="d-block mt-3 fs-5">Koneksi Wi-Fi kantor bermasalah</strong>
                        <small class="text-secondary">Diperbarui beberapa menit lalu</small>
                    </div>

                    <div class="halo-preview-grid mt-3">
                        <div class="halo-stat-block primary">
                            <small>Tiket aktif</small>
                            <strong>03</strong>
                        </div>
                        <div class="halo-stat-block success">
                            <small>Selesai</small>
                            <strong>12</strong>
                        </div>
                    </div>

                    <div class="halo-mini-list mt-4">
                        <div class="halo-mini-item">
                            <span class="halo-mini-dot blue"></span>
                            <div>
                                <strong>Update tiket</strong>
                                <small>2 jam yang lalu</small>
                            </div>
                        </div>
                        <div class="halo-mini-item">
                            <span class="halo-mini-dot green"></span>
                            <div>
                                <strong>Tim IT menindaklanjuti</strong>
                                <small>Sudah ditugaskan</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="row g-3 pb-5">
            <div class="col-md-4">
                <div class="halo-welcome-feature bg-white p-4 h-100">
                    <div class="halo-feature-icon">01</div>
                    <h2 class="h5 fw-bold mt-4">Buat laporan</h2>
                    <p class="text-secondary small mb-0">Ceritakan kendala Anda dengan detail agar tim IT dapat langsung
                        memahami kebutuhan.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="halo-welcome-feature bg-white p-4 h-100">
                    <div class="halo-feature-icon">02</div>
                    <h2 class="h5 fw-bold mt-4">Pantau progres</h2>
                    <p class="text-secondary small mb-0">Lihat status tiket dan terima pemberitahuan setiap ada
                        pembaruan.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="halo-welcome-feature bg-white p-4 h-100">
                    <div class="halo-feature-icon">03</div>
                    <h2 class="h5 fw-bold mt-4">Selesaikan bersama</h2>
                    <p class="text-secondary small mb-0">Berkomunikasi langsung dengan tim IT sampai masalah benar-benar
                        selesai.</p>
                </div>
            </div>
        </section>
    </main>

    <footer class="container position-relative py-4 border-top text-secondary small">
        HALO IT &middot; Solusi dukungan teknologi perusahaan
    </footer>
</body>

</html>
