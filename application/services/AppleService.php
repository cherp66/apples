<?php
namespace application\services;

use application\domain\Apple;
use application\domain\builders\AppleBuilder;
use application\domain\repositories\AppleRepository;
use SplObjectStorage;

/**
 * Class AppleService
 * @package application\services
 */
class AppleService
{
    protected AppleRepository $repository;

    public function __construct()
    {
        $this->repository = new AppleRepository();
    }

    /**
     * @return array
     * @throws \yii\db\Exception
     */
    public function create() : array
    {
        $storage = new SplObjectStorage();

        $cnt = rand(2, 5);
        while($cnt--){
            $apple = (new AppleBuilder())->build();
            $storage->attach($apple);
            $this->repository->add($apple);
        }
        $this->repository->save();
        return $this->success($storage);
    }

    /**
     * @param array $body
     * @return array
     * @throws \yii\db\Exception
     */
    public function fallToGround(array $body) : array
    {
        $apple = $this->repository->get($body['id']);
        $apple->changeStatus(Apple::STATUS_FALL);
        $this->repository->save();
        return $this->success($apple);
    }

    /**
     * @param array $body
     * @return array
     * @throws \yii\db\Exception
     */
    public function eat(array $body): array
    {
        $apple = $this->repository->get($body['id']);
        $apple->changeSize($body['percent']);
        $this->repository->save();
        return $this->success($apple);
    }

    /**
     * @param array $body
     * @return array
     * @throws \yii\db\Exception
     */
    public function delete(array $body): array
    {
        $apple = $this->repository->get($body['id']);
        $apple->changeStatus(Apple::STATUS_DELETE);
        $this->repository->save();
        return $this->success($apple);
    }

    /**
     * @throws \ReflectionException
     * @throws \yii\db\Exception
     */
    public function decay(): void
    {
        $ids = $this->repository->getIds();
        foreach($ids as $id) {
            $apple = $this->repository->get($id);
            if(Apple::STATUS_ROTTEN === $apple->checkStatus()) {
                $this->repository->save();
            }
            $this->repository->clear();
        }
    }

    /**
     * @param array $data
     * @return array
     */
    protected function success(object $data) : array
    {
        return ['status' => 'success', 'data' => $data];
    }
}