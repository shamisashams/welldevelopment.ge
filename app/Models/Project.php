<?php

namespace App\Models;

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



class Project extends Model
{
    use Translatable, HasFactory, ScopeFilter;

    /**
     * @var string
     */
    protected $table = 'projects';

    /**
     * @var string[]
     */
    protected $fillable = [
        'status',
        'recreational_space',
        'parking',
        'slug',
        'city_id',
        'district_id'
    ];

    /** @var string */
    protected $translationModel = ProjectTranslation::class;

    //protected $with = ['translation'];

    /** @var array */
    public $translatedAttributes = [
        'title',
        'short_description',
        'description',
        'address'
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


    public function coverSlider(){
        return $this->morphMany(File::class, 'fileable')->where('cover',1);
    }

    public function slider(){
        return $this->morphMany(File::class, 'fileable')->where('cover',0);
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
        return $this->belongsToMany(Detail::class,'project_details');
    }

    public function apartments():HasMany{
        return $this->hasMany(Apartment::class);
    }


    public function city():BelongsTo{
        return $this->belongsTo(City::class);
    }

    public function district():BelongsTo{
        return $this->belongsTo(District::class);
    }

    public function slide(){
        return $this->hasOne(Slider::class);
    }
}
