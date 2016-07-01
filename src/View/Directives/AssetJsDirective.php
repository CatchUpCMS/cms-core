<?php

namespace Yajra\CMS\View\Directives;

use Roumen\Asset\Asset;
use Yajra\CMS\Repositories\FileAsset\FileAssetRepository;

class AssetJsDirective
{
    /**
     * Page header blade directive compiler.
     * @pageHeader($title, $description, $icon, $template)
     *
     * @param string|array $scripts
     * @param null $category
     * @param string $group
     */
    public function handle($scripts, $group = 'footer', $category = null)
    {
        foreach ((array)$scripts as $script) {
            if (! str_contains('.js', $script)) {
                $script .= ".js";
            }
            /** @var \Yajra\CMS\Entities\FileAsset $getData */
            $getData = app(FileAssetRepository::class)->getByName($script, $category);
            Asset::add($getData ? $getData->url : $script, $group);
        }
    }
}