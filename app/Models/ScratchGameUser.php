<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScratchGameUser extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function scratchgame(){
        return $this->belongsTo(ScratchGame::class , 'scratch_game_id');
    }
}
