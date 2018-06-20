<?php

namespace app\modules\surver\components;

use Yii;

/**
 * Class Model
 * @package app\modules\surver\components
 */
class Model extends \yii\base\Model
{
    /**
     * @param $models
     * @param $deleteIds
     * @param $data
     * @return bool
     */
    public static function multiLoad(&$models, &$deleteIds, $data)
    {
        $first = reset($models);
        if ($first === false) {
            return false;
        }

        $success = false;
        $loadModels = [];
        foreach ($data as $i => $one) {
            if (!isset($one['id']) || $one['id'] === '') {
                /**  создаем новую модель */
                $class = get_class($first);
                $model = new $class;
                $model->load($one, '');
                $loadModels[$i] = $model;
                $success = true;
            } else {
                /**  загружаем существующую */
                $key = array_search($one['id'], array_combine(array_keys($models), array_column($models, 'id')));
                $model = $models[$key];
                $model->load($one, '');
                $loadModels[$i] = $model;
                unset($models[$key]);
                $success = true;


            }
        }
        /** Если массив моделей не пуст,помечаем эти модели как удаленные */
        if (!empty($models)) {
            foreach ($models as $i => $model) {
                $deleteIds[] = $model->id;
            }

        }
        $models = $loadModels;


        return $success;
    }


}
