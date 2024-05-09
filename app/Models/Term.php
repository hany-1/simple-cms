<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Term extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'slug',
        'created_at',
        'updated_at'
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

    protected $appends = [
        'converted_created_at', 'converted_updated_at'
    ];

    public function taxanomy()
    {
        return $this->hasOne(TermTaxanomy::class);
    }

    public function getConvertedCreatedAtAttribute()
    {
        return $this->created_at->format('d-m-Y H:i:s');
    }

    public function getConvertedUpdatedAtAttribute()
    {
        return $this->updated_at->format('d-m-Y H:i:s');
    }
}
