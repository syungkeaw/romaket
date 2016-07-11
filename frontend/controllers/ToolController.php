<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class ToolController extends Controller
{
    public function actionShopLocation($map, $location)
    {
        if(!glob('../web/images/maps/'. $map)){
            throw new NotFoundHttpException(Yii::t('app', 'There is no the map name {map_name} in RO108.', [
                'map_name' => $map,
            ]));
        }

        // Create a image from file.
        $image = imagecreatefromgif('../web/images/maps/'. $map);

        // choose a color for the ellipse
        $ellipseColor = imagecolorallocate($image, 0, 255, 0);

        $axis = explode(',', $location);

        if($axis[0] == '' || $axis[1] == ''){
            throw new NotFoundHttpException(Yii::t('app', 'Your location is not correct. Please make sure the pattern of location has to look like this (x,y).'));
        }

        // draw the blue ellipse
        imagefilledellipse($image, $axis[0], $axis[1], 10, 10, $ellipseColor);

        // Output the image.
        header("Content-type: image/gif");
        imagegif($image);
    }
}
