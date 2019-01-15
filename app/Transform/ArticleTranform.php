<?php
namespace App\Transform;

class ArticleTranform extends TransformAbstract
{
	public function transform($article)
	{
		return [
		    'article_title'=>$article->title,
            'disease_id' =>$article->disease['id'],
            'disease_name' =>$article->disease['name'],
            'article_img' =>$article->image,
            'article_content'=>$article->content,
            'created_at' => $article->created_at->format('Y-m-d')
        ];
	}
}