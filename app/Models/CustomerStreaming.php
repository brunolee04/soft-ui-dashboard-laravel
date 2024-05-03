<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerStreaming extends Model{
    use HasFactory;
     /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'watch_provider_to_customer';
    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'watch_provider_to_customer_id';
    /**odel should be timestamped.
     *
     * Indicates if the m
     * @var bool
     */
    public $timestamps = false;
}
