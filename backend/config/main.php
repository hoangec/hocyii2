<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'modules' => [
        'supplier' => [
            'class' => 'backend\modules\supplier\Supplier',            
        ],
        'invoice' => [
            'class' => 'backend\modules\invoice\Invoice',
            'defaultRoute' => 'invoice'
        ],
        'customer' => [
            'class' => 'backend\modules\customer\Customer',
            'defaultRoute' => 'customer'
        ],
        'item' => [
            'class' => 'backend\modules\item\Item',
            'defaultRoute' => 'item'
        ],
         'sale' => [
               'class' => 'backend\modules\sale\Sale',
               'defaultRoute' => 'sale',
        ],
    ],
    'components' => [
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,            
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
 /*       'view' => [
             'theme' => [
                 'pathMap' => [
                    '@app/views' => '@vendor/dmstr/yii2-adminlte-asset/example-views/yiisoft/yii2-app'
                 ],
             ],
        ],*/       
        'assetManager' => [
                'bundles' => [
                    'dmstr\web\AdminLteAsset' => [
                        'skin' => 'skin-red',
                    ],
                ],
            ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
    ],
    'params' => $params,
];
