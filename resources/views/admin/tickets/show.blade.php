<x-app-layout>
    <div class="py-10">
        <div class="mx-auto max-w-5xl space-y-6 px-4 sm:px-6 lg:px-8"><a href="{{ route('admin.tickets.index') }}"
                class="text-sm font-medium text-indigo-600">&larr; Kembali ke semua tiket</a>
            @if (session('status'))
                <div class="rounded-lg bg-emerald-50 p-4 text-sm text-emerald-700">{{ session('status') }}</div>
            @endif
            <div class="grid gap-6 lg:grid-cols-[1fr_320px]">
                <section class="rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-200">
                    <p class="text-sm font-medium text-indigo-600">{{ $ticket->ticket_number }}</p>
                    <h1 class="mt-2 text-2xl font-bold text-gray-900">{{ $ticket->subject }}</h1>
                    <p class="mt-2 text-sm text-gray-500">{{ $ticket->user->name }} · {{ $ticket->category->name }} ·
                        {{ $ticket->created_at->diffForHumans() }}</p>
                    <div class="mt-6 whitespace-pre-line rounded-lg bg-gray-50 p-4 text-gray-700">
                        {{ $ticket->description }}</div>
                    @if ($ticket->activities->isNotEmpty())
                        <div class="mt-8">
                            <h2 class="font-semibold text-gray-900">Activity history</h2>
                            <div class="mt-4 space-y-3">
                                @foreach ($ticket->activities as $activity)
                                    <div class="border-l-2 border-indigo-200 pl-4 text-sm">
                                        <p class="font-medium text-gray-900">{{ $activity->user?->name ?? 'System' }}
                                        </p>
                                        <p class="text-gray-600">{{ $activity->description }}:
                                            {{ $activity->old_value ?: 'none' }} &rarr;
                                            {{ $activity->new_value ?: 'none' }}</p>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </section>
                <div class="space-y-6">
                    <form method="POST" action="{{ route('admin.tickets.update', $ticket) }}"
                        class="h-fit space-y-5 rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-200">@csrf
                        @method('PUT')<h2 class="font-semibold text-gray-900">Update ticket</h2>
                        <div><label for="status" class="block text-sm font-medium text-gray-700">Status</label><select
                                id="status" name="status"
                                class="mt-1 block w-full rounded-lg border-gray-300 text-sm">
                                @foreach ($statuses as $status)
                                    <option value="{{ $status->value }}" @selected($ticket->status === $status->value)>
                                        {{ $status->value }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div><label for="priority"
                                class="block text-sm font-medium text-gray-700">Priority</label><select id="priority"
                                name="priority" class="mt-1 block w-full rounded-lg border-gray-300 text-sm">
                                @foreach ($priorities as $priority)
                                    <option value="{{ $priority->value }}" @selected($ticket->priority === $priority->value)>
                                        {{ $priority->value }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div><label for="category_id"
                                class="block text-sm font-medium text-gray-700">Category</label><select id="category_id"
                                name="category_id" class="mt-1 block w-full rounded-lg border-gray-300 text-sm">
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" @selected($ticket->category_id === $category->id)>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div><label for="assigned_to" class="block text-sm font-medium text-gray-700">Assigned
                                to</label><select id="assigned_to" name="assigned_to"
                                class="mt-1 block w-full rounded-lg border-gray-300 text-sm">
                                <option value="">Unassigned</option>
                                @foreach ($technicians as $technician)
                                    <option value="{{ $technician->id }}" @selected($ticket->assigned_to === $technician->id)>
                                        {{ $technician->name }}</option>
                                @endforeach
                            </select></div><button
                            class="w-full rounded-lg bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-indigo-500">Simpan
                            perubahan</button>
                    </form>
                    <section class="rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-200">
                        <h2 class="font-semibold text-gray-900">Comments</h2>
                        <div class="mt-4 space-y-3">
                            @forelse ($ticket->comments as $comment)
                                <div class="rounded-lg {{ $comment->is_internal ? 'bg-amber-50' : 'bg-gray-50' }} p-4">
                                    <p class="text-sm font-medium text-gray-900">{{ $comment->user->name }}
                                        @if ($comment->is_internal)
                                            <span class="ml-2 text-xs text-amber-700">Internal</span>
                                        @endif
                                    </p>
                                    <p class="mt-2 whitespace-pre-line text-sm text-gray-700">{{ $comment->comment }}
                                    </p>
                                </div>
                            @empty
                                <p class="text-sm text-gray-500">Belum ada komentar.</p>
                            @endforelse
                        </div>
                        <form method="POST" action="{{ route('tickets.comments.store', $ticket) }}"
                            class="mt-5 space-y-3">
                            @csrf
                            <textarea name="comment" rows="3" required placeholder="Tulis komentar..."
                                class="block w-full rounded-lg border-gray-300"></textarea>
                            <label class="flex items-center gap-2 text-sm text-gray-600"><input type="checkbox"
                                    name="is_internal" value="1" class="rounded border-gray-300"> Internal
                                comment</label>
                            <button class="rounded-lg bg-gray-900 px-4 py-2 text-sm font-semibold text-white">Kirim
                                komentar</button>
                        </form>
                    </section>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
