<?php

namespace api\controllers;

use Yii;
use common\models\User;
use yii\rest\Controller;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use yii\filters\Cors;

/**
 * Class ApiController
 * @package api\controllers
 */
class ApiController extends Controller
{
    public $enableCsrfValidation = false;

/**
 * @OA\Info(title="Тестовое задание", version="0.1")
 *
 *  @OA\Server(
 *      url="http://test.api.inkz/api/v1/",
 *      description="API для яблок"
 * )
 *
 * @OA\Tag(
 *     name="Apples",
 *     description="Яблоки"
 * )
 *
 */


    /**
     * @return array|array[]
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $auth = $behaviors['authenticator'];
        unset($behaviors['authenticator']);
        $behaviors['corsFilter'] = [
            'class' => Cors::class,
            'cors' => [
                'Access-Control-Request-Method'    => ['OPTIONS', 'POST', 'GET'],
                'Access-Control-Allow-Credentials' => true,
                'Access-Control-Max-Age'           => 3600,
                'Access-Control-Request-Headers'   => ['*'],
                'Access-Control-Request-Origin'    => ['*'],
                'Origin'                           => ["*"],
            ],
        ];
        $behaviors['authenticator'] = $auth;
        $behaviors['authenticator']['except'] = ['options'];
        return $behaviors;
    }


    /**
     * @param \yii\base\Action $action
     * @return bool
     * @throws \yii\web\BadRequestHttpException
     */
    public function beforeAction($action)
    {
        $headers = Yii::$app->request->headers;
        if(!empty($headers['authorization'])) {
            $token = explode(' ', $headers['authorization'])[1];
            $auth = User::findIdentityByAccessToken($token);
        }
        if(empty($auth)){
            throw new AccessDeniedException('Your request was made with invalid credentials');
        }

        return parent::beforeAction($action);
    }
}
