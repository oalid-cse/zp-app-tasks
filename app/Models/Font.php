<?php

namespace OalidCse\Models;

require_once 'Model.php';

class Font extends Model
{
    public function __construct()
    {
        parent::__construct('fonts');
    }

    public function checkHasGroup($id)
    {
        $fontGroupFonts = $this->db->table('font_group_fonts')->where(['font_id' => $id])->get();
        return count($fontGroupFonts) > 0;
    }
}
