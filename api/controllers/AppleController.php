<?php
namespace api\controllers;

use Yii;
use application\services\AppleService;

class AppleController extends ApiController
{
    protected AppleService $appleService;
    protected array $body;

    public function __construct($id, $module, AppleService $appleService, $config = [])
    {
        $this->appleService = $appleService;
        $this->body = Yii::$app->request->getBodyParams();
        parent::__construct($id, $module, $config);
    }

    /**
     * @OA\Post(
     *     path="/delete",
     *     tags={"Apple"}
     * )
     */
    public function actionCreate()
    {
        return $this->asJson($this->appleService->create());
    }


    /**
     * @OA\Post(
     *     path="/fall",
     *     tags={"Apple"}
     * )
     */
    public function actionFall()
    {
        return $this->asJson($this->appleService->fallToGround($this->body));
    }


    /**
     * @OA\Post(
     *     path="/eat",
     *     tags={"Apple"},
     *     @OA\Parameter(
     *         description="toCity",
     *         name="toCity",
     *         in="formData",
     *         required=true,
     *         type="integer"
     *     ),
     *     @OA\Parameter(
     *         description="когда доставка, чтобы узнать точную доставку",
     *         name="address",
     *         in="formData",
     *         required=false,
     *         type="string"
     *     ),
     *     @OA\Parameter(
     *         description="productIds, передаем productIds[product_id] = ",
     *         name="productIds[]",
     *         in="formData",
     *         items="integer",
     *         collectionFormat="multi",
     *         type="array",
     *         required=true
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success response",
     *     )
     * )
     */
    public function actionEat()
    {
        return $this->asJson($this->appleService->eat($this->body));
    }

    /**
     * @return \yii\web\Response
     */
    public function actionDelete()
    {
        return $this->asJson($this->appleService->delete($this->body));
    }
}
