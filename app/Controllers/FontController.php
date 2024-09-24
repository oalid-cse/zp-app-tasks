<?php
namespace OalidCse\Controllers;

use OalidCse\Models\Font;

require_once __DIR__."/../../config.php";
require_once __DIR__."/../../app/Models/Font.php";

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
            $fileName = $file['name'];
            $fileTmpName = $file['tmp_name'];
            $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
            $fileName = explode('.', $fileName)[0];

            // Validate only TTF files
            if (strtolower($fileExtension) !== 'ttf') {
                return [
                  'status' => 400,
                  'msg' => 'Only .ttf files are allowed.'
                ];
            }

            // Save the file to the uploads directory
            $newFileName = uniqid('', true) . '.ttf';
            $destination = $this->getUploadDir() . $newFileName;

            if (move_uploaded_file($fileTmpName, $destination)) {
                // Save the file details to the database
                $storeData = [
                    'name' => $fileName,
                    'file' => $newFileName,
                    'status' => 1
                ];
                $this->fontModel->store($storeData);

                return [
                  'status' => 200,
                  'msg' => 'Font uploaded successfully!',
                ];
            } else {
                return [
                  'status' => 400,
                  'msg' => 'Failed to upload font.'
                ];
            }

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

        //check if font exists in font groups
        $conn = getConnection();
        $stmt = $conn->prepare("SELECT * FROM font_group_fonts WHERE font_id = ?");
        $stmt->bind_param('i', $fontId);
        $stmt->execute();
        $result = $stmt->get_result();
        $fontGroup = $result->fetch_assoc();
        $stmt->close();

        if ($fontGroup) {
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
