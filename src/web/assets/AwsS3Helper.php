<?php
/**
 * @link      https://craftcms.com/
 * @copyright Copyright (c) Pixel & Tonic, Inc.
 * @license   MIT
 */

namespace barrelstrength\awss3helper\web\assets;

use craft\web\AssetBundle;
use craft\web\assets\cp\CpAsset;

/**
 * Asset bundle for the Dashboard
 */
class AwsS3Helper extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->sourcePath = '@awss3helper/web/assets/dist';

        $this->depends = [
            CpAsset::class,
        ];

        $this->js = [
            'js/editVolume.js',
        ];

        parent::init();
    }
}
