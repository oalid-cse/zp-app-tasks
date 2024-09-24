<?php

namespace OalidCse\Models;

require_once 'Model.php';

class FontGroup extends Model
{
    public function __construct()
    {
        parent::__construct('font_groups');
    }

    public function fonts($id): array
    {
        $fontGroupFonts = $this->db->table('font_group_fonts')->where(['font_group_id'=> $id])->get();
        $fontIds = array_column($fontGroupFonts, 'font_id');
        $fonts = [];
        foreach ($fontIds as $fontId) {
            $font = $this->db->table('fonts')->read($fontId);
            $fonts[] = $font;
        }
        return $fonts;
    }

}
