<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Kategori;
use App\Models\Group;
use App\Models\Photo;
use App\Models\Image;

class GalleryExplorer extends Component
{
    public $breadcrumbs = []; // Untuk menyimpan breadcrumb dinamis
    public $currentCategory = null;
    public $currentGroup = null;

    public function mount()
    {
        $this->breadcrumbs = [['name' => 'Kategori', 'type' => 'kategori', 'id' => null]];
    }

    public function selectCategory($categoryId)
    {
        $this->currentCategory = Kategori::with('groups')->findOrFail($categoryId);
        $this->currentGroup = null;
        $this->breadcrumbs = [['name' => 'Kategori', 'type' => 'kategori', 'id' => null]];
        $this->breadcrumbs[] = ['name' => $this->currentCategory->nama, 'type' => 'category', 'id' => $categoryId];
    }

    public function selectGroup($groupId)
    {
        $this->currentGroup = Group::with(['photos.images'])->findOrFail($groupId);
        $this->breadcrumbs[] = ['name' => $this->currentGroup->title, 'type' => 'group', 'id' => $groupId];
    }

    public function render()
    {
        $kategories = Kategori::all();

        return view('livewire.gallery-explorer', [
            'kategories' => $kategories,
            'groups' => $this->currentCategory ? $this->currentCategory->groups : [],
            'images' => $this->currentGroup ? $this->currentGroup->photos->flatMap->images : [],
            'breadcrumbs' => $this->breadcrumbs, // Kirim ke view
        ]);
    }
}
