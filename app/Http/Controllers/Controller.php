<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use OpenApi\Annotations as OA;

/**
 * @OA\Info(
 *     version="1.0.0",
 *     title="APS API",
 *     description="API for APS",
 *     @OA\License(
 *         name="Apache 2.0",
 *         url="http://www.apache.org/licenses/LICENSE-2.0.html"
 *     )
 * )
 *
 * @OA\Schema(
 *     schema="Pagination",
 *     title="Pagination",
 *     description="Pagination response schema"
 * )
 *
 * @OA\Property(
 *     format="integer",
 *     property="total",
 *     title="Total",
 *     type="integer"
 * )
 *
 * @OA\Property(
 *     format="integer",
 *     property="count",
 *     title="Count",
 *     type="integer"
 * )
 *
 * @OA\Property(
 *     format="integer",
 *     property="per_page",
 *     title="Per page",
 *     type="integer"
 * )
 *
 * @OA\Property(
 *     format="integer",
 *     property="current_page",
 *     title="Current page",
 *     type="integer"
 * )
 *
 * @OA\Property(
 *     format="integer",
 *     property="total_page",
 *     title="Total page",
 *     type="integer"
 * )
 *
 */
class Controller extends BaseController
{
    use AuthorizesRequests;
    use DispatchesJobs;
    use ValidatesRequests;
}
