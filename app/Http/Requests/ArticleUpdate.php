<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Annotations as OA;

/**
 * @property-read string|null $title
 * @property-read string|null $body
 *
 * @OA\Schema(
 *     title="ArticleUpdate",
 *     description="Update article",
 *     required={}
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
class ArticleUpdate extends FormRequest
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
            'title' => 'string|max:255|nullable',
            'body' => 'string|nullable'
        ];
    }
}
