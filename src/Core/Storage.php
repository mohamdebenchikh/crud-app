<?php

namespace App\Core;

class Storage
{
    protected $basePath;

    public function __construct()
    {
        $this->basePath = ROOT_DIR . BASE_PATH . '/public';

    }

    public function store($file, $path = null)
    {
        $targetPath = $path ?  $this->basePath . '/' . $path : $this->basePath;

        // Create the directory if it doesn't exist
        if (!is_dir($targetPath)) {
            mkdir($targetPath, 0777, true);
        }

        $fileName = $this->generateFileName($file);
        $filePath = $targetPath . '/' . $fileName;
        $fileUrl = $path ? url("/$path/$fileName") : url("/$fileName");

        // Move the uploaded file to the target path
        move_uploaded_file($file['tmp_name'], $filePath);

        // Return the file path
        return $fileUrl;
    }

    protected function generateFileName($file)
    {
        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $fileName = uniqid() . '.' . $extension;

        return $fileName;
    }
}
