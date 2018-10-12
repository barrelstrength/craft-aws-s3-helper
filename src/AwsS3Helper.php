<?php

namespace barrelstrength\awss3helper;

use barrelstrength\awss3helper\services\App;
use barrelstrength\awss3helper\volumes\Restricted;
use craft\base\Plugin;
use Craft;
use craft\events\RegisterComponentTypesEvent;
use craft\events\RegisterUrlRulesEvent;
use craft\services\Volumes;
use craft\web\UrlManager;
use yii\base\Event;


class AwsS3Helper extends Plugin
{
    public static $app;

    /**
     * @throws \yii\base\InvalidConfigException
     */
    public function init()
    {
        parent::init();

        $this->setComponents([
            'app' => App::class
        ]);

        self::$app = $this->get('app');

        Craft::setAlias('@awss3helper', $this->getBasePath());

        Event::on(Volumes::class, Volumes::EVENT_REGISTER_VOLUME_TYPES, function(RegisterComponentTypesEvent $event) {
            $event->types[] = Restricted::class;
        });

        Event::on(UrlManager::class, UrlManager::EVENT_REGISTER_SITE_URL_RULES, function(RegisterUrlRulesEvent $event) {

            $event->rules['aws-s3-helper/restricted/<volumeId:\d+>/<filename>'] = 'aws-s3-helper/restricted/view';

        });
    }
}
