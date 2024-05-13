<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'name',
        'status',
        'post_type',
        'post_password',
        'content',
        'comment_status',
        'author_id',
        'parent_id',
        'menu_order',
        'post_mime_type',
        'comment_count',
        'created_at',
        'updated_at',
        'slug',
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

    protected $attributes = [
        'status' => DRAFT,
        'menu_order' => 0,
        'comment_status' => 0,
    ];

    protected $appends = [
        'converted_created_at', 'converted_updated_at'
    ];

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function root()
    {
        return $this->belongsTo(Post::class, 'parent_id');
    }

    public static function statuses()
    {
        return [DRAFT, PUBLISHED, PENDING, SCHEDULED, TRASH];
    }

    public function isPage()
    {
        return $this->post_type == PAGE;
    }

    public function getConvertedCreatedAtAttribute()
    {
        return $this->created_at->format('d-m-Y H:i:s');
    }

    public function getConvertedUpdatedAtAttribute()
    {
        return $this->updated_at->format('d-m-Y H:i:s');
    }

    public function getLinkAttribute()
    {
        return route('page', ['slug' => $this->slug]);
    }

    public static function allPages()
    {
        return self::where('status', PUBLISHED)
            ->where('post_type', PAGE)
            ->orderBy('menu_order', 'asc')
            ->get();
    }
}
