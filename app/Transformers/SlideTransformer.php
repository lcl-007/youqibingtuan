<?php


namespace App\Transformers;

use App\Models\Slide;
use League\Fractal\TransformerAbstract;

class SlideTransformer extends TransformerAbstract
{
public function transform(Slide $Slide)
{
    return [
      'id' =>$Slide->id,
      'title'=>$Slide->title,
      'url'=>$Slide->url,
      'img'=>$Slide->img,
      'seq'=>$Slide->seq,
      'status'=>$Slide->status,
      'created_at'=>$Slide->created_at,
      'updated_at'=>$Slide->updated_at,
    ];
}


}
