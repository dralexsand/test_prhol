<?php

namespace frontend\controllers;

use frontend\models\Apples;
use frontend\models\Profiles;
use Yii;
use yii\web\Controller;


class AjaxController extends Controller
{

    public function beforeAction($action)
    {
        if ($action->id = 'request') {
            $this->enableCsrfValidation = false;
        }
        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        return '';
    }

    public function actionRequest()
    {
        $result = '';

        if (Yii::$app->request->isAjax) {
            $post = Yii::$app->request->post()['param'];

            $action = $post['action'];

            switch ($action) {
                case 'save_harvest':
                    $result = $this->saveSnapshot($post);
                    break;
            }
        }

        echo $result;
    }

    public function saveSnapshot($data)
    {
        $time_now = time();
        Yii::$app->db->createCommand()->insert('snapshots', [
            'generation_id' => $data['generation_id'],
            'data' => $data['data'],
            'created_at' => $time_now,
            'updated_at' => $time_now,
        ])->execute();
        return 'Successful';
    }

}

?>