<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JoinParty extends Model{
    use HasFactory;

    /**
    * The table associated with the model.
    *
    * @var string
    */
   protected $table = 'tmp_user_to_party';
   /**
    * The primary key associated with the table.
    *
    * @var string
    */
   protected $primaryKey = 'tmp_user_to_party_id';
   /**
    * Indicates if the model should be timestamped.
    *
    * @var bool
    */
   public $timestamps = false;
}
