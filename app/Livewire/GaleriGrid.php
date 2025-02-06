<?php

namespace App\Livewire;

use Livewire\Component;

class GaleriGrid extends Component
{

    public $activeCategory = 'all';
    public $galleryItems = [
        ['id' => 1, 'category' => 'hutri', 'image' => 'https://img.freepik.com/free-photo/vertical-shot-beautiful-mountainous-landscape_181624-30135.jpg?uid=R75841348&ga=GA1.1.238188613.1737446352&semt=ais_hybrid_sidr', 'title' => 'HUT RI', 'description' => 'Perayaan kemerdekaan'],
        ['id' => 2, 'category' => 'minggu', 'image' => 'https://img.freepik.com/premium-photo/sunrise-view-morning-mountains_38649-228.jpg?uid=R75841348&ga=GA1.1.238188613.1737446352&semt=ais_hybrid_sidr', 'title' => 'Minggu Ceria', 'description' => 'Kegiatan minggu pagi'],
        ['id' => 3, 'category' => 'sosial', 'image' => 'https://img.freepik.com/free-photo/landscape-dawn-overlooking-volcano-batur-volcano-bali-indonesia_72229-987.jpg?uid=R75841348&ga=GA1.1.238188613.1737446352&semt=ais_hybrid_sidr', 'title' => 'Kegiatan Sosial', 'description' => 'Bakti sosial'],
        ['id' => 3, 'category' => 'sabtu', 'image' => 'https://img.freepik.com/free-photo/vertical-shot-green-mountain-buildings-hill-middle-near-sea-sunny-day_181624-2168.jpg?uid=R75841348&ga=GA1.1.238188613.1737446352&semt=ais_hybrid_sidr', 'title' => 'Kegiatan Sosial', 'description' => 'Bakti sosial'],
        ['id' => 3, 'category' => 'pancasila', 'image' => 'https://img.freepik.com/premium-photo/view-mount-bromo-tumpak-sewu-waterfalls-indonesia_53876-110176.jpg?uid=R75841348&ga=GA1.1.238188613.1737446352&semt=ais_hybrid_sidr', 'title' => 'Kegiatan Sosial', 'description' => 'Bakti sosial'],
        ['id' => 3, 'category' => 'perayaan', 'image' => 'https://img.freepik.com/free-photo/panoramic-landscape-overlooking-three-amazing-ponds-lagoa-de-santiago-rasa-lagoa-azul-lagoa-seven-cities-azores-are-one-main-tourist-destinations-portugal_231208-6692.jpg?uid=R75841348&ga=GA1.1.238188613.1737446352&semt=ais_hybrid_sidr', 'title' => 'Kegiatan Sosial', 'description' => 'Bakti sosial'],
    ];

    protected $listeners = ['categoryChanged' => 'updateCategory']; // ✅ Pastikan listener ada!

    public function updateCategory($category)
    {
        $this->activeCategory = $category;
    }

    public function render()
    {
        $filteredItems = $this->activeCategory === 'all'
            ? $this->galleryItems
            : array_filter($this->galleryItems, fn($item) => $item['category'] === $this->activeCategory);

        return view('livewire.galeri-grid', ['filteredItems' => $filteredItems]);
    }
    
}
