<?php

return array(
    'language'   => 'ru',
    'basePath'   => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name'       => '',

    'preload'    => array('log'),

    'import'     => array_merge(array(
            'application.components.*', 'application.components.zii.*',
            'application.components.formElements.*', 'application.libs.tools.*',
            'ext.yiiext.filters.setReturnUrl.ESetReturnUrlFilter',
            'application.modules.srbac.controllers.SBaseController',
        )),

    'components' => array(
        'session'      => array(
            'autoStart'=> true
        ),
        'user'         => array(
            'allowAutoLogin' => true,
            'class'          => 'WebUser'
        ),
        'image'        => array(
            'class'  => 'application.extensions.image.CImageComponent',
            'driver' => 'GD'
        ),
        'dater'        => array(
            'class' => 'application.components.DaterComponent'
        ),
        'text'         => array(
            'class' => 'application.components.TextComponent'
        ),
        'urlManager'   => array(
            'urlFormat'      => 'path',
            'showScriptName' => false,
            'rules'          => array(
                ''                => "mark/index/view/site",
                '<view>'          => 'mark/index',
                '<folder>/<view>' => 'mark/index',
            ),
        ),

        'errorHandler' => array(
            'errorAction' => 'mark/error',
        ),

//        'authManager' => array(
//            'class'           => 'CDbAuthManager',
//			'connectionID'    => 'db',
//            'itemTable'       => 'AuthItem',
//            'assignmentTable' => 'AuthAssignment',
//            'itemChildTable'  => 'AuthItemChild',
//			'defaultRoles'    => array('guest')
//        ),
//
//        'log'=>array(
//                'class'=>'CLogRouter',
//                'routes'=>array(
//                    array(
//                      db  'class'        => 'DbLogRoute',
//                        'levels'       => 'error, warning, info',
//                        'connectionID' => 'db',
//                        'logTableName' => 'log',
//                        'enabled'      => true
//                    )
//                ),
//        ),

        'preload'      => array('log'),

//        'log'=>array(
//            'class'=>'CLogRouter',
//            'routes'=>array(
//                array(
//                    'class'=>'CWebLogRoute',
//                    'levels'=>'profile',
//                    'enabled'=>true,
//                ),
//            ),
//        ),
    ),

    'params'     => array(
        'adminEmail'=> 'artem-moscow@yandex.ru.com',
    ),

    'language'   => 'ru',
);

