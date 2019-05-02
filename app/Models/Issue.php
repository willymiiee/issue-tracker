<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Issue extends Model
{
    use SoftDeletes;
    protected $fillable = ['category_id', 'name', 'description', 'due_date', 'created_by', 'updated_by', 'deleted_by'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }

    public function labels()
    {
        return $this->belongsToMany('App\Models\Label');
    }

    public function assignees()
    {
        return $this->belongsToMany('App\Models\User', 'issue_assignee', 'issue_id', 'user_id');
    }
}
