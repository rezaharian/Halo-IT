<x-guest-layout>
    <div class="mb-4"><span class="badge rounded-pill bg-primary-subtle text-primary px-3 py-2">Mulai sekarang</span>
        <h2 class="fw-bold mt-3 mb-2">Buat akun Anda</h2>
        <p class="text-secondary mb-0">Bergabung dengan ruang kerja bantuan IT perusahaan.</p>
    </div>
    @if ($errors->any())
        <div class="alert alert-danger small">
            <ul class="mb-0 ps-3">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form method="POST" action="{{ route('register') }}">@csrf<div class="mb-3"><label for="name"
                class="form-label fw-semibold">Nama lengkap</label><input id="name"
                class="form-control form-control-lg" type="text" name="name" value="{{ old('name') }}" required
                autofocus autocomplete="name"></div>
        <div class="mb-3"><label for="email" class="form-label fw-semibold">Email kerja</label><input
                id="email" class="form-control form-control-lg" type="email" name="email"
                value="{{ old('email') }}" required autocomplete="username"></div>
        <div class="row g-3 mb-4">
            <div class="col-md-6"><label for="password" class="form-label fw-semibold">Kata sandi</label><input
                    id="password" class="form-control" type="password" name="password" required
                    autocomplete="new-password"></div>
            <div class="col-md-6"><label for="password_confirmation" class="form-label fw-semibold">Konfirmasi kata
                    sandi</label><input id="password_confirmation" class="form-control" type="password"
                    name="password_confirmation" required autocomplete="new-password"></div>
        </div><button class="btn btn-primary btn-lg w-100 rounded-3 fw-semibold">Buat akun</button>
    </form>
    <p class="text-center text-secondary small mt-4 mb-0">Sudah punya akun? <a href="{{ route('login') }}"
            class="text-decoration-none fw-semibold">Masuk</a></p>
</x-guest-layout>
