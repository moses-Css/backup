<div x-data="{ 
        open: false, 
        mode: 'create', 
        type: 'kategori', 
        kategori: {}, 
        group: {} 
    }"
    x-show="open"
    @open-modal.window="if ($event.detail.modal.includes('kategori') || $event.detail.modal.includes('group')) { 
        open = true; 
        mode = $event.detail.modal.includes('edit') ? 'edit' : 'create'; 
        type = $event.detail.modal.includes('group') ? 'group' : 'kategori';
        if (mode === 'edit') {
            type === 'kategori' ? kategori = $event.detail.data : group = $event.detail.data;
        } else {
            kategori = {};
            group = {};
        }
    }"
    @close-modal.window="open = false"
    class="fixed inset-0 flex items-center justify-center z-50" style="display: none;">

    <!-- Overlay -->
    <div x-show="open" @click="open = false" class="fixed bg-neutralDark inset-0 bg-opacity-20 backdrop-blur-sm transition-opacity duration-300"></div>

    <!-- Modal -->
    <div x-show="open"
        x-transition:enter="transition transform duration-300"
        x-transition:enter-start="scale-75 opacity-0"
        x-transition:enter-end="scale-100 opacity-100"
        x-transition:leave="transition transform duration-300"
        x-transition:leave-start="scale-100 opacity-100"
        x-transition:leave-end="scale-75 opacity-0"
        class="bg-secondary p-7 rounded-4xl shadow-lg w-full max-w-md z-10 text-neutralDark">

        <form id="groupForm" method="POST"
            :action="mode === 'create' 
    ? '{{ route('kategoris.store') }}' 
    : (type === 'kategori' 
        ? '{{ route('kategoris.update', ['kategori' => ':kategori']) }}'.replace(':kategori', kategori.id) 
        : '{{ route('groups.updateTitle', ['group' => ':group']) }}'.replace(':group', group.id))">

            @csrf
            <template x-if="mode === 'edit' && type === 'group'">
                @method('PUT')
            </template>

            <div class="mb-4 w-full">
                <svg x-show="open" @click="open = false" class="justify-self-end hover:cursor-pointer" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#1e1e1e" viewBox="0 0 256 256">
                    <path d="M204.24,195.76a6,6,0,1,1-8.48,8.48L128,136.49,60.24,204.24a6,6,0,0,1-8.48-8.48L119.51,128,51.76,60.24a6,6,0,0,1,8.48-8.48L128,119.51l67.76-67.75a6,6,0,0,1,8.48,8.48L136.49,128Z"></path>
                </svg>
                <h2 class="text-2xl font-medium"
                    x-text="mode === 'create' 
        ? 'Tambah ' + (type === 'kategori' ? 'Kategori' : 'Group') 
        : 'Edit ' + (type === 'kategori' ? 'Kategori' : 'Group')"></h2>
                <label class="block mb-2 text-sm text-neutralGray"
                    x-text="mode === 'create' 
        ? (type === 'kategori' ? 'Untuk kategorisasi foto dan mempermudah pencarian' : 'Ubah nama grup untuk pengelompokan yang lebih baik') 
        : 'Ubah nama sesuai kebutuhan'"></label>
            </div>

            <x-input-label for="nama" x-text="'Nama ' + (type === 'kategori' ? 'Kategori' : 'Group')" class="mb-2" />
<input type="text" name="title" placeholder="Masukkan Nama"
                x-model="mode === 'edit' ? (type === 'kategori' ? kategori.nama : group.nama) : ''"
                class="w-full p-4 rounded-full border border-neutralGray2" required>

            <div class="mt-4 w-full">
                <x-primary-button class="w-full flex items-center justify-center !rounded-full py-4"
                    x-text="mode === 'create' ? 'Simpan' : 'Update'"></x-primary-button>
            </div>
        </form>


    </div>
</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('modal', () => ({
            // Data dan method yang sudah ada...
        }));
    });

    document.getElementById('groupForm').addEventListener('submit', function(e) {
        e.preventDefault();

        const formData = new FormData(this);
        const url = this.action;
        const method = this.querySelector('input[name="_method"]') ? this.querySelector('input[name="_method"]').value : 'POST';

        fetch(url, {
    method: method,
    body: formData,
    headers: {
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        'Accept': 'application/json'
    }
})
.then(response => response.json())
.then(data => {
    if (data && data.success) {
        // Update UI tanpa refresh
        const groupElement = document.querySelector(`[data-group-id="${data.group_id}"]`);
        if (groupElement) {
            // Update title di dropdown
            groupElement.querySelector('.group-title').textContent = data.new_title;
            
            // Update title di card header
            const cards = document.querySelectorAll(`.group-card[data-group-id="${data.group_id}"]`);
            cards.forEach(card => {
                card.querySelector('.card-title').textContent = data.new_title;
            });
        }
        
        // Tutup modal
        window.dispatchEvent(new CustomEvent('close-modal'));
    } else if (data && data.error) {
        console.error('Error:', data.error);
    } else {
        console.error('Error: undefined');
    }
})
.catch(error => console.error('Error:', error));
    });
</script>