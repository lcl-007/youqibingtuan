<?php


namespace App\Transformers;

use App\Models\Category;
use League\Fractal\TransformerAbstract;

class CategoryTransformer extends TransformerAbstract
{
public function transform(Category $Category)
{
    return [
        'id'=>$Category->id,
        'name'=>$Category->name,
    ];
}


}
