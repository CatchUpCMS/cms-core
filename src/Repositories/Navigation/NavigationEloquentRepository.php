<?php

namespace Yajra\CMS\Repositories\Navigation;

use Yajra\CMS\Entities\Navigation;
use Yajra\CMS\Repositories\RepositoryAbstract;

/**
 * Class NavigationEloquentRepository
 *
 * @package App\Repositories\Administrator\Navigation
 */
class NavigationEloquentRepository extends RepositoryAbstract implements NavigationRepository
{
    /**
     * Get all published navigation.
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getPublished()
    {
        return $this->getModel()->with([
            'menus' => function ($query) {
                $query->limitDepth(1)->orderBy('order', 'asc');
            },
            'menus.permissions',
        ])->published()->get();
    }

    /**
     * Get repository model.
     *
     * @return \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Builder
     */
    public function getModel()
    {
        return new Navigation();
    }
}