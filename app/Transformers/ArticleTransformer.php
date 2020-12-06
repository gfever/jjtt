<?php

declare(strict_types=1);

namespace App\Transformers;

use App\Models\Article;
use League\Fractal\TransformerAbstract;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     title="ArticleTransformer",
 *     description="Article response schema"
 * )
 *
 * @OA\Property(
 *     format="integer",
 *     property="id",
 *     title="Id",
 *     description="id",
 *     type="integer"
 * )
 *
 * @OA\Property(
 *     format="string",
 *     property="title",
 *     title="Title",
 *     description="Article title",
 *     type="string"
 * )
 *
 * @OA\Property(
 *     format="string",
 *     property="body",
 *     title="Body",
 *     description="Article body",
 *     type="string"
 * )
 *
 * @OA\Property(
 *     format="date",
 *     property="created_at",
 *     title="CreatedAt",
 *     description="Article creation date",
 *     type="string"
 * )
 *
 * @OA\Property(
 *     format="date",
 *     property="updated_at",
 *     title="UpdatedAt",
 *     description="Article update date",
 *     type="string"
 * )
 */

class ArticleTransformer extends TransformerAbstract
{
    /**
     * @param Article $article
     *
     * @return array
     */
    public function transform(Article $article): array
    {
        return [
            'id' => $article->id,
            'title' => $article->title,
            'body' => $article->body,
            'updatedAt' => $article->updated_at,
            'createdAt' => $article->created_at,
        ];
    }
}
