<?php

namespace App\Models;

use App\Models\Translations\AttributeOptionTranslation;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttributeOption extends Model
{
    use HasFactory, Translatable;

    protected $table = 'attribute_options';

    public $translatedAttributes = ['label'];

    /** @var string */
    protected $translationModel = AttributeOptionTranslation::class;

    protected $fillable = [
        'attribute_id',
    ];

}
