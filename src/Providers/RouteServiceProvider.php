<?php

namespace Yajra\CMS\Providers;

use Yajra\CMS\Entities\Article;
use Yajra\CMS\Entities\Category;
use Yajra\CMS\Entities\Widget;
use Yajra\CMS\Http\Controllers\ArticleController;
use Yajra\CMS\Http\Controllers\AuthController;
use Yajra\CMS\Http\Controllers\CategoryController;
use Yajra\CMS\Repositories\Article\ArticleRepository;
use Yajra\CMS\Repositories\Category\CategoryRepository;
use App\User;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Routing\Router;
use Yajra\Acl\Models\Permission;
use Yajra\Acl\Models\Role;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your site controller routes.
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @param  \Illuminate\Routing\Router $router
     * @return void
     */
    public function boot(Router $router)
    {
        $router->model('users', User::class);
        $router->model('roles', Role::class);
        $router->model('permissions', Permission::class);
        $router->model('widgets', Widget::class);
        $router->model('articles', Article::class);
        $router->model('categories', Category::class);

        parent::boot($router);
    }

    /**
     * Define the routes for the application.
     *
     * @param  \Illuminate\Routing\Router $router
     * @return void
     */
    public function map(Router $router)
    {
        $this->mapWebRoutes($router);
    }

    /**
     * Define the "web" routes for the application.
     * These routes all receive session state, CSRF protection, etc.
     *
     * @param  \Illuminate\Routing\Router $router
     * @return void
     */
    protected function mapWebRoutes(Router $router)
    {
        $this->mapArticleRoutes($router);

        $this->mapCategoryRoutes($router);

        $this->mapAdministratorAuthenticationRoutes($router);

        $this->mapAdministratorRoutes($router);
    }

    /**
     * Map dynamic article routes using the slug.
     *
     * @param \Illuminate\Routing\Router $router
     */
    protected function mapArticleRoutes(Router $router)
    {
        try {
            /** @var ArticleRepository $repository */
            $repository = app(ArticleRepository::class);
            $repository->getAllPublished()->each(function (Article $article) use ($router) {
                $middleware = ['web'];
                if ($article->requiresAuthentication()) {
                    $middleware[] = 'auth';
                }

                if ($article->permissions->count()) {
                    if ($article->authorization === 'can') {
                        $article->permissions->each(function (Permission $permission) use ($middleware) {
                            $middleware[] = 'can:' . $permission->slug;
                        });
                    } else {
                        $abilities    = $article->permissions->pluck('slug')->toArray();
                        $middleware[] = 'canAtLeast:' . implode(',', $abilities);
                    }
                }

                $router->get($article->alias, function () use ($article, $router) {
                    return $this->app->call(ArticleController::class . '@show', [
                        'article'    => $article,
                        'parameters' => $router->current()->parameters(),
                    ]);
                })->middleware($middleware)->name($article->title);
            });
        } catch (QueryException $e) {
            // \\_(",)_//
        }
    }

    /**
     * Map dynamic article routes using the slug.
     *
     * @param \Illuminate\Routing\Router $router
     */
    protected function mapCategoryRoutes(Router $router)
    {
        try {
            /** @var CategoryRepository $repository */
            $repository = app(CategoryRepository::class);
            $repository->getAllPublished()->each(function (Category $category) use ($router) {
                $middleware = ['web'];
                if ($category->requiresAuthentication()) {
                    $middleware[] = 'auth';
                }

                $router->get('category/' . $category->alias, function () use ($category, $router) {
                    return $this->app->call(CategoryController::class . '@show', [
                        'category'   => $category,
                        'parameters' => $router->current()->parameters(),
                    ]);
                })->middleware($middleware)->name($category->title);
            });
        } catch (QueryException $e) {
            // \\_(",)_//
        }
    }

    /**
     * Map administrator authentication routes.
     *
     * @param \Illuminate\Routing\Router $router
     */
    protected function mapAdministratorAuthenticationRoutes(Router $router)
    {
        $router->get('administrator/login', [
            'middleware' => 'web',
            'uses'       => AuthController::class . '@showLoginForm',
        ])->name('administrator.login');

        $router->get('administrator/logout', [
            'middleware' => 'web',
            'uses'       => AuthController::class . '@logout',
        ])->name('administrator.logout');

        $router->post('administrator/login', [
            'middleware' => 'web',
            'uses'       => AuthController::class . '@login',
        ]);
    }

    /**
     * Map administrator routes.
     *
     * @param \Illuminate\Routing\Router $router
     */
    protected function mapAdministratorRoutes(Router $router)
    {
        $router->group([
            'middleware' => 'administrator',
            'prefix'     => 'administrator',
        ], function ($router) {
            require base_path('administrator/Http/routes.php');
        });
    }
}
