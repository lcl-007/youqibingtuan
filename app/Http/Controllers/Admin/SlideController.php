<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Models\slide;
use App\Transformers\SlideTransformer;
use Illuminate\Http\Request;

class SlideController extends BaseController
{
    /**
     *轮播图列表
     */
    public function index()
    {
        //
        $slides = slide::paginate(2);
        return $this->response->paginator($slides,new SlideTransformer());
    }

    /**
    *添加
     */
    public function store(Request $request) 
    {
        //查询最大的seq

        $max_seq = Slide::max('seq')?? 0;
        $max_seq++ ;
        $request->offsetSet('seq',$max_seq);
        $slide = Slide::create($request->all());

        return $this->response->created();
    }

    /**
     *详情
     */
    public function show(Slide $slide)
    {
        return $this->response->item($slide, new SlideTransformer);
    }

    /**
    *更新
     */
    public function update(Request $request,Slide $slide)
    {
        $slide->update($request->all());
        return $this->response->created();
    }

    /**
    *删除
     */
    public function destroy(Slide $slide)
    {
        $slide->delete();
        return $this->response->noContent();
    }

    /**
    *排序
     */
    public function seq(Request $request,Slide $slide)
    {
        $slide->seq = $request->input('seq',1);
        $slide->save();
        return $this->response->noContent();
    }

    /**
     * 轮播图禁用启用
     */
    public function status(Slide $slide)
    {
        $slide->status = $slide->status == 1 ? 0 : 1;
        $slide->save();
        return $this->response->noContent();
    }
}
