<?php
namespace OalidCse\Controllers;

use OalidCse\Helpers\FileManager;
use OalidCse\Models\Font;

require_once __DIR__."/../../config.php";
require_once __DIR__."/../../app/Models/Font.php";
require_once __DIR__."/../../app/Helpers/FileManager.php";

class FontController
{
    private $fontModel;
    public function __construct()
    {
        $this->fontModel = new Font();
    }

    public function getUploadDir()
    {
        return __DIR__."/../../uploads/fonts/";
    }
    public function uploadFont($file)
    {
        try {

            $fileManager = new FileManager();
            $fileNames = $fileManager->uploadFonts($file);

            // Save the file details to the database
            $storeData = [
                'name' => $fileNames['filename'],
                'file' => $fileNames['file'],
                'status' => 1
            ];
            $this->fontModel->store($storeData);

            return [
              'status' => 200,
              'msg' => 'Font uploaded successfully!',
            ];

        } catch (\Exception $e) {
            return [
                'status' => 500,
                'msg' => $e->getMessage()
            ];
        }
    }

    public function getFonts()
    {
        $fonts = $this->fontModel->all();
        return [
            'status' => 200,
            'fonts' => $fonts
        ];
    }

    public function deleteFont($fontId)
    {
        //check if font exists
        $font = $this->fontModel->read($fontId);
        if (!$font) {
            return [
                'status' => 404,
                'msg' => 'Font not found.'
            ];
        }

        if ($this->fontModel->checkHasGroup($fontId)) {
            return [
                'status' => 400,
                'msg' => 'Font is using in group! Please delete the group or remove the fonts from group first.'
            ];
        }

        //delete font
        $this->fontModel->delete($fontId);

        //delete file from storage
        try {
            unlink($this->getUploadDir() . $font['file']);
        } catch (\Exception $e) {
        }

        return [
            'status' => 200,
            'msg' => 'Font deleted successfully.'
        ];


    }
}
