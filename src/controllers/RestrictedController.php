<?php

namespace barrelstrength\awss3helper\controllers;

use barrelstrength\awss3helper\volumes\Restricted;
use craft\web\Controller;
use Craft;

class RestrictedController extends Controller
{
    public function actionView()
    {
        $volumeId = Craft::$app->getRequest()->getSegment(3);
        $file = Craft::$app->getRequest()->getParam('file');

        if ($volumeId) {
            /**
             * @var $volume Restricted
             */
            $volume = Craft::$app->getVolumes()->getVolumeById($volumeId);

            $stream = $volume->getObject($file);

            header("Content-Type: {$stream['mimetype']}");
            echo $stream['contents'];
            exit;
        }
    }
}