<?php
/**
 * Created by NiNaCoder.
 * Date: 2019-07-28
 * Time: 01:42
 */

namespace App\Models;

use App\Scopes\PublishedScope;
use App\Scopes\VisibilityScope;
use App\Traits\FullTextSearch;
use App\Traits\SanitizedRequest;
use Illuminate\Database\Eloquent\Model;
use DB;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Post extends Model implements HasMedia
{
    use InteractsWithMedia, FullTextSearch;

    protected $fillable = ['title', 'short_content', 'full_content'];

    protected $searchable = ['title', 'short_content', 'full_content'];

    protected $appends = [
        'categories', 'artwork_url'
    ];

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new PublishedScope);
        static::addGlobalScope(new VisibilityScope);
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumbnail')
            ->width(config('settings.image_max_thumbnail', 800))
            ->keepOriginalImageFormat()
            ->performOnCollections('artwork')
            ->nonOptimized()->nonQueued();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getCategoriesAttribute()
    {
        return Category::whereIn('id', explode(',', $this->attributes['category']))->get();
    }

    public function getArtworkUrlAttribute()
    {
        return $this->getFirstMediaUrl('artwork') ? $this->getFirstMediaUrl('artwork', 'thumbnail') : null;
    }

    public function getPermalinkUrlAttribute($value)
    {
        return route('frontend.post', ['id' => $this->attributes['id'], 'slug' => str_slug(html_entity_decode($this->attributes['title']))]);
    }

    public function delete()
    {
        return parent::delete();
    }
}

