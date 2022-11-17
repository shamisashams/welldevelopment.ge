<?php

namespace App\Models\Translations;

use Illuminate\Database\Eloquent\Factories\HasFactory;


class AttributeOptionTranslation extends BaseTranslationModel
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $fillable = [
        'label'
    ];
}
