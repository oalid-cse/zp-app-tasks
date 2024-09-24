<?php

namespace OalidCse\Models;

require_once 'Model.php';

class FontGroupFont extends Model
{
    public function __construct()
    {
        parent::__construct('font_group_fonts');
    }

    public function deleteByFontGroupId($id)
    {
        $fontGroupFonts = $this->db->table($this->table)->where(['font_group_id' => $id])->get();
        foreach ($fontGroupFonts as $fontGroupFont) {
            $this->delete($fontGroupFont['id']);
        }

    }
}
