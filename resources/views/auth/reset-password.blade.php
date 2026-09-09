<x-guest-layout>
    <div class="mb-4"><span class="badge rounded-pill bg-primary-subtle text-primary px-3 py-2">Pemulihan akun</span>
        <h2 class="fw-bold mt-3 mb-2">Buat kata sandi baru</h2>
        <p class="text-secondary mb-0">Jaga keamanan akun HALO IT Anda.</p>
    </div>
    @if ($errors->any())
        <div class="alert alert-danger small">{{ $errors->first() }}</div>
    @endif
    <form method="POST" action="{{ route('password.store') }}">@csrf<input type="hidden" name="token"
            value="{{ $request->route('token') }}">
        <div class="mb-3"><label for="email" class="form-label fw-semibold">Alamat email</label><input
                id="email" class="form-control" type="email" name="email"
                value="{{ old('email', $request->email) }}" required autofocus></div>
        <div class="mb-3"><label for="password" class="form-label fw-semibold">Kata sandi baru</label><input
                id="password" class="form-control" type="password" name="password" required></div>
        <div class="mb-4"><label for="password_confirmation" class="form-label fw-semibold">Konfirmasi kata
                sandi</label><input id="password_confirmation" class="form-control" type="password"
                name="password_confirmation" required></div><button
            class="btn btn-primary btn-lg w-100 rounded-3 fw-semibold">Atur ulang kata sandi</button>
    </form>
</x-guest-layout>
