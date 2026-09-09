<x-guest-layout>
    <div class="text-center">
        <div class="halo-brand-mark rounded-circle d-inline-flex align-items-center justify-content-center text-white fs-3 mb-4"
            style="width:64px;height:64px">&#9993;</div>
        <h2 class="fw-bold">Verifikasi email Anda</h2>
        <p class="text-secondary">Terima kasih sudah mendaftar. Klik tautan verifikasi yang kami kirim ke email Anda.</p>
        @if (session('status') === 'verification-link-sent')
            <div class="alert alert-success small">Tautan verifikasi baru sudah dikirim.</div>
        @endif
        <form method="POST" action="{{ route('verification.send') }}" class="mb-3">@csrf<button
                class="btn btn-primary rounded-3 px-4">Kirim ulang email verifikasi</button></form>
        <form method="POST" action="{{ route('logout') }}">@csrf<button
                class="btn btn-link text-decoration-none">Keluar</button></form>
    </div>
</x-guest-layout>
