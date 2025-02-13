<div>
    <!-- Bagian Filter -->
    <div class="flex flex-wrap gap-4 mb-4">
        <!-- Search Input -->
        <div class="relative w-full md:w-1/3">
            <input
                wire:model.debounce.500ms="search"
                type="text"
                placeholder="Cari"
                class="w-full border border-neutralGray2 p-3 pr-16 pl-5 rounded-full bg-white focus:outline-none" />
            <button class="absolute right-3 top-1/2 transform -translate-y-1/2 bg-primary p-2 rounded-full text-white">
                <x-icon name="magnifying-glass" />
            </button>
        </div>

        <!-- Date Range Picker -->
        <div class="w-full md:w-1/3">
            <!-- Gunakan wire:ignore agar Livewire tidak mengganggu plugin JS -->
            <input
                type="text"
                id="dateRange"
                class="w-full border border-neutralGray2 p-3 rounded-full bg-white cursor-pointer"
                readonly
                placeholder="Pilih rentang tanggal" />
        </div>

        <!-- Tab Filter Kategori -->
        <div class="flex space-x-4">
            @php
            $categories = ['Semua', 'Foto', 'Kategori', 'Login'];
            @endphp
            @foreach($categories as $cat)
<button
    wire:click="$set('category', '{{ $cat }}')"
    class="px-4 py-2 rounded-lg transition-colors
        {{ $category == $cat ? 'bg-primary text-white' : 'bg-gray-200 text-gray-800' }}">
    {{ $cat }}
</button>
@endforeach
        </div>
    </div>

    <!-- Tabel Log -->
    <div class="overflow-x-auto rounded-lg border border-neutral-gray">
        <table class="min-w-full">
            <thead>
                <tr class="border-b border-neutralGray2 text-neutral-dark">
                    <th class="px-4 py-3 text-left text-sm font-semibold">User</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold">Activity</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold">Tanggal</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse ($logs as $log)
                <tr class="hover:bg-gray-50 transition-colors">
                    <!-- Kolom User -->
                    <td class="px-4 py-3 text-sm">
                        {{ $log->user->name ?? 'N/A' }}
                    </td>
                    <!-- Kolom Activity -->
                    <td class="px-4 py-3 text-sm">
                        {{ $log->activity }}
                    </td>
                    <!-- Kolom Tanggal -->
                    <td class="px-4 py-3 text-sm whitespace-nowrap">
                        {{ \Carbon\Carbon::parse($log->created_at)->format('d M Y, H:i') }} WIB
                    </td>
                    <!-- Kolom Aksi -->
                    <td class="px-4 py-3 text-sm">
                        <form action="{{ route('logs.delete', $log->id) }}" method="POST" onsubmit="return confirm('Hapus log ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-2 rounded-full bg-primaryLight text-white">
                                <x-icon name="trash" />
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center py-4">Tidak ada data.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $logs->links() }}
    </div>
</div>

<!-- Inisialisasi daterangepicker dengan wire:ignore -->
@push('scripts')
<script>
    document.addEventListener('livewire:load', function() {
        // Inisialisasi daterangepicker pada #dateRange
        $('#dateRange').daterangepicker({
            opens: 'left',
            locale: {
                format: 'MMM DD, YYYY'
            },
            // Set default date jika diinginkan atau biarkan kosong
            autoUpdateInput: false
        }, function(start, end) {
            // Update input display
            $('#dateRange').val(start.format('MMM DD, YYYY') + ' - ' + end.format('MMM DD, YYYY'));
            // Kirim data ke Livewire (format YYYY-MM-DD)
            Livewire.emit('setDateRange', start.format('YYYY-MM-DD'), end.format('YYYY-MM-DD'));
        });

        // Jika ingin mengosongkan tanggal (misalnya, dengan tombol reset)
        // Bisa tambahkan event listener tombol reset yang memanggil:
        // Livewire.emit('clearDateRange');
    });
</script>
@endpush