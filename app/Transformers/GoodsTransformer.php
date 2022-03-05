<?php


namespace App\Transformers;

use App\Models\Good;
use League\Fractal\TransformerAbstract;

class GoodsTransformer extends TransformerAbstract
{
    protected $availableIncludes = ['category','user','comments'];

public function transform(Good $good)
{
    return [
        'id' =>$good->id,
            'title'=>$good->title,
            'category_id'=>$good->category_id,
            'description'=>$good->description,
            'price'=>$good->price,
            'stock'=>$good->stock,
            'cover'=>$good->cover,
            'pics'=>$good->pics,
            'details'=>$good->details,
            'sales'=>$good->sales,
            'is_on'=>$good->is_on,
            'is_recommend'=>$good->is_recommend,
            'time'=>$good->time,
            'appointment'=>$good->appointment,
            'people_num'=>$good->people_num,
            'created_at'=>$good->created_at,
            'updated_at'=>$good->updated_at,

    ];
}
/**
 * 额外的分类数据
 */
public function includeCategory(Good $good)
{
    return $this->item($good->category,new CategoryTransformer());
}

/**
 * 额外的用户数据
 */
public function includeUser(Good $good)
{
    return $this->item($good->user,new UserTransformer());
}

/**
 * 额外的评价
 */
public function includeComments(Good $good)
{
    return $this->collection($good->comments,new CommentTransformer());
}

}
