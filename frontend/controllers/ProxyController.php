<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\httpclient\Client;

class ProxyController extends Controller
{

    public function actionPost()
    {
        return $this->asJson($this->send('POST'));
    }

    public function actionPut()
    {
        return $this->asJson($this->send('PUT'));
    }

    public function actionDelete()
    {
        return $this->asJson($this->send('DELETE'));
    }

    /**
     * @param string $method
     * @return string
     * @throws \Throwable
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\httpclient\Exception
     */
    protected function send(string $method): string
    {
        $request = Yii::$app->request;
        if($request->isAjax) {
            $query = $request->getQueryParams();
            $body = $request->getBodyParams();
            $user = \Yii::$app->getUser()->getIdentity();
            $client = new Client(['baseUrl' => Yii::$app->params['apiURI']]);
            $response = $client->createRequest()
                ->setUrl('api/v1/'. $query['action'])
                ->addHeaders(['Authorization' => 'Bearer '. $user->verification_token])
                ->setMethod($method)
                ->setFormat(Client::FORMAT_JSON)
                ->setData($body)
                ->send();
            return $response->getContent();
        }
        return '';
    }
}