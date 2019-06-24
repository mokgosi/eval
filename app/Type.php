<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    protected $table = 'ttypes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'type', 'description', 'deleted'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    public $timestamps = false;

    public function profiles() 
    {
        return $this->hasMany('App\Profile' ,'tTYPES_id');
    }
}