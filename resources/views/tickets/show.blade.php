<x-app-layout>
    <div class="container-fluid px-3 px-lg-5 py-4 py-lg-5"><a href="{{ route('tickets.index') }}"
            class="text-decoration-none small">&larr; Kembali ke tiket saya</a>
        @if (session('status'))
            <div class="alert alert-success mt-3">{{ session('status') }}</div>
        @endif
        <div class="row g-4 mt-1">
            <div class="col-12 col-xl-8">
                <section class="halo-card bg-white p-4 p-lg-5">
                    <div class="d-flex flex-column flex-md-row justify-content-between gap-3">
                        <div><span
                                class="badge rounded-pill bg-primary-subtle text-primary px-3 py-2">{{ $ticket->ticket_number }}</span>
                            <h1 class="h2 fw-bold mt-3 mb-2">{{ $ticket->subject }}</h1>
                            <p class="text-secondary mb-0">{{ $ticket->category->name }} <span
                                    class="mx-1">&middot;</span> Dibuat {{ $ticket->created_at->diffForHumans() }}</p>
                        </div>
                        <div class="d-flex gap-2 align-items-start"><span
                                class="badge rounded-pill bg-primary-subtle text-primary px-3 py-2">{{ $ticket->status }}</span><span
                                class="badge rounded-pill bg-warning-subtle text-warning-emphasis px-3 py-2">{{ $ticket->priority }}</span>
                        </div>
                    </div>
                    <div class="bg-light rounded-3 p-4 mt-4 text-secondary" style="white-space:pre-line">
                        {{ $ticket->description }}</div>
                </section>
                <section class="halo-card bg-white p-4 p-lg-5 mt-4">
                    <h2 class="h5 fw-bold mb-1">Percakapan</h2>
                    <p class="text-secondary small">Pembaruan dari Anda dan tim IT.</p>
                    <div class="vstack gap-3 mt-4">
                        @forelse ($ticket->comments as $comment)
                            <div class="bg-light rounded-3 p-3">
                                <div class="d-flex justify-content-between"><strong
                                        class="small">{{ $comment->user->name }}</strong><small
                                        class="text-secondary">{{ $comment->created_at->diffForHumans() }}</small>
                                </div>
                                <p class="mb-0 mt-2 text-secondary" style="white-space:pre-line">
                                    {{ $comment->comment }}</p>
                        </div>@empty<p class="text-secondary small">Belum ada komentar.</p>
                        @endforelse
                    </div>
                    <form method="POST" action="{{ route('tickets.comments.store', $ticket) }}" class="mt-4">@csrf
                        <textarea name="comment" rows="4" required class="form-control mb-2" placeholder="Tulis balasan..."></textarea>
                        <div class="d-flex justify-content-end"><button class="btn btn-primary rounded-3 px-4">Kirim
                                balasan</button></div>
                    </form>
                </section>
            </div>
            <div class="col-12 col-xl-4">
                <div class="halo-card bg-white p-4">
                    <h2 class="h6 fw-bold">Informasi tiket</h2>
                    <dl class="row small mt-3 mb-0">
                        <dt class="col-5 text-secondary fw-normal">Status</dt>
                        <dd class="col-7 fw-semibold">{{ $ticket->status }}</dd>
                        <dt class="col-5 text-secondary fw-normal">Prioritas</dt>
                        <dd class="col-7 fw-semibold">{{ $ticket->priority }}</dd>
                        <dt class="col-5 text-secondary fw-normal">Kategori</dt>
                        <dd class="col-7 fw-semibold">{{ $ticket->category->name }}</dd>
                        <dt class="col-5 text-secondary fw-normal">Dibuat</dt>
                        <dd class="col-7 fw-semibold">{{ $ticket->created_at->format('d M Y') }}</dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
