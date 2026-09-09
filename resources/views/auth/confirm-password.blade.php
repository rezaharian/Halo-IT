<x-guest-layout>
    <div class="mb-4"><span class="badge rounded-pill bg-warning-subtle text-warning-emphasis px-3 py-2">Pemeriksaan
            keamanan</span>
        <h2 class="fw-bold mt-3 mb-2">Konfirmasi kata sandi</h2>
        <p class="text-secondary mb-0">Konfirmasi kata sandi sebelum melanjutkan.</p>
    </div>
    @if ($errors->any())
        <div class="alert alert-danger small">{{ $errors->first() }}</div>
    @endif
    <form method="POST" action="{{ route('password.confirm') }}">@csrf<div class="mb-4"><label for="password"
                class="form-label fw-semibold">Kata sandi</label><input id="password"
                class="form-control form-control-lg" type="password" name="password" required autofocus></div><button
            class="btn btn-primary btn-lg w-100 rounded-3 fw-semibold">Konfirmasi</button></form>
</x-guest-layout>
