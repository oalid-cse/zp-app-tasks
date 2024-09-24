<?php

namespace OalidCse\Controllers;
require_once __DIR__ . "/../../config.php";

class FontGroupController
{

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

            $conn = getConnection();
            $stmt = $conn->prepare("INSERT INTO font_groups (group_name) VALUES (?)");
            $stmt->bind_param('s', $name);
            $stmt->execute();
            $fontGroupId = $stmt->insert_id;
            $stmt->close();

            $stmt = $conn->prepare("INSERT INTO font_group_fonts (font_group_id, font_id) VALUES (?, ?)");

            foreach ($fontIds as $fontId) {
                $stmt->bind_param('ii', $fontGroupId, $fontId);
                $stmt->execute();
            }
            $stmt->close();

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
            $conn = getConnection();
            $stmt = $conn->prepare("SELECT * FROM font_groups");
            $stmt->execute();
            $result = $stmt->get_result();
            $stmt->close();

            $fontGroups = [];
            while ($row = $result->fetch_assoc()) {
                $innerRow = $row;
                $stmt = $conn->prepare("SELECT f.* FROM font_group_fonts fgf JOIN fonts f ON fgf.font_id = f.id WHERE fgf.font_group_id = ?");
                $stmt->bind_param('i', $row['id']);
                $stmt->execute();
                $result2 = $stmt->get_result();
                $fonts = $result2->fetch_all(MYSQLI_ASSOC);
                $stmt->close();
                $innerRow['fonts'] = $fonts;

                $fontGroups[] = $innerRow;
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

            $conn = getConnection();
            $stmt = $conn->prepare("SELECT * FROM font_groups WHERE id = ?");
            $stmt->bind_param('i', $fontGroupId);
            $stmt->execute();
            $result = $stmt->get_result();
            $fontGroup = $result->fetch_assoc();
            $stmt->close();

            if (!$fontGroup) {
                return [
                  'status' => 404,
                  'msg' => 'Font group not found.'
                ];
            }

            $stmt = $conn->prepare("DELETE FROM font_groups WHERE id = ?");
            $stmt->bind_param('i', $fontGroupId);
            $stmt->execute();
            $stmt->close();

            $stmt = $conn->prepare("DELETE FROM font_group_fonts WHERE font_group_id = ?");
            $stmt->bind_param('i', $fontGroupId);
            $stmt->execute();
            $stmt->close();

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
