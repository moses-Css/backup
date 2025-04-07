<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\BackupController;

class BackupGoogle extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:backup-google {filePath?} {fileName?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Backup file to Google Drive.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $filePath = $this->argument('filePath');
        $fileName = $this->argument('fileName');
    
        $backupController = new BackupController();
    
        if ($filePath && $fileName) {
            // Backup file spesifik
            $fileId = $backupController->backupToGoogleDrive($filePath, $fileName);
    
            if ($fileId) {
                $this->info("File berhasil di-upload dengan ID: $fileId");
            } else {
                $this->error("Terjadi kesalahan saat upload file.");
            }
        } else {
            // Backup seluruh folder photos
            $this->info("Memulai backup semua foto di folder photos...");
            $result = $backupController->backupPhotosToGoogleDrive();
            $this->info($result);
        }
    }
}
