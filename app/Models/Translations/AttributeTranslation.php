<?php

namespace App\Models\Translations;

use Illuminate\Database\Eloquent\Factories\HasFactory;


class AttributeTranslation extends BaseTranslationModel
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $fillable = [
        'name'
    ];
}
