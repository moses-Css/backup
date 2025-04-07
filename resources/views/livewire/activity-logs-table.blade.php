<div>
<style>
    /* Loading indicator saat searching */
    [wire\:loading] {
        position: relative;
        pointer-events: none;
    }
    [wire\:loading]:after {
        content: " ";
        @apply border-2 border-gray-200 border-t-2 border-t-primary rounded-full w-4 h-4;
        animation: spin 1s linear infinite;
        position: absolute;
        right: 2.5rem;
        top: 50%;
        transform: translateY(-50%);
    }
    @keyframes spin {
        0% { transform: translateY(-50%) rotate(0deg); }
        100% { transform: translateY(-50%) rotate(360deg); }
    }
</style>

    <!-- Bagian Filter -->
    <div class="flex flex-wrap gap-4 mb-4 p-5">
        <!-- Search Input -->
        <div class="relative w-full md:w-1/3">
        <input
    wire:model.debounce.500ms="search"
    wire:keydown.enter="$refresh"
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
                wire:loading.attr="disabled"
                class="px-4 py-2 rounded-lg transition-colors
        {{ $category == $cat ? 'bg-primary text-white' : 'bg-gray-200 text-gray-800' }}">
                {{ $cat }}
            </button>
            @endforeach
        </div>
    </div>

    <!-- Tabel Log -->
    <div class="overflow-x-auto rounded-lg border border-neutral-gray mx-5">
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    document.addEventListener('livewire:load', function() {
        $('#dateRange').daterangepicker({
            opens: 'left',
            locale: {
                format: 'DD MMM YYYY',
                separator: ' - ',
                applyLabel: 'Terapkan',
                cancelLabel: 'Batal',
                daysOfWeek: ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'],
                monthNames: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 
                           'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'],
            },
            autoUpdateInput: true,
            showDropdowns: true,
            startDate: moment().subtract(7, 'days'),
            endDate: moment(),
        }, function(start, end) {
            const startDate = start.format('YYYY-MM-DD');
            const endDate = end.format('YYYY-MM-DD');
            
            Livewire.emit('setDateRange', startDate, endDate);
        });
        
        // Handle clear date
        $('#dateRange').on('cancel.daterangepicker', function() {
            $(this).val('');
            Livewire.emit('clearDateRange');
        });
    });
</script>
@endpush