<?php

namespace App\Http\Livewire;

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
    protected $updatesQueryString = ['search', 'category', 'startDate', 'endDate'];

    protected $listeners = [
        'setDateRange' => 'setDateRange',
        'clearDateRange' => 'clearDateRange'
    ];

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
    $query = ActivityLogs::with('user');

    // Penerapan filter pencarian
    if (!empty($this->search)) {
        $query->where(function ($q) {
            $q->whereHas('user', function($q2) {
                $q2->where('name', 'like', '%' . $this->search . '%');
            })->orWhere('activity', 'like', '%' . $this->search . '%');
        });
    }

    // Filter berdasarkan kategori
    if ($this->category !== 'Semua') {
        if ($this->category == 'Login') {
            // Corrected: Use 'activity' instead of 'action'
            $query->whereIn('activity', ['login', 'logout']);
        } elseif ($this->category == 'Foto') {
            // Corrected: Use 'activity'
            $query->where('activity', 'Menambahkan foto baru');
        } elseif ($this->category == 'Kategori') {
            // Corrected: Use 'activity'
            $query->where('activity', 'Menambahkan kategori');
        }
    }

    // Filter tanggal
    if ($this->startDate && $this->endDate) {
        $query->whereBetween('created_at', [
            Carbon::parse($this->startDate)->startOfDay(), 
            Carbon::parse($this->endDate)->endOfDay()
        ]);
    }

    // Ambil data logs
    $logs = $query->latest()->paginate(10);

    return view('livewire.activity-logs-table', [
        'logs' => $logs, // Pastikan variabel $logs diteruskan
    ]);
}
}
