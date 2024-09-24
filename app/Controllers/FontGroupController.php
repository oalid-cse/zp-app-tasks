<?php

namespace OalidCse\Controllers;
use OalidCse\Models\FontGroup;
use OalidCse\Models\FontGroupFont;

require_once __DIR__ . "/../../config.php";
require_once __DIR__."/../../app/Models/FontGroup.php";
require_once __DIR__."/../../app/Models/FontGroupFont.php";

class FontGroupController
{
    private FontGroup $fontGroupModel;
    private FontGroupFont $fontGroupFontModel;
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

    public function updateFontGroup($request): array
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

            $this->fontGroupModel->update($fontGroupId, ['group_name' => $name]);

            $this->fontGroupFontModel->deleteByFontGroupId($fontGroupId);

            foreach ($fontIds as $fontId) {
                $this->fontGroupFontModel->store([
                    'font_group_id' => $fontGroupId,
                    'font_id' => $fontId
                ]);
            }

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
