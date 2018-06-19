<?php

namespace app\modules\user\controllers;

use Yii;
use app\modules\user\models\UserVisitLog;
use app\modules\user\models\search\UserVisitLogSearch;
use app\modules\user\components\AdminDefaultController;

/**
 * UserVisitLogController implements the CRUD actions for UserVisitLog model.
 */
class UserVisitLogController extends AdminDefaultController
{
    /**
     * @var UserVisitLog
     */
    public $modelClass = 'app\modules\user\models\UserVisitLog';

    /**
     * @var UserVisitLogSearch
     */
    public $modelSearchClass = 'app\modules\user\models\search\UserVisitLogSearch';

    public $enableOnlyActions = ['index', 'view', 'grid-page-size'];
}
