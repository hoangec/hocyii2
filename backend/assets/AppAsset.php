<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css',
        'css/vendor/jquery.bootstrap-touchspin.css',
        'css/vendor/bootstrap-switch.css',
    ];
    public $js = [
        'js/ec-app.js',
        'js/vendor/jquery.bootstrap-touchspin.js',
        'js/vendor/bootstrap-switch.js',
        'js/vendor/autoNumeric.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
