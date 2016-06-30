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
     */
    public function handle($scripts, $category = null)
    {
        foreach ((array)$scripts as $script) {
            if (! str_contains('.js', $script)) {
                $script .= ".js";
            }
            Asset::add(app(FileAssetRepository::class)->getByName($script, $category)->url);
        }
    }
}