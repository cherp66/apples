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
     *     path="/create",
     *     tags={"Apples"},
     *     summary="api\controllers\AppleController",
     *     operationId="apples-create",
     *     description="Сгенерирует случайное от 2 до 5 количество яблок",
     *     @OA\Response(
     *         response="200",
     *         description="Вернет массив созданных объектов яблок",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 type="object",
     *                 @OA\Property( property="success", type="boolean"),
     *                 @OA\Property(
     *                     property="data",
     *                     type="array",
     *                     @OA\Items(
     *                         type="object",
     *                         @OA\Property(
     *                             property="id",
     *                             type="string",
     *                             example="621b0071-28de-40e8-930e-25308e345a05"
     *                         ),
     *                         @OA\Property(
     *                             property="color",
     *                             type="string",
     *                             example="red"
     *                          ),
     *                          @OA\Property(
     *                             property="size",
     *                             type="int",
     *                             example="100"
     *                         ),
     *                          @OA\Property(
     *                             property="status",
     *                             type="string",
     *                             example="1"
     *                         ),
     *                     )
     *                 ),
     *             ),
     *         ),
     *     ),
     *   @OA\Response(response="401", description="Не авторизован"),
     * )
     */
    public function actionCreate()
    {
        return $this->asJson($this->appleService->create());
    }

    /**
     * @OA\Put(
     *     path="/fall",
     *     tags={"Apples"},
     *     summary="api\controllers\AppleController",
     *     operationId="apples-fall",
     *     description="Изменит статус объекта на `на земле`",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 type="object",
     *                 @OA\Property(
     *                     property="id",
     *                     type="string",
     *                     example="621b0071-28de-40e8-930e-25308e345a05"
     *                 ),
     *             ),
     *         ),
     *     ),
     *    @OA\Response(
     *         response="200",
     *         description="Вернет объект упавшего яблока",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 type="object",
     *                 @OA\Property( property="success", type="boolean"),
     *                 @OA\Property(
     *                     property="data",
     *                     type="object",
     *                      @OA\Property(
     *                         property="id",
     *                         type="string",
     *                         example="621b0071-28de-40e8-930e-25308e345a05"
     *                     ),
     *                     @OA\Property(
     *                         property="color",
     *                         type="string",
     *                         example="green"
     *                     ),
     *                     @OA\Property(
     *                         property="size",
     *                         type="int",
     *                         example="100"
     *                     ),
     *                     @OA\Property(
     *                         property="status",
     *                         type="string",
     *                         example="2"
     *                     ),
     *                 ),
     *             ),
     *         ),
     *     ),
     *     @OA\Response(response="401", description="Не авторизован"),
     * )
     */
    public function actionFall()
    {
        return $this->asJson($this->appleService->fallToGround($this->body));
    }

    /**
     * @OA\Put(
     *     path="/eat",
     *     tags={"Apples"},
     *     summary="api\controllers\AppleController",
     *     operationId="apples-eat",
     *     description="Уменьшит размер яблока на выбранную величину процентов",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 type="object",
     *                 @OA\Property(
     *                     property="id",
     *                     type="string",
     *                     example="621b0071-28de-40e8-930e-25308e345a05"
     *                 ),
     *                 @OA\Property(
     *                     property="percent",
     *                     type="int",
     *                     example="10"
     *                 ),
     *             ),
     *         ),
     *     ),
     *    @OA\Response(
     *         response="200",
     *         description="Вернет объект откушенного яблока",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 type="object",
     *                 @OA\Property( property="success", type="boolean"),
     *                 @OA\Property(
     *                     property="data",
     *                     type="object",
     *                      @OA\Property(
     *                         property="id",
     *                         type="string",
     *                         example="621b0071-28de-40e8-930e-25308e345a05"
     *                     ),
     *                     @OA\Property(
     *                         property="color",
     *                         type="string",
     *                         example="green"
     *                     ),
     *                     @OA\Property(
     *                         property="size",
     *                         type="int",
     *                         example="90"
     *                     ),
     *                     @OA\Property(
     *                         property="status",
     *                         type="string",
     *                         example="2"
     *                     ),
     *                 ),
     *             ),
     *         ),
     *     ),
     *     @OA\Response(response="401", description="Не авторизован"),
     * )
     */
    public function actionEat()
    {
        return $this->asJson($this->appleService->eat($this->body));
    }
    /**
     * @OA\Delete(
     *     path="/delete",
     *     tags={"Apples"},
     *     summary="api\controllers\AppleController",
     *     operationId="apples-delete",
     *     description="Изменит статус объекта на 'удален'",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 type="object",
     *                 @OA\Property(
     *                     property="id",
     *                     type="string",
     *                     example="621b0071-28de-40e8-930e-25308e345a05"
     *                 ),
     *             ),
     *         ),
     *     ),
     *    @OA\Response(
     *         response="200",
     *         description="Вернет объект удаленного яблока",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 type="object",
     *                 @OA\Property( property="success", type="boolean"),
     *                 @OA\Property(
     *                     property="data",
     *                     type="object",
     *                      @OA\Property(
     *                         property="id",
     *                         type="string",
     *                         example="621b0071-28de-40e8-930e-25308e345a05"
     *                     ),
     *                     @OA\Property(
     *                         property="color",
     *                         type="string",
     *                         example="green"
     *                     ),
     *                     @OA\Property(
     *                         property="size",
     *                         type="int",
     *                         example="50"
     *                     ),
     *                     @OA\Property(
     *                         property="status",
     *                         type="string",
     *                         example="4"
     *                     ),
     *                 ),
     *             ),
     *         ),
     *     ),
     *     @OA\Response(response="401", description="Не авторизован"),
     * )
     */
    public function actionDelete()
    {
        return $this->asJson($this->appleService->delete($this->body));
    }
}

