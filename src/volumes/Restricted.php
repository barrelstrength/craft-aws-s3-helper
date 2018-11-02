<?php

namespace barrelstrength\awss3helper\volumes;

use craft\awss3\Volume;
use Craft;
use craft\helpers\Assets;
use League\Flysystem\AdapterInterface;

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
    const BASE_URL_RESTRICTED = "/aws-s3-helper/restricted/";

    public static function displayName(): string
    {
        return 'Amazon S3 Helper Restricted';
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

    public function getRootUrl()
    {
        return static::BASE_URL_RESTRICTED.$this->id .  "/?file=";
    }

    public function getObject($file)
    {
        $adapter = $this->createAdapter();

        $read = $adapter->read($file);

        return $read;
    }

    /**
     * Returns the visibility setting for the Volume.
     *
     * @return string
     */
    protected function visibility(): string
    {
        return AdapterInterface::VISIBILITY_PRIVATE;
    }
}