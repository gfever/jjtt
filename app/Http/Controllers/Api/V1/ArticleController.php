<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ArticleIndex;
use App\Http\Requests\ArticleStore;
use App\Http\Requests\ArticleUpdate;
use App\Models\Article;
use App\Transformers\ArticleTransformer;
use App\Transformers\MessageTransformer;
use Exception;
use Illuminate\Http\JsonResponse;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use League\Fractal\Serializer\DataArraySerializer;
use OpenApi\Annotations as OA;

class ArticleController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/v1/articles",
     *     operationId="getArticles",
     *     tags={"Articles"},
     *     summary="Get paginated list of articles",
     *     @OA\Response(
     *          response="200",
     *          description="List of articles",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="data",
     *                  type="array",
     *                  @OA\Items(ref="#/components/schemas/ArticleTransformer")
     *              ),
     *              @OA\Property(
     *                  property="meta",
     *                  type="object",
     *                  @OA\Property(
     *                      property="pagination",
     *                      type="object",
     *                      ref="#/components/schemas/Pagination"
     *                  )
     *              )
     *          )
     *     )
     * )
     *
     * @param Article $article
     * @param ArticleIndex $articleIndex
     * @return JsonResponse
     *
     */
    public function index(Article $article, ArticleIndex $articleIndex): JsonResponse
    {
        $articles = $article->newQuery()
            ->orderBy(
                $articleIndex->sortBy ?? 'id',
                $articleIndex->sortOrder ?? 'asc'
            )
            ->paginate($articleIndex->limit ?: 10);

        $data = fractal()->collection($articles)
            ->transformWith(new ArticleTransformer())
            ->serializeWith(new DataArraySerializer())
            ->paginateWith(new IlluminatePaginatorAdapter($articles))
            ->toArray();

        return response()->json($data);
    }

    /**
     * @OA\Post(
     *     path="/api/v1/articles",
     *     operationId="articleCreate",
     *     tags={"Articles"},
     *     summary="Create new article",
     *     description="Create new article and store to db",
     *     @OA\Parameter(
     *          name="Authorization",
     *          description="Authorization token: Bearer {token}",
     *          in="header",
     *          required=false,
     *          @OA\Schema(
     *              type="string"
     *          )
     *     ),
     *     @OA\RequestBody(
     *          @OA\JsonContent(ref="#/components/schemas/ArticleStore")
     *     ),
     *     @OA\Response(
     *          response="200",
     *          description="New article",
     *          @OA\JsonContent(ref="#/components/schemas/ArticleTransformer")
     *     ),
     *     @OA\Response(
     *          response="422",
     *          description="Validation error"
     *     )
     * )
     *
     * @param Article $article
     * @param ArticleStore $articleStore
     * @return JsonResponse
     */
    public function store(Article $article, ArticleStore $articleStore): JsonResponse
    {
        $newArticle = $article->newInstance();
        $newArticle->title = $articleStore->get('title');
        $newArticle->body = $articleStore->get('body');
        $newArticle->save();

        $data = fractal()->item($newArticle)
            ->transformWith(new ArticleTransformer())
            ->toArray();

        return response()->json($data);
    }

    /**
     * @OA\Put(
     *     path="/api/v1/articles/{articleId}",
     *     operationId="articleUpdate",
     *     tags={"Articles"},
     *     summary="Update article",
     *     description="Update article and save to db",
     *     security={"bearerAuth":{}},
     *     @OA\Parameter(
     *          name="Authorization",
     *          description="Authorization token: Bearer {token}",
     *          in="header",
     *          required=false,
     *          @OA\Schema(
     *              type="string"
     *          )
     *     ),
     *     @OA\RequestBody(
     *          @OA\JsonContent(ref="#/components/schemas/ArticleUpdate")
     *     ),
     *     @OA\Response(
     *          response="200",
     *          description="Updated article",
     *          @OA\JsonContent(ref="#/components/schemas/ArticleTransformer")
     *     ),
     *     @OA\Response(
     *          response="422",
     *          description="Validation error"
     *     ),
     *     @OA\Response(
     *          response="404",
     *          description="Article not found"
     *     )
     * )
     *
     * @param Article $article
     * @param ArticleUpdate $articleUpdate
     * @return JsonResponse
     */
    public function update(Article $article, ArticleUpdate $articleUpdate): JsonResponse
    {
        $title = $articleUpdate->get('title');
        if ($title) {
            $article->title = $title;
        }

        $body = $articleUpdate->get('body');
        if ($body) {
            $article->body = $body;
        }

        $article->save();

        $data = fractal()->item($article)
            ->transformWith(new ArticleTransformer())
            ->toArray();

        return response()->json($data);
    }

    /**
     * @OA\Delete(
     *     path="/api/v1/articles/{articleId}",
     *     operationId="articleDelete",
     *     tags={"Articles"},
     *     summary="Delete article",
     *     description="Delete article from db",
     *     security={"bearerAuth":{}},
     *     @OA\Parameter(
     *          name="Authorization",
     *          description="Authorization token: Bearer {token}",
     *          in="header",
     *          required=false,
     *          @OA\Schema(
     *              type="string"
     *          )
     *     ),
     *     @OA\Response(
     *          response="200",
     *          description="Result message",
     *          @OA\JsonContent(ref="#/components/schemas/MessageTransformer")
     *     ),
     *     @OA\Response(
     *          response="404",
     *          description="Article not found"
     *     )
     * )
     *
     * @param Article $article
     * @return JsonResponse
     * @throws Exception
     */
    public function delete(Article $article): JsonResponse
    {
        $article->delete();

        $data = fractal()->item(sprintf('Article #%d is deleted successfully', $article->id))
            ->transformWith(new MessageTransformer())
            ->toArray();

        return response()->json($data);
    }
}
