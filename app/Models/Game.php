<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;
    protected $fillable = [
        'name', 
        'open_time',
  
    ];
    public function gameResults()
    {
        return $this->hasMany(GameResult::class, 'game_fk_id');
    }

}
