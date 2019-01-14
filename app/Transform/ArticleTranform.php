<?php
namespace App\Transform;

use App\Models\Article;
use League\Fractal\TransformerAbstract;

class ArticleTranform extends TransformerAbstract
{
	public function transform(Article $article)
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