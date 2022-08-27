<?php
namespace application\domain\repositories;

use application\core\interfaces\EntityInterface;
use application\domain\Apple;
use application\core\interfaces\RepositoryInterface;
use application\core\adapters\Repository;

/**
 * Class AppleRepository
 * @package application\domain\repositories
 */
final class AppleRepository extends Repository implements RepositoryInterface
{
    protected $table = 'apple';
    private static $entities = [];

    /**
     * @param EntityInterface $apple
     * @return $this
     */
    public function add(EntityInterface $apple): self
    {
        $id = $apple->getId();
        self::$entities[$id] = $apple;
        return $this;
    }

    /**
     * @param string $id
     * @return EntityInterface
     * @throws \yii\db\Exception
     */
    public function get(string $id): EntityInterface
    {
        if (!isset(self::$entities[$id])) {
            self::$entities[$id] = $this->getEntity($id, Apple::class);
        }

        return self::$entities[$id];
    }

    /**
     * @throws \yii\db\Exception
     */
    public function save(): void
    {
        foreach(self::$entities as $id => $apple) {
            $this->saveEntity('apple', $this->extractRootData($apple));
        }
    }

    /**
     *
     */
    public function clear(): void
    {
        foreach(self::$entities as $id => $apple) {
            unset($apple);
        }
        self::$entities = [];
    }

    /**
     * @param string|null $where
     * @return array
     * @throws \ReflectionException
     * @throws \yii\db\Exception
     */
    public function getIds(?string $where = null): array
    {
        $where = $where ?? "WHERE `status` = ". Apple::STATUS_FALL;
        return $this->getColumn('id', $where);
    }

    /**
     * @param EntityInterface $apple
     * @return array
     */
    private function extractRootData(EntityInterface $apple): array
    {   
        return [
            'id'    => $apple->getId(),
            'color' => $apple->getColor(),
            'appearance_date' => $apple->getAppearanceDate(),
            'fall_date' => $apple->getFallDate(),
            'size' => $apple->getSize(),
            'status' => $apple->getStatus(),
        ];
    } 
}
