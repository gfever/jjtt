<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers;

use App\Http\Requests\ArticleStore;
use App\Http\Requests\ArticleUpdate;
use App\Models\Article;
use Illuminate\Pagination\LengthAwarePaginator;
use Mockery;
use Tests\TestCase;

final class ArticleControllerTest extends TestCase
{
    public function testIndex()
    {
        $article = Mockery::mock(Article::class);
        $article->shouldReceive('newQuery')->andReturnSelf();
        $article->shouldReceive('orderBy')->andReturnSelf();

        $paginator = $this->createMock(LengthAwarePaginator::class);
        $paginator->expects(self::once())->method('getIterator')->willReturn(collect([]));

        $article->shouldReceive('paginate')
            ->andReturn($paginator);

        $this->instance(Article::class, $article);

        $url = action('Api\V1\ArticleController@index');
        $response = $this->get($url);

        $response->assertStatus(200);
    }

    public function testCreate()
    {
        $article = Mockery::mock(Article::class);
        $article->shouldReceive('newInstance')->andReturnSelf();
        $article->shouldReceive('save');
        $article->shouldReceive('setAttribute');
        $article->shouldReceive('getAttribute');

        $this->instance(Article::class, $article);

        $request = $this->createMock(ArticleStore::class);
        $request->expects(self::exactly(2))->method('get')->willReturn('text');

        $this->instance(ArticleStore::class, $request);

        $url = action('Api\V1\ArticleController@store');
        $response = $this->post($url, [], ['Authorization' => 'Bearer ' . config('app.auth_token')]);

        $response->assertStatus(200);
    }

    public function testUpdate()
    {
        $article = Mockery::mock(Article::class);
        $article->shouldReceive('save');
        $article->shouldReceive('setAttribute');
        $article->shouldReceive('getAttribute');
        $article->shouldReceive('resolveRouteBinding')->andReturnSelf();

        $this->instance(Article::class, $article);

        $request = $this->createMock(ArticleUpdate::class);
        $request->expects(self::exactly(2))->method('get')->willReturn('text');

        $this->instance(ArticleUpdate::class, $request);

        $url = action('Api\V1\ArticleController@update', ['article' => 1]);
        $response = $this->put($url, [], ['Authorization' => 'Bearer ' . config('app.auth_token')]);

        $response->assertStatus(200);
    }

    public function testDelete()
    {
        $article = Mockery::mock(Article::class);
        $article->shouldReceive('delete');
        $article->shouldReceive('getAttribute');
        $article->shouldReceive('resolveRouteBinding')->andReturnSelf();

        $this->instance(Article::class, $article);

        $url = action('Api\V1\ArticleController@delete', ['article' => 1]);
        $response = $this->delete($url, [], ['Authorization' => 'Bearer ' . config('app.auth_token')]);

        $response->assertStatus(200);
    }
}
