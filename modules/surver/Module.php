<?php

namespace app\modules\surver;

/**
 * surver module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'app\modules\surver\controllers';

    /**  Ссылка экшен для просмотра юзера */
    public $userView;

    /** Класс виджета для текстого редактора */
    public $wysiwyg;

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
}
