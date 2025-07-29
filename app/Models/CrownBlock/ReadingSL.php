<?php

namespace App\Models\CrownBlock;

use Illuminate\Database\Eloquent\Model;

class ReadingSL extends Model
{
    protected $table = 'ws_certifications_crown_block_sand_line_reading';
    public $timestamps = false;

    protected $fillable = [
        'certification_id',
        'sl_nominal_wire',
        'groove_a',
        'groove_b',
        'groove_c',
        'groove_d',
        'sand_line_photo_depth',
        'sand_line_photo_wear',
        'pass_fail',
    ];

    public function crownBlock()
    {
        return $this->belongsTo(Main::class, 'certification_id', 'certification_id');
    }
}
