<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Intervention extends Model
{
  protected $fillable = [
      'type', 'commentaire', 'user', 'etab'
        ];
}
