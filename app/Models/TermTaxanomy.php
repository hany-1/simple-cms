<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TermTaxanomy extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'taxonomy',
        'description',
        'term_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [];

    protected $attributes = [];

    protected $appends = [];

    public function term()
    {
        return $this->belongsTo(Term::class, 'term_id');
    }
}
