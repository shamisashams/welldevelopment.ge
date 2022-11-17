<?php

namespace App\Models;

use App\Models\Translations\ApartmentTranslation;
use App\Models\Translations\BlogTranslation;
use App\Models\Translations\CityTranslation;
use App\Models\Translations\ProductTranslation;
use App\Models\Translations\ProjectTranslation;
use App\Traits\ScopeFilter;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;



class Apartment extends Model
{
    use Translatable, HasFactory, ScopeFilter;

    /**
     * @var string
     */
    protected $table = 'apartments';

    /**
     * @var string[]
     */
    protected $fillable = [
        'status',
        'project_id',
        'phone',
        'slug',
        'not_free',
        'action',
        'offer',
        'floors',
        'area'
    ];

    protected $casts = [
        'floors' => 'array'
    ];

    /** @var string */
    protected $translationModel = ApartmentTranslation::class;

    //protected $with = ['translation'];

    /** @var array */
    public $translatedAttributes = [
        'title',
        'short_description',
        'description',
    ];

    //protected $with = ['translation'];


    public function getFilterScopes(): array
    {
        return [
            'id' => [
                'hasParam' => true,
                'scopeMethod' => 'id'
            ],
            'slug' => [
                'hasParam' => true,
                'scopeMethod' => 'slug'
            ],
            'status' => [
                'hasParam' => true,
                'scopeMethod' => 'status'
            ],
            'title' => [
                'hasParam' => true,
                'scopeMethod' => 'titleTranslation'
            ],

        ];
    }







    /**
     * @return MorphMany
     */
    public function files(): MorphMany
    {
        return $this->morphMany(File::class, 'fileable');
    }

    /**
     * @return MorphOne
     */
    public function file(): MorphOne
    {
        return $this->morphOne(File::class, 'fileable');
    }


    public function oldestImage()
    {
        return $this->morphOne(File::class, 'fileable')->oldestOfMany();
    }

    public function latestImage()
    {
        return $this->morphOne(File::class, 'fileable')->latestOfMany();
    }

    public function details():BelongsToMany{
        return $this->belongsToMany(Detail::class,'apartment_details');
    }

    public function project():BelongsTo{
        return $this->belongsTo(Project::class);
    }

    public function setFloorsAttribute($value)
    {
        $this->attributes['floors'] = json_encode($value);
    }

    public function attribute_values(): HasMany
    {
        return $this->hasMany(ApartmentAttributeValue::class);
    }

    /*public function getFloorsAttribute($value)
    {
        return json_decode($value,true);
    }*/
}
