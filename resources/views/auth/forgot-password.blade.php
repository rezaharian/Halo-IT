<x-guest-layout>
    <div class="mb-4"><span class="badge rounded-pill bg-primary-subtle text-primary px-3 py-2">Pemulihan akun</span>
        <h2 class="fw-bold mt-3 mb-2">Atur ulang kata sandi</h2>
        <p class="text-secondary mb-0">Masukkan email Anda dan kami akan mengirimkan tautan pemulihan.</p>
    </div>
    @if (session('status'))
        <div class="alert alert-success small">{{ session('status') }}</div>
        @endif @if ($errors->any())
            <div class="alert alert-danger small">{{ $errors->first() }}</div>
        @endif
        <form method="POST" action="{{ route('password.email') }}">@csrf<div class="mb-4"><label for="email"
                    class="form-label fw-semibold">Alamat email</label><input id="email"
                    class="form-control form-control-lg" type="email" name="email" value="{{ old('email') }}"
                    required autofocus></div><button class="btn btn-primary btn-lg w-100 rounded-3 fw-semibold">Kirim
                tautan pemulihan</button></form>
        <p class="text-center small mt-4 mb-0"><a href="{{ route('login') }}" class="text-decoration-none">Kembali ke
                halaman masuk</a></p>
</x-guest-layout>
