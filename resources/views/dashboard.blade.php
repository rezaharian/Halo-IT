<x-app-layout>
    <div class="container-fluid px-3 px-lg-5 py-4 py-lg-5">
        <div class="d-flex flex-column flex-md-row align-items-md-end justify-content-between gap-3 mb-4">
            <div><span class="badge rounded-pill text-primary bg-primary-subtle px-3 py-2">Ruang kerja karyawan</span>
                <h1 class="display-6 fw-bold mt-3 mb-2">Selamat datang, {{ Auth::user()->name }}</h1>
                <p class="text-secondary mb-0">Pantau semua permintaan bantuan IT Anda dengan mudah.</p>
            </div><a href="{{ route('tickets.create') }}" class="btn btn-primary rounded-3 px-4 py-3 fw-semibold"><span
                    class="me-2">&#43;</span>Buat tiket</a>
        </div>
        <div class="row g-3 mb-4">
            <div class="col-12 col-md-6">
                <div class="halo-card bg-white p-4 h-100">
                    <div class="d-flex align-items-center justify-content-between">
                        <div><span class="text-secondary small fw-semibold text-uppercase">Tiket aktif</span>
                            <div class="display-6 fw-bold mt-2">{{ $openCount }}</div><span
                                class="text-secondary small">Menunggu penyelesaian</span>
                        </div><span class="halo-stat-icon bg-primary-subtle text-primary fs-4">&#9673;</span>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="halo-card bg-white p-4 h-100">
                    <div class="d-flex align-items-center justify-content-between">
                        <div><span class="text-secondary small fw-semibold text-uppercase">Tiket selesai</span>
                            <div class="display-6 fw-bold mt-2 text-success">{{ $resolvedCount }}</div><span
                                class="text-secondary small">Permintaan terselesaikan</span>
                        </div><span class="halo-stat-icon bg-success-subtle text-success fs-4">&#10003;</span>
                    </div>
                </div>
            </div>
        </div>
        <section class="halo-card bg-white overflow-hidden">
            <div
                class="d-flex flex-column flex-sm-row align-items-sm-center justify-content-between gap-2 p-4 border-bottom">
                <div>
                    <h2 class="h5 fw-bold mb-1">Tiket terbaru</h2>
                    <p class="text-secondary small mb-0">Permintaan bantuan terbaru Anda</p>
                </div><a href="{{ route('tickets.index') }}" class="btn btn-sm btn-light rounded-3 px-3">Lihat semua
                    tiket <span class="ms-1">&rarr;</span></a>
            </div>
            <div class="list-group list-group-flush">
                @forelse ($tickets as $ticket)
                    <a href="{{ route('tickets.show', $ticket) }}" class="list-group-item list-group-item-action p-4">
                        <div class="d-flex flex-column flex-sm-row align-items-sm-center justify-content-between gap-3">
                            <div>
                                <div class="d-flex align-items-center gap-2 mb-1"><span
                                        class="fw-semibold">{{ $ticket->subject }}</span><span
                                        class="badge rounded-pill bg-light text-secondary">{{ $ticket->ticket_number }}</span>
                                </div><small class="text-secondary">{{ $ticket->category->name }} <span
                                        class="mx-1">&middot;</span>
                                    {{ $ticket->created_at->diffForHumans() }}</small>
                            </div><span
                                class="badge rounded-pill bg-primary-subtle text-primary px-3 py-2">{{ $ticket->status }}</span>
                        </div>
                </a>@empty<div class="p-5 text-center">
                        <div class="fs-1 text-primary mb-2">&#128221;</div>
                        <h3 class="h6 fw-bold">Belum ada tiket</h3>
                        <p class="text-secondary small mb-3">Buat permintaan pertama Anda dan tim IT akan membantu.</p>
                        <a href="{{ route('tickets.create') }}" class="btn btn-primary btn-sm rounded-3">Buat tiket</a>
                    </div>
                @endforelse
            </div>
        </section>
    </div>
</x-app-layout>
