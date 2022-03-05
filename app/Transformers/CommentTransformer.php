<?php


namespace App\Transformers;

use App\Models\Comment;
use League\Fractal\TransformerAbstract;

class CommentTransformer extends TransformerAbstract
{
    //可以include的方法
    protected $availableIncludes = ['user','goods'];

public function transform(Comment $comment)
{
    // $pics_url = [];
    // if (is_array($comment->pics)) {
    //     foreach ($comment->pics as $p) {
    //         //array_push(1，2)函数:把参数2的值赋给参数1
    //         array_push($pics_url,oss_url($p));
    //     }
    // }

    return [
        'id'=>$comment->id,
        'user_id'=>$comment->user_id,
        'goods_id'=>$comment->goods_id,
        'content'=>$comment->content,
        'reply'=>$comment->reply,
        'created_at'=>$comment->created_at,
        'updated_at'=>$comment->updated_at,

    ];
}
/**
 * 额外的用户数据
 */
public function includeUser(Comment $comment)
{
return $this->item($comment->user,new UserTransformer());
}

/**
 * 额外的商品数据
 */
public function includeGoods(Comment $comment)
{
return $this->item($comment->goods,new GoodsTransformer());
}
}
