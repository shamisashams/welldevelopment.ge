<?php
/**
 *  app/Models/Translations/ProductTranslation.php
 *
 * Date-Time: 30.07.21
 * Time: 10:34
 * @author Insite LLC <hello@insite.international>
 */
namespace App\Models\Translations;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductTranslation extends BaseTranslationModel
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $fillable = [
        'title',
        'short_description',
        'description',
        'meta_title',
        'meta_description',
        'meta_keyword',
    ];
}
