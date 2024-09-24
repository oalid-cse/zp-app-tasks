<?php

namespace OalidCse\Helpers;

class FileManager
{

    public function getUploadDir()
    {
        return __DIR__."/../../uploads/fonts/";
    }
    public function uploadFonts($file): array
    {
        $fileName = $file['name'];
        $fileTmpName = $file['tmp_name'];
        $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
        $fileName = explode('.', $fileName)[0];

        // Validate only TTF files
        if (strtolower($fileExtension) !== 'ttf') {
            throw new \Exception('Only .ttf files are allowed.');
        }

        // Save the file to the uploads directory
        $newFileName = uniqid('', true) . '.ttf';
        $destination = $this->getUploadDir() . $newFileName;
        if(move_uploaded_file($fileTmpName, $destination)) {
            return [
                'filename' => $fileName,
                'file' => $newFileName
            ];
        }

        throw new \Exception('Failed to upload font.');
    }
}
