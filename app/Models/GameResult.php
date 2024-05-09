<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameResult extends Model
{
    use HasFactory;
    protected $fillable = [
        'result', 
        'date',
        'game_fk_id',
  
    ];
  // GameResult model
public function game()
{
    return $this->belongsTo(Game::class, 'game_fk_id');
}

}
