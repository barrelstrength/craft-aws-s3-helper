<?php

namespace barrelstrength\awss3helper\volumes;

use craft\awss3\Volume;
use Craft;
use craft\helpers\Assets;

/**
 * Class Volume
 *
 * @property mixed  $settingsHtml
 * @property string $rootUrl
 *
 * @author Pixel & Tonic, Inc. <support@pixelandtonic.com>
 * @since  3.0
 */
class Restricted extends Volume
{
    public static function displayName(): string
    {
        return 'Sprout Amazon S3 Restricted';
    }

    /**
     * @return null|string
     * @throws \Twig_Error_Loader
     * @throws \yii\base\Exception
     */
    public function getSettingsHtml()
    {
        return Craft::$app->getView()->renderTemplate('aws-s3-helper/volumeSettings', [
            'volume' => $this,
            'periods' => array_merge(['' => ''], Assets::periodList()),
            //'storageClasses' => static::storageClasses(),
        ]);
    }
}
