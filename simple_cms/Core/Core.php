<?php
/**
 * Created By : Ahmad Windi Wijayanto
 * Email : ahmadwindiwijayanto@gmail.com
 * website : https://whendy.net
 * --------- 4/15/20, 8:46 PM ---------
 */

namespace SimpleCMS\Core;


use SimpleCMS\Core\Supports\CoreAsset;
use SimpleCMS\Core\Supports\CoreSetting;

class Core
{
    /**
     * CoreAsset.
     *
     * @var \SimpleCMS\Core\Supports\CoreAsset
     */
    protected $asset;

    /**
     * CoreSetting.
     *
     * @var \SimpleCMS\Core\Supports\CoreSetting
     */
    protected $setting;


    /**
     * Create a new core instance.
     *
     * @param  \SimpleCMS\Core\Supports\CoreAsset $coreAsset
     * @param  \SimpleCMS\Core\Supports\CoreSetting $coreSetting
     *
     * @return \SimpleCMS\Core\Core
     */
    public function __construct(CoreAsset $coreAsset, CoreSetting $coreSetting)
    {
        $this->asset    = $coreAsset;
        $this->setting  = $coreSetting;
    }

    /**
     * Return asset instance.
     *
     * @return \SimpleCMS\Core\Supports\CoreAsset
     */
    public function asset()
    {
        return $this->asset;
    }

    /**
     * Return setting instance.
     *
     * @return \SimpleCMS\Core\Supports\CoreSetting
     */
    public function setting()
    {
        return $this->setting;
    }
}
