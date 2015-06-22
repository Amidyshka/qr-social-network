<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{

    protected $fillable = array('link', 'description', 'user_id');

}
