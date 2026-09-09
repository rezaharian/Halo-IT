<x-app-layout>
    <div class="container-fluid px-3 px-lg-5 py-4 py-lg-5">
        <div class="row justify-content-center">
            <div class="col-12 col-xl-8"><a href="{{ route('tickets.index') }}" class="text-decoration-none small">&larr;
                    Kembali ke tiket saya</a>
                <div class="mb-4 mt-3"><span
                        class="badge rounded-pill text-primary bg-primary-subtle px-3 py-2">Permintaan baru</span>
                    <h1 class="display-6 fw-bold mt-3 mb-2">Buat tiket</h1>
                    <p class="text-secondary mb-0">Jelaskan kendala Anda agar tim IT dapat membantu lebih cepat.</p>
                </div>
                <form method="POST" action="{{ route('tickets.store') }}" class="halo-card bg-white p-4 p-lg-5">@csrf
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0 ps-3">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="mb-4">
                        <label for="subject" class="form-label fw-semibold">Apa yang ingin Anda laporkan?</label><input
                            id="subject" name="subject" value="{{ old('subject') }}" required
                            class="form-control form-control-lg"
                            placeholder="Contoh: Tidak dapat terhubung ke Wi-Fi kantor">
                    </div>
                    <div class="row g-3 mb-4">
                        <div class="col-md-7"><label for="category_id"
                                class="form-label fw-semibold">Kategori</label><select id="category_id"
                                name="category_id" required class="form-select form-select-lg">
                                <option value="">Pilih kategori</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>
                                        {{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-5"><label for="priority"
                                class="form-label fw-semibold">Prioritas</label><select id="priority" name="priority"
                                required class="form-select form-select-lg">
                                @foreach ($priorities as $priority)
                                    <option value="{{ $priority->value }}" @selected(old('priority', 'Medium') === $priority->value)>
                                        {{ $priority->value }}</option>
                                @endforeach
                            </select></div>
                    </div>
                    <div class="mb-4"><label for="description" class="form-label fw-semibold">Jelaskan
                            masalahnya</label>
                        <textarea id="description" name="description" rows="7" required class="form-control"
                            placeholder="Apa yang terjadi? Apa yang sudah Anda coba?">{{ old('description') }}</textarea>
                        <div class="form-text">Jangan masukkan kata sandi atau informasi sensitif.</div>
                    </div>
                    <div class="d-flex flex-column flex-sm-row justify-content-end gap-2"><a
                            href="{{ route('tickets.index') }}" class="btn btn-light rounded-3 px-4">Batal</a><button
                            class="btn btn-primary rounded-3 px-4 fw-semibold">Kirim tiket</button></div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
