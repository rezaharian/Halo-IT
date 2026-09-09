<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'HALO IT') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="halo-auth-bg">
    <div class="container py-4 py-lg-5">
        <div class="row min-vh-100 align-items-center justify-content-center">
            <div class="col-12 col-md-9 col-lg-10 col-xl-9">
                <div class="row g-0 halo-auth-card overflow-hidden">
                    <div
                        class="col-lg-5 d-none d-lg-flex halo-auth-panel text-white p-5 flex-column justify-content-between">
                        <div>
                            <div class="halo-brand-mark rounded-3 d-inline-flex align-items-center justify-content-center fw-bold mb-4"
                                style="width:46px;height:46px">H</div>
                            <h1 class="display-6 fw-bold">Dukungan IT jadi lebih mudah.</h1>
                            <p class="text-white-50 mt-3">Kirim laporan, pantau progres, dan tetap terhubung dengan tim
                                IT perusahaan.</p>
                        </div><small class="text-white-50">HALO IT · Pusat bantuan internal</small>
                    </div>
                    <div class="col-lg-7 bg-white p-4 p-md-5">{{ $slot }}</div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
