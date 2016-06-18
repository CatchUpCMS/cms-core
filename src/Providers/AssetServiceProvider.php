<?php

namespace Yajra\CMS\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Roumen\Asset\Asset;
use Yajra\CMS\Entities\Configuration;
use Yajra\CMS\Entities\FileAsset;

/**
 * Class AssetServiceProvider
 *
 * @package Yajra\CMS\Providers
 */
class AssetServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->addAdminAssets();
        $this->requireAdminDefaultAssets();
        $this->assetJs();
        $this->assetCss();
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
    }

    /**
     * Load admin assets.
     */
    protected function addAdminAssets()
    {
        foreach (config('asset.admin_assets') as $asset) {
            Asset::add($this->getAssetUrlByname($asset)->url);
        }
    }

    /**
     * Load require admin default assets.
     */
    protected function requireAdminDefaultAssets()
    {
        foreach (config('asset.admin_required_assets', []) as $asset => $requiredValue) {
            Asset::add($requiredValue);
        }
    }

    /**
     * Load js assets.
     *
     * @return string
     */
    protected function assetJs()
    {
        Blade::directive('assetJs', function ($asset) {
            $asset = $this->getAssetUrlByname($this->strParser($asset . '.js'));

            return '<?php echo "<script src=\"' . $asset->url . '\"></script>"; ?>';
        });
    }

    /**
     * Load css assets.
     *
     * @return string
     */
    protected function assetCss()
    {
        Blade::directive('assetCss', function ($asset) {
            $asset = $this->getAssetUrlByname($this->strParser($asset . '.css'));

            return '<?php echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"' . $asset->url . '\">"; ?>';
        });
    }

    /**
     * @param string $str
     * @return string
     */
    private function strParser($str)
    {
        return str_replace("'", '', str_replace(['(', ')'], '', $str));
    }

    /**
     * Get url by asset name.
     *
     * @param string $asset
     * @return FileAsset
     */
    private function getAssetUrlByname($asset)
    {
        return FileAsset::where('name', $asset)
                        ->where('category', Configuration::key('asset.default'))
                        ->first();
    }
}
