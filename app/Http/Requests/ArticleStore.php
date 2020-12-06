<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Annotations as OA;

/**
 * @property-read string $title
 * @property-read string $body
 *
 * @OA\Schema(
 *     title="ArticleStore",
 *     description="Create article",
 *     required={"title", "body"}
 * )
 *
 * @OA\Property(
 *     format="string",
 *     description="Title",
 *     property="title",
 *     type="string"
 * )
 *
 * @OA\Property(
 *     format="string",
 *     description="Body",
 *     property="body",
 *     type="string"
 * )
 */
class ArticleStore extends FormRequest
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
            'title' => 'required|max:255',
            'body' => 'required|string'
        ];
    }
}
