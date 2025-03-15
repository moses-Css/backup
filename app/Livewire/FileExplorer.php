<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Group;
use App\Models\Kategori;
use App\Models\Photo;
use App\Models\Image;
use Illuminate\Support\Facades\Storage;

class FileExplorer extends Component
{

    public $path = [];
    public $breadcrumbs = [];
    public $selectedItems = [];
    public $lastSelectedId = null;
    public $ctrlPressed = false;
    public $shiftPressed = false;

    protected $queryString = ['path' => ['except' => []]];
    protected $listeners = [
        'setPath' => 'handleSetPath',
        'keydown' => 'handleKeyDown',
        'keyup' => 'handleKeyUp',
        'confirm-delete' => 'confirmDelete',
        'show-preview' => 'handleShowPreview'
    ];

    
    public function handleKeyDown($event = null)
    {
        if ($event && $event['key'] === 'Shift') {
            $this->shiftPressed = true;
        }
        if ($event && ($event['key'] === 'Control' || $event['key'] === 'Meta')) {
            $this->ctrlPressed = true;
        }
    }

    public function handleKeyUp($event = null)
    {
        if ($event && $event['key'] === 'Shift') {
            $this->shiftPressed = false;
        }
        if ($event && ($event['key'] === 'Control' || $event['key'] === 'Meta')) {
            $this->ctrlPressed = false;
        }
    }

    public function enableShiftSelection()
    {
        $this->shiftPressed = true;
    }

    public function disableShiftSelection()
    {
        $this->shiftPressed = false;
    }

    public function selectItem($id)
    {
        if ($this->shiftPressed && $this->lastSelectedId !== null) {
            $this->handleShiftSelection($id);
        } elseif ($this->ctrlPressed) {
            $this->handleCtrlSelection($id);
        } else {
            $this->handleSingleSelection($id);
        }

        $this->lastSelectedId = $id;
    }

    private function handleShiftSelection($id)
    {
        $currentIds = $this->items->pluck('id')->toArray();
        $lastIndex = array_search($this->lastSelectedId, $currentIds);
        $currentIndex = array_search($id, $currentIds);

        $start = min($lastIndex, $currentIndex);
        $end = max($lastIndex, $currentIndex);

        $selectionRange = array_slice($currentIds, $start, $end - $start + 1);

        $this->selectedItems = array_unique(
            array_merge($this->selectedItems, $selectionRange)
        );
    }
    private function handleCtrlSelection($id)
    {
        if (in_array($id, $this->selectedItems)) {
            $this->selectedItems = array_diff($this->selectedItems, [$id]);
        } else {
            $this->selectedItems[] = $id;
        }
    }

    private function handleSingleSelection($id)
    {
        $this->selectedItems = [$id];
    }

    // Unselect all items
    public function unselectAll()
    {
        $this->selectedItems = [];
        $this->lastSelectedId = null;
    }


    public function deleteSelectedItems()
    {
        $currentLevel = count($this->path);
        $currentType = 'kategori';

        if ($currentLevel === 1) $currentType = 'group';
        elseif ($currentLevel === 2) $currentType = 'image';

        if ($currentType === 'kategori') {
            Kategori::whereIn('id', $this->selectedItems)->delete();
        } elseif ($currentType === 'group') {
            Group::whereIn('id', $this->selectedItems)->delete();
        } elseif ($currentType === 'image') {
            Image::whereIn('id', $this->selectedItems)->delete();
        }

        $this->selectedItems = [];
    }

    public function deleteItem($id)
    {
        $currentLevel = count($this->path);
        $currentType = 'kategori';

        if ($currentLevel === 1) $currentType = 'group';
        elseif ($currentLevel === 2) $currentType = 'image';

        switch ($currentType) {
            case 'kategori':
                Kategori::find($id)->delete();
                break;
            case 'group':
                Group::find($id)->delete();
                break;
            case 'image':
                Image::find($id)->delete();
                break;
        }


        $this->selectedItems = array_diff($this->selectedItems, [$id]);
    }

    public function confirmDelete($data)
    {
        $this->deleteItem($data['id']);
    }

    public function updatedPath()
    {
        $this->emit('updateUrl', $this->path);
    }

    public function handleSetPath($path)
    {
        $this->path = $path;
        $this->updateBreadcrumbs();
    }

    public function mount()
    {
        try {
            // Validasi path
            if (count($this->path) > 0) {
                if (!Kategori::find($this->path[0])) {
                    $this->path = [];
                }
            }
            $this->updateBreadcrumbs();
        } catch (\Exception $e) {
            $this->path = [];
            $this->updateBreadcrumbs();
        }
    }

    public function updateBreadcrumbs()
    {

        $this->breadcrumbs =  [['name' => 'kategori', 'id' => null]];

        if (!empty($this->path)) {
            $kategori = Kategori::find($this->path[0]);
            if ($kategori) {
                $this->breadcrumbs[] = ['name' => $kategori->nama, 'id' => $kategori->id];
            }

            if (count($this->path) > 1) {
                $group = Group::find($this->path[1]);
                if ($group) {
                    $this->breadcrumbs[] = ['name' => $group->title, 'id' => $group->id];
                }
            }
        }
    }


    public function navigateTo($type, $id)
    {
        try {
            if ($type === 'kategori') {
                $this->path = [$id];
            } elseif ($type === 'group') {
                if (!isset($this->path[0])) {
                    throw new \Exception('Invalid navigation path');
                }
                $this->path = [$this->path[0], $id];
            }
            $this->updateBreadcrumbs();
        } catch (\Exception $e) {
            $this->resetPath();
            session()->flash('error', 'Navigasi tidak valid');
        }

        $this->selectedItems = [];
    }

    private function resetPath()
    {
        $this->path = [];
        $this->updateBreadcrumbs();
    }

    public function goToBreadcrumb($index)
    {
        if ($index === 0) {
            $this->path = [];
        } elseif ($index === 1) {
            $this->path = [$this->breadcrumbs[1]['id']];
        } elseif ($index === 2) {
            $this->path = [$this->breadcrumbs[1]['id'], $this->breadcrumbs[2]['id']];
        }
        $this->updateBreadcrumbs();
        $this->selectedItems = [];
    }

    public function previewImage($imageId)
    {
        $this->dispatch('show-preview', imageId: $imageId);
    }

    public function handleShowPreview($imageId)
    {
        $this->dispatch('open-modal', 'image-preview', ['imageId' => $imageId]);
    }

    public function render()
    {
        $currentLevel = count($this->path);
        $currentType = 'kategori';
        $items = collect();

        if ($currentLevel === 0) {
            $items = Kategori::with(['groups.photos.images'])
                ->get(['id', 'nama'])
                ->each(function ($kategori) {
                    $kategori->groups->each(function ($group) {
                        $group->total_images = $group->photos->sum(fn($photo) => $photo->images->count());
                    });
                });
        } elseif ($currentLevel === 1) {
            $currentType = 'group';
            $items = Group::where('kategori_id', $this->path[0])
                ->with(['photos.images'])
                ->get(['id', 'kategori_id', 'title'])
                ->each(function ($group) {
                    $group->total_images = $group->photos->sum(fn($photo) => $photo->images->count());
                });
        } elseif ($currentLevel === 2) {
            $currentType = 'image';
            $items = Image::whereHas('photo', fn($q) => $q->where('group_id', $this->path[1]))
                ->get(['id', 'photo_id', 'path']);
        }

        return view('livewire.file-explorer', compact('items', 'currentType'));
    }
}
