<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Annotations as OA;

/**
 * @property-read string|null $sortBy
 * @property-read string|null $sortOrder
 * @property-read int|null $page
 * @property-read int|null $limit
 *
 * @OA\Schema(
 *     title="ArticleIndex",
 *     description="Get paginated list of articles",
 *     required={}
 * )
 *
 * @OA\Property(
 *     format="string",
 *     description="Field for sorting",
 *     property="sortby",
 *     type="string"
 * )
 *
 * @OA\Property(
 *     format="string",
 *     description="Sort order",
 *     property="sortOrder",
 *     type="string"
 * )
 *
 * @OA\Property(
 *     format="integer",
 *     description="Page size",
 *     property="limit",
 *     type="integer"
 * )
 */
class ArticleIndex extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'sortBy' => 'string|in:id,title,updated_at,created_at',
            'sortOrder' => 'string|in:asc,desc',
            'page' => 'integer',
            'limit' => 'integer'
        ];
    }
}
