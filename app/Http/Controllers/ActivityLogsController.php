<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\ActivityLogs;
use App\Helpers\LogHelper;
use Illuminate\Support\Facades\Auth;

class ActivityLogsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function dashboard()
    {
        $category = 'Semua';
        $logs = ActivityLogs::with('user')->latest()->paginate(10);     
        return view('dashboard', compact('logs','category'));
    }
    
    public function store(Request $request)
    {
        ActivityLogs::create([
            'user_id'   => Auth::id(),
            'action'    => 'Menambahkan foto baru',
            'timestamp' => now(),
            'activity'  => 'User menambahkan foto',
            'created_at' => now(), // Tambahkan manual
        ]);

        return redirect()->back()->with('success', 'Log berhasil ditambahkan.');
    }
    
    public function clearAllLogs()
    {
        ActivityLogs::truncate(); // Menghapus semua data di tabel activity_logs
        return redirect()->back()->with('success', 'Semua log aktivitas berhasil dihapus.');
    }

    // Fungsi untuk menghapus log berdasarkan ID
    public function deleteLog($id)
    {
        $log = ActivityLogs::find($id);
        if (!$log) {
            return redirect()->back()->with('error', 'Log tidak ditemukan.');
        }
        $log->delete();

        return redirect()->back()->with('success', 'Log berhasil dihapus.');
    }
}
