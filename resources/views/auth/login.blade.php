<x-guest-layout>
    <div class="mb-4"><span class="badge rounded-pill bg-primary-subtle text-primary px-3 py-2">Selamat datang
            kembali</span>
        <h2 class="fw-bold mt-3 mb-2">Masuk ke HALO IT</h2>
        <p class="text-secondary mb-0">Akses ruang kerja bantuan IT Anda.</p>
    </div>
    @if (session('status'))
        <div class="alert alert-success small">{{ session('status') }}</div>
        @endif @if ($errors->any())
            <div class="alert alert-danger small">
                <ul class="mb-0 ps-3">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form method="POST" action="{{ route('login') }}">
            @csrf<div class="mb-3"><label for="email" class="form-label fw-semibold">Alamat email</label><input
                    id="email" class="form-control form-control-lg" type="email" name="email"
                    value="{{ old('email') }}" required autofocus autocomplete="username"></div>
            <div class="mb-3">
                <div class="d-flex justify-content-between"><label for="password" class="form-label fw-semibold">Kata
                        sandi</label>
                    @if (Route::has('password.request'))
                        <a class="small text-decoration-none" href="{{ route('password.request') }}">Lupa kata
                            sandi?</a>
                    @endif
                </div><input id="password" class="form-control form-control-lg" type="password" name="password"
                    required autocomplete="current-password">
            </div>
            <div class="form-check mb-4"><input id="remember_me" class="form-check-input" type="checkbox"
                    name="remember"><label for="remember_me" class="form-check-label text-secondary">Ingat saya</label>
            </div><button class="btn btn-primary btn-lg w-100 rounded-3 fw-semibold">Masuk <span
                    class="ms-1">&rarr;</span></button>
        </form>
        <p class="text-center text-secondary small mt-4 mb-0">Belum punya akun? <a href="{{ route('register') }}"
                class="text-decoration-none fw-semibold">Daftar sekarang</a></p>
</x-guest-layout>
