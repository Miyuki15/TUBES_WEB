<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seminar extends Model
{
    public $timestamps = True;
    use HasFactory;
    protected $guarded = ['id'];
}
