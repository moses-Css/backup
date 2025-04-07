<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Google\Client;
use Google\Service\Drive;
use Google\Service\Drive\DriveFile;
use Illuminate\Support\Facades\Storage;

class BackupController extends Controller
{
    /**
     * Melakukan backup file ke Google Drive.
     *
     * @param string $filePath
     * @param string $fileName
     * @return string
     */
    public function backupToGoogleDrive($filePath, $fileName)
    {
        // Buat instance client Google API
        $client = new Client();
        $client->setApplicationName('BKKBN GALERI'); // Ganti dengan nama aplikasi Anda
        $client->setAuthConfig(storage_path('app/google-drive.json')); // File service account JSON
        $client->addScope(Drive::DRIVE_FILE); // Akses yang dibutuhkan

        try {
            $service = new Drive($client); // Membuat instance Google Drive service

            // Membuat metadata file
            $fileMetadata = new DriveFile([
                'name'    => $fileName,
                'parents' => [env('GOOGLE_DRIVE_FOLDER_ID')], // Folder ID di Google Drive
            ]);

            // Ambil konten file dari penyimpanan lokal (gunakan disk 'public')
            if (!Storage::disk('public')->exists($filePath)) {
                return "Error: File tidak ditemukan di disk 'public'";
            }
            $content = Storage::disk('public')->get($filePath);

            // Upload file ke Google Drive
            $file = $service->files->create($fileMetadata, [
                'data'       => $content,
                'mimeType'   => 'application/octet-stream', // Ganti dengan MIME type yang sesuai jika perlu
                'uploadType' => 'multipart',
                'fields'     => 'id', // Hanya mengembalikan ID file
            ]);

            // Kembalikan ID file yang di-upload
            return $file->id;
        } catch (\Exception $e) {
            // Tangani error jika terjadi
            return 'Error: ' . $e->getMessage();
        }
    }


    public function backupPhotosToGoogleDrive()
    {
        $photosPath = public_path('storage/photos'); // Path utama folder photos
        $client = new Client();
        $client->setApplicationName('BKKBN GALERI');
        $client->setAuthConfig(storage_path('app/google-drive.json'));
        $client->addScope(Drive::DRIVE_FILE);

        $service = new Drive($client);
        $uploadedFiles = [];
        $googleFolders = [];

        // Ambil semua file dan folder dari photos/
        $files = $this->getAllFiles($photosPath);
        if (empty($files)) {
            return "❌ Tidak ada file yang ditemukan di folder photos.";
        }

        foreach ($files as $file) {
            // Ambil path relatif dari 'photos/'
            $relativePath = str_replace(public_path('storage') . '/', '', $file);
            $folderPath = dirname($relativePath);
            $fileName = basename($file);

            // Buat folder di Google Drive jika belum ada
            if (!isset($googleFolders[$folderPath])) {
                $folderId = $this->createGoogleDriveFolder($service, $folderPath);
                $googleFolders[$folderPath] = $folderId;
            }

            // Upload file ke folder yang sesuai di Google Drive
            $fileMetadata = new DriveFile([
                'name' => $fileName,
                'parents' => [$googleFolders[$folderPath]],
            ]);

            try {
                $content = file_get_contents($file);
                $uploadedFile = $service->files->create($fileMetadata, [
                    'data' => $content,
                    'mimeType' => mime_content_type($file),
                    'uploadType' => 'multipart',
                    'fields' => 'id',
                ]);

                $uploadedFiles[] = "✅ $fileName berhasil di-upload ke folder: $folderPath (ID: " . $uploadedFile->id . ")";
            } catch (\Exception $e) {
                $uploadedFiles[] = "❌ Gagal upload $fileName: " . $e->getMessage();
            }
        }

        return implode("\n", $uploadedFiles);
    }
    private function getAllFiles($directory)
    {
        $files = [];

        // Cek apakah folder ada
        if (!is_dir($directory)) {
            return $files; // Return array kosong jika folder tidak ditemukan
        }

        $iterator = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($directory));

        foreach ($iterator as $file) {
            if ($file->isFile()) {
                $files[] = $file->getPathname();
            }
        }

        return $files;
    }


    private function createGoogleDriveFolder($service, $folderPath)
    {
        $folderNames = explode('/', $folderPath); // Pecah berdasarkan '/'
        $parentId = env('GOOGLE_DRIVE_FOLDER_ID'); // Folder root di Google Drive

        foreach ($folderNames as $folderName) {
            // Cek apakah folder sudah ada di Google Drive
            $existingFolder = $this->getGoogleDriveFolderId($service, $folderName, $parentId);
            if ($existingFolder) {
                $parentId = $existingFolder;
            } else {
                // Buat folder baru
                $fileMetadata = new DriveFile([
                    'name' => $folderName,
                    'mimeType' => 'application/vnd.google-apps.folder',
                    'parents' => [$parentId],
                ]);

                $folder = $service->files->create($fileMetadata, ['fields' => 'id']);
                $parentId = $folder->id;
            }
        }

        return $parentId;
    }

    private function getGoogleDriveFolderId($service, $folderName, $parentId)
    {
        $query = sprintf(
            "name='%s' and mimeType='application/vnd.google-apps.folder' and '%s' in parents and trashed=false",
            addslashes($folderName),
            $parentId
        );

        $results = $service->files->listFiles([
            'q' => $query,
            'fields' => 'files(id)',
        ]);

        return count($results->getFiles()) > 0 ? $results->getFiles()[0]->getId() : null;
    }
}
