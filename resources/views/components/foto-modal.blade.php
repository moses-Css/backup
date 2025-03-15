<div x-data="{ 
        open: false, 
        formFilled: false, 
        showConfirm: false, 
        shake: false,
        resetForm() { 
            this.$refs.form.reset(); 
            this.formFilled = false;
        } 
    }"
    x-show="open"
    @open-modal.window="if ($event.detail === 'foto-modal') open = true"
    @close-modal.window="if ($event.detail === 'foto-modal') open = false"
    class="fixed inset-0 flex items-center justify-center z-50"
    style="display: none;">

    <!-- Background Overlay -->
    <div x-show="open"
        @click="formFilled ? showConfirm = true : open = false"
        class="fixed bg-neutralDark inset-0 bg-opacity-20 backdrop-blur-sm transition-opacity duration-300"
        style="display: none;"></div>

    <!-- Modal -->
    <div x-show="open"
        x-transition:enter="transition transform duration-300"
        x-transition:enter-start="scale-75 opacity-0"
        x-transition:enter-end="scale-100 opacity-100"
        x-transition:leave="transition transform duration-300"
        x-transition:leave-start="scale-100 opacity-100"
        x-transition:leave-end="scale-75 opacity-0"
        class="bg-secondary p-7 rounded-4xl  w-full max-w-md z-10 text-neutralDark ">

        <!-- Close Button -->
        <svg x-show="open" @click="formFilled ? showConfirm = true : open = false" class="justify-self-end hover:cursor-pointer" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#1e1e1e" viewBox="0 0 256 256">
            <path d="M204.24,195.76a6,6,0,1,1-8.48,8.48L128,136.49,60.24,204.24a6,6,0,0,1-8.48-8.48L119.51,128,51.76,60.24a6,6,0,0,1,8.48-8.48L128,119.51l67.76-67.75a6,6,0,0,1,8.48,8.48L136.49,128Z"></path>
        </svg>

        <h2 class="text-2xl font-medium">Tambah Foto Baru</h2>

        <form x-ref="form" method="POST" action="{{ route('photos.store') }}" enctype="multipart/form-data">
            @csrf

            <!-- Kategori -->
            <div>
                <x-input-label for="kategori_id" :value="__('Kategori')" />
                <select name="kategori_id" @input="formFilled = true" class="bg-gray-50 border border-gray-300 text-neutralDark text-sm rounded-lg focus:ring-primary focus:border-primary block w-full p-2.5" required>
                    @foreach($kategoris as $kategori)
                    <option value="{{ $kategori->id }}">{{ $kategori->nama }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Judul -->
            <div>
                <x-input-label for="title" :value="__('Judul')" />
                <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" @input="formFilled = true" required autofocus />
            </div>

            <!-- Deskripsi -->
            <div>
                <x-input-label for="deskripsi" :value="__('Deskripsi')" />
                <textarea name="deskripsi" id="deskripsi" @input="formFilled = true" class="bg-gray-50 border border-gray-300 text-neutralDark text-sm rounded-lg focus:ring-primary focus:border-primary block w-full p-2.5"></textarea>
            </div>

            <!-- Tanggal -->
            <div>
                <x-input-label for="tanggal" :value="__('Tanggal')" />
                <x-text-input id="tanggal" class="block mt-1 w-full" type="date" name="tanggal" @input="formFilled = true" />
            </div>

            <!-- Lokasi -->
            <div>
                <x-input-label for="lokasi" :value="__('Lokasi')" />
                <x-text-input id="lokasi" class="block mt-1 w-full" type="text" name="lokasi" @input="formFilled = true" />
            </div>

            <!-- Upload Gambar -->
            <div>
                <x-input-label for="images" :value="__('Upload Gambar')" />
                <input type="file" name="images[]" multiple @input="formFilled = true" class="block w-full text-sm text-neutralDark border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none" required>
            </div>

            <div class="mt-4 w-full">
                <x-primary-button class="w-full flex items-center justify-center !rounded-full py-4">Simpan</x-primary-button>
            </div>
        </form>
    </div>

    <!-- MODAL KONFIRMASI -->
    <div x-show="showConfirm" class="fixed inset-0 flex items-center justify-center bg-neutralDark bg-opacity-40 z-50">

        <!-- BACKDROP (detect klik outside) -->
        <div @click="shake = true; setTimeout(() => shake = false, 300)"
            class="absolute inset-0"></div>

        <!-- MODAL BOX -->
        <div x-show="showConfirm"
            x-transition:enter="duration-300 ease-out"
            x-transition:enter-start="-translate-y-20 scale-50 opacity-0"
            x-transition:enter-end="translate-y-0 scale-100 opacity-100"
            x-transition:leave="transition transform duration-300 ease-in"
            x-transition:leave-start="transition transform translate-y-0 scale-100 opacity-100"
            x-transition:leave-end="transition transform -translate-y-20 scale-95 opacity-0"
            :class="shake ? 'animate-shake' : ''"
            class="bg-secondary p-6 rounded-xl shadow-lg w-80 transition-transform relative">

            <p class="text-xl font-semibold text-neutralDark">Di batalin?</p>
            <p class="text-sm text-neutralGray mt-1">Kalau di batalin, nanti datanya ga kesimpan</p>

            <div class="mt-4 flex justify-end gap-3">
                <button @click="showConfirm = false"
                    class="px-4 py-2 text-neutralGray border rounded-lg">
                    Kembali
                </button>
                <button @click="showConfirm = false; resetForm(); open = false"
                    class="px-4 py-2 bg-red-600 text-secondary rounded-lg">
                    Ya, Batal
                </button>
            </div>
        </div>
    </div>



    <!-- CSS Animasi -->
    <style>
        @keyframes shake {

            0%,
            100% {
                transform: translateX(0);
            }

            25% {
                transform: translateX(-5px);
            }

            50% {
                transform: translateX(5px);
            }

            75% {
                transform: translateX(-3px);
            }
        }

        .animate-shake {
            animation: shake 0.3s ease-in-out;
        }
    </style>
</div>