<section
    class=" text-neutralDark text-center bg-secondary dark:bg-neutralDark  bg-[radial-gradient(#e5e7eb_1px,transparent_1px)] dark:bg-[radial-gradient(#E6E6EB_1px,transparent_1px)] [background-size:16px_16px] ">
    <div class="px-10 pb-24 pt-12">
        <div class="w-full items-center mx-auto ">
        <img class="max-w-40 items-center mx-auto flex justify-center" src="{{ asset('build/assets/logo/logoapp.png') }}" alt="Logo">

            <x-head-hero id="x-head-text" style="clip-path: polygon(0 0, 100% 0, 100% 100%, 0% 100%);">
                {{__('Galeri Digital BKKBN')}}
            </x-head-hero>
            <x-text-hero data-aos="fade-up" data-aos-duration="1000" style="clip-path: polygon(0 0, 100% 0, 100% 100%, 0% 100%);" >{{__('Platform resmi untuk mengelola, menyimpan, dan mengakses foto
                    dokumentasi BKKBN dengan mudah, aman, dan terstruktur.')}}</x-text-hero>

        </div>


        <p class="text-sm text-neutralGray mt-8">Kemudahan Pencarian</p>
        <livewire:search-form />
        <div class="flex items-center justify-center mt-8 space-x-5">
            <div class="flex items-center -space-x-4">
                <img alt="Gradient circle with pink and purple colors" class="w-10 h-10 rounded-full" height="50"
                    src="https://img.freepik.com/free-photo/coast-view-from_1122-2193.jpg?uid=R75841348&ga=GA1.1.238188613.1737446352&semt=ais_hybrid_sidr"
                    width="50" />
                <img alt="Gradient circle with cream and yellow colors" class="w-10 h-10 rounded-full" height="50"
                    src="https://img.freepik.com/premium-photo/view-mount-bromo-tumpak-sewu-waterfalls-indonesia_53876-110176.jpg?uid=R75841348&ga=GA1.1.238188613.1737446352&semt=ais_hybrid_sidr"
                    width="50" />
                <img alt="Gradient circle with red and orange colors" class="w-10 h-10 rounded-full" height="50"
                    src="https://img.freepik.com/free-photo/beautiful-landscape-around-lake-kawaguchiko_74190-3062.jpg?uid=R75841348&ga=GA1.1.238188613.1737446352&semt=ais_hybrid_sidr"
                    width="50" />
                <img alt="Gradient circle with purple and blue colors" class="w-10 h-10 rounded-full" height="50"
                    src="https://img.freepik.com/premium-photo/view-foggy-mountain-landscape_1359-742.jpg?uid=R75841348&ga=GA1.1.238188613.1737446352&semt=ais_hybrid_sidr"
                    width="50" />
                <img alt="Gradient circle with gray and beige colors" class="w-10 h-10 rounded-full" height="50"
                    src="https://img.freepik.com/free-photo/vertical-shot-green-mountain-buildings-hill-middle-near-sea-sunny-day_181624-2168.jpg?uid=R75841348&ga=GA1.1.238188613.1737446352&semt=ais_hybrid_sidr"
                    width="50" />
                <div class="flex items-center space-x-1 text-gray-500">
                    <i class="fas fa-heart text-blue-500"></i>
                    <i class="fas fa-music text-blue-500"></i>
                    <i class="fas fa-camera text-blue-500"></i>
                    <i class="fas fa-bolt text-blue-500"></i>
                </div>
            </div>
            <span class="text-neutralGray">1,700 Foto Lebih</span>
        </div>

    </div>
  
</script>
</section>