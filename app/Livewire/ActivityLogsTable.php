<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\ActivityLogs;
use Carbon\Carbon;

class ActivityLogsTable extends Component
{
    use WithPagination;

    public $search = '';
    public $category = 'Semua'; // Bisa disesuaikan: 'Semua', 'Foto', 'Kategori', 'Login'
    public $startDate = null;
    public $endDate = null;

    // Reset pagination saat properti berubah
    protected $queryString = [
        'search' => ['except' => '', 'as' => 'q'],
        'category' => ['except' => 'Semua'],
        'startDate' => ['as' => 'from'],
        'endDate' => ['as' => 'to']
    ];

    protected $listeners = [
        'setDateRange' => 'setDateRange',
        'clearDateRange' => 'clearDateRange'
    ];


    public function updatedSearch()
    {
        // Jika search kosong, reset pagination
        if (empty($this->search)) {
            $this->resetPage();
        }
    }
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingCategory()
    {
        $this->resetPage();
    }

    public function updatingStartDate()
    {
        $this->resetPage();
    }

    public function updatingEndDate()
    {
        $this->resetPage();
    }

    /**
     * Callback yang dipanggil dari JS daterangepicker.
     * Parameter $start dan $end dalam format 'YYYY-MM-DD'
     */
    public function setDateRange($start, $end)
    {
        $this->startDate = $start;
        $this->endDate   = $end;
        $this->resetPage();
    }

    // Optional: fungsi untuk mengosongkan filter tanggal
    public function clearDateRange()
    {
        $this->startDate = null;
        $this->endDate   = null;
        $this->resetPage();
    }

    public function render()
    {
        $query = ActivityLogs::with('user')
            ->when($this->search, function ($q) {
                $q->where(function ($query) {
                    $query->whereHas('user', function ($q) {
                        $q->where('name', 'like', '%' . $this->search . '%');
                    })
                        ->orWhere('activity', 'like', '%' . $this->search . '%')
                        ->orWhere('created_at', 'like', '%' . $this->search . '%');
                });
            });

        // Filter berdasarkan kategori
        if ($this->category !== 'Semua') {
            $query->where(function ($q) {
                switch ($this->category) {
                    case 'Login':
                        $q->where(function($query) {
                            $query->where('activity', 'like', '%login%')
                                  ->orWhere('activity', 'like', '%logout%');
                        });
                        break;
                    case 'Foto':
                        $q->where(function($query) {
                            $query->where('activity', 'like', '%foto%')
                                  ->orWhere('activity', 'like', '%photo%')
                                  ->orWhere('activity', 'like', '%image%');
                        });
                        break;
                    case 'Kategori':
                        $q->where(function($query) {
                            $query->where('activity', 'like', '%kategori%')
                                  ->orWhere('activity', 'like', '%category%');
                        });
                        break;
                }
            });
        }

        // Filter tanggal
        if ($this->startDate && $this->endDate) {
            $query->whereBetween('created_at', [
                Carbon::parse($this->startDate)->startOfDay()->timezone('Asia/Jakarta'),
                Carbon::parse($this->endDate)->endOfDay()->timezone('Asia/Jakarta')
            ]);
        }

        // Ambil data logs
        $logs = $query->latest()->paginate(10);

        return view('livewire.activity-logs-table', compact('logs'));
    }
}
