<?php

namespace OalidCse\Controllers;
use OalidCse\Models\FontGroup;
use OalidCse\Models\FontGroupFont;

require_once __DIR__ . "/../../config.php";
require_once __DIR__."/../../app/Models/FontGroup.php";
require_once __DIR__."/../../app/Models/FontGroupFont.php";

class FontGroupController
{
    private $fontGroupModel;
    private $fontGroupFontModel;
    public function __construct()
    {
        $this->fontGroupModel = new FontGroup();
        $this->fontGroupFontModel = new FontGroupFont();
    }
    public function storeFontGroup($request)
    {
        try {
            //validation
            $name = $request['name'];
            $fontIds = $request['font_ids'];
            if (empty($name)) {
                return [
                  'status' => 400,
                  'msg' => 'Name is required.'
                ];
            }
            if (empty($fontIds)) {
                return [
                  'status' => 400,
                  'msg' => 'Font ids are required.'
                ];
            }

            if (count($fontIds) < 2) {
                return [
                  'status' => 400,
                  'msg' => 'At least 2 fonts are required.'
                ];
            }

            // Save the file details to the database
            $storeData = [
                'group_name' => $name
            ];
            $fontGroup = $this->fontGroupModel->store($storeData);
            $fontGroupId = $fontGroup['id'];

            foreach ($fontIds as $fontId) {
                $storeData = [
                    'font_group_id' => $fontGroupId,
                    'font_id' => $fontId
                ];
                $this->fontGroupFontModel->store($storeData);
            }

            return [
              'status' => 200,
              'msg' => 'Font group created successfully!'
            ];
        } catch (\Exception $e) {
            return [
              'status' => 500,
              'msg' => $e->getMessage()
            ];
        }
    }

    public function getFontGroups()
    {
        try {

            $groups = $this->fontGroupModel->all();
            $fontGroups = [];
            foreach ($groups as $fontGroup) {
                $fontGroup['fonts'] = $this->fontGroupModel->fonts($fontGroup['id']);
                $fontGroups[] = $fontGroup;
            }

            return [
              'status' => 200,
              'font_groups' => $fontGroups
            ];
        } catch (\Exception $e) {
            return [
              'status' => 500,
              'msg' => $e->getMessage()
            ];
        }
    }

    public function deleteFontGroup($fontGroupId)
    {
        try {
            $fontGroup = $this->fontGroupModel->read($fontGroupId);

            if (!$fontGroup) {
                return [
                  'status' => 404,
                  'msg' => 'Font group not found.'
                ];
            }

            $this->fontGroupModel->delete($fontGroupId);

            $this->fontGroupFontModel->deleteByFontGroupId($fontGroupId);

            return [
              'status' => 200,
              'msg' => 'Font group deleted successfully!'
            ];
        } catch (\Exception $e) {
            return [
              'status' => 500,
              'msg' => $e->getMessage()
            ];
        }
    }

    public function updateFontGroup($request)
    {
        try {
            //validation
            $fontGroupId = $request['id'];
            $name = $request['name'];
            $fontIds = $request['font_ids'];
            if (empty($name)) {
                return [
                  'status' => 400,
                  'msg' => 'Name is required.'
                ];
            }
            if (empty($fontIds)) {
                return [
                  'status' => 400,
                  'msg' => 'Font ids are required.'
                ];
            }

            if (count($fontIds) < 2) {
                return [
                  'status' => 400,
                  'msg' => 'At least 2 fonts are required.'
                ];
            }

            $conn = getConnection();
            $stmt = $conn->prepare("UPDATE font_groups SET group_name = ? WHERE id = ?");
            $stmt->bind_param('si', $name, $fontGroupId);
            $stmt->execute();
            $stmt->close();

            $stmt = $conn->prepare("DELETE FROM font_group_fonts WHERE font_group_id = ?");
            $stmt->bind_param('i', $fontGroupId);
            $stmt->execute();
            $stmt->close();

            $stmt = $conn->prepare("INSERT INTO font_group_fonts (font_group_id, font_id) VALUES (?, ?)");

            foreach ($fontIds as $fontId) {
                $stmt->bind_param('ii', $fontGroupId, $fontId);
                $stmt->execute();
            }
            $stmt->close();

            return [
              'status' => 200,
              'msg' => 'Font group updated successfully!'
            ];
        } catch (\Exception $e) {
            return [
              'status' => 500,
              'msg' => $e->getMessage()
            ];
        }
    }
}
