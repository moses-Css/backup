<div x-data="{ open: false }" x-show="open" @open-modal.window="open = true" @close-modal.window="open = false" class="fixed inset-0 flex items-center justify-center z-50" style="display: none;">
                    <div x-show="open" @click="open = false" class="fixed bg-neutralDark inset-0 bg-opacity-20 backdrop-blur-sm transition-opacity duration-300" style="display: none;"></div>

                    <!-- Modal -->
                    <div x-show="open"
                        x-transition:enter="transition transform duration-300"
                        x-transition:enter-start="scale-75 opacity-0"
                        x-transition:enter-end="scale-100 opacity-100"
                        x-transition:leave="transition transform duration-300"
                        x-transition:leave-start="scale-100 opacity-100"
                        x-transition:leave-end="scale-75 opacity-0"
                        class="bg-secondary p-7 rounded-4xl shadow-lg w-full max-w-md z-10 text-neutralDark">
                        <form method="POST" action="{{ route('kategoris.store') }}">
                            @csrf
                            <div class="mb-4 w-full ">
                                <svg x-show="open" @click="open = false" class="justify-self-end hover:cursor-pointer" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#1e1e1e" viewBox="0 0 256 256">
                                    <path d="M204.24,195.76a6,6,0,1,1-8.48,8.48L128,136.49,60.24,204.24a6,6,0,0,1-8.48-8.48L119.51,128,51.76,60.24a6,6,0,0,1,8.48-8.48L128,119.51l67.76-67.75a6,6,0,0,1,8.48,8.48L136.49,128Z"></path>
                                </svg>
                                <h2 class="text-2xl font-medium">Kategori Baru</h2>
                                <label class="block mb-2 text-sm text-neutralGray">Untuk kategorisasi foto dan mempermudah pencarian</label>
                            </div>
                            <input type="text" name="nama" placeholder="Nama Kategori" class=" w-full p-4 rounded-full border border-neutralGray2">
                            <div class="mt-4 w-full">
                                <x-primary-button class="w-full  flex items-center justify-center !rounded-full py-4">Simpan</x-primary-button>
                            </div>
                        </form>
                    </div>
                </div>