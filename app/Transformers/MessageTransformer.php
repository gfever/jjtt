<?php

declare(strict_types=1);

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     title="MessageTransformer",
 *     description="Article response schema"
 * )
 *
 *
 * @OA\Property(
 *     format="string",
 *     property="message",
 *     title="Message",
 *     type="string"
 * )
 */

class MessageTransformer extends TransformerAbstract
{
    /**
     * @param string $message
     *
     * @return array
     */
    public function transform(string $message): array
    {
        return ['message' => $message];
    }
}
