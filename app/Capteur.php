<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Capteur extends Model
{
  protected $fillable = [
  'code_capteur',
  'etat',
  'etab',
  'type',
  'parent'
];
}
