<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Models\comment;
use App\Models\Good;
use App\Transformers\CommentTransformer;
use Illuminate\Http\Request;

class CommentController extends BaseController
{
    /** 
     * 评论列表
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //获取搜索条件
        $rate = $request->query('content');
        $goods_title = $request->query('goods_title');

        $comments = comment::when($rate,function($query)use($rate){
            $query->where('content',$rate);
        })
        ->when($goods_title,function($query)use($goods_title){
            //先去查看相关的id
            $goods_ids = Good::where('title','like',"%{$goods_title}%")->pluck('id');
            $query->whereIn('goods_id',$goods_ids);
        })
        ->paginate(2);
        return $this->response->paginator($comments,new CommentTransformer());
    }

    

    /**
     * 评价详情
     *
     */
    public function show(comment $comment)
    {
        return $this->response->item($comment, new CommentTransformer());
    }

/**
 * 商家回复
 */
    public function reply(Request $request,comment $comment)
    {
        //验证
        $request->validate([
            'reply'=>'required|max:255'
        ],[
            'reply.required'=>'回复不能为空',
            'reply.max'=>'回复字数不能超过255个字符'
        ]);
        //更新
        $comment->reply = $request->input('reply');
        $comment->save();
        return $this->response->noContent();
    }
}

