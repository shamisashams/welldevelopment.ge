<?php

namespace App\Models;

use App\Models\Translations\AttributeTranslation;
use App\Traits\ScopeFilter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Attribute extends Model
{
    use HasFactory, Translatable, ScopeFilter;

    protected $table = 'attributes';

    public $translatedAttributes = ['name'];

    /** @var string */
    protected $translationModel = AttributeTranslation::class;

    protected $fillable = [
        'type',
        'code',
        'position'
    ];

    public function getFilterScopes(): array
    {
        return [
            'id' => [
                'hasParam' => true,
                'scopeMethod' => 'id'
            ],
            'name' => [
                'hasParam' => true,
                'scopeMethod' => 'nameTranslation'
            ],
            'code' => [
                'hasParam' => true,
                'scopeMethod' => 'code'
            ],
        ];
    }


    public function options(): HasMany
    {
        return $this->hasMany(AttributeOption::class);
    }
}
