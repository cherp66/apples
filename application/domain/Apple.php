<?php

namespace application\domain;

use application\core\interfaces\EntityInterface;
use application\domain\settings\AppleInterface;

final class Apple implements \JsonSerializable, EntityInterface, AppleInterface
{
    private string $id;
    private string $color;
    private int $appearanceDate;
    private ?int $fallDate = null;
    private int $size = 100;
    private int $status = self::STATUS_IN_TREE;

    private function __construct(){}

    /**
     * @param \StdClass $data
     */
    private function create(\StdClass $data): void
    {
        $this->id             = $data->id;
        $this->color          = $data->color;
        $this->appearanceDate = $data->appearanceDate;
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        return [
            'id'    => $this->getId(),
            'color' => $this->getColor(),
            'size' => $this->getSize(),
            'status' => $this->getStatus()
        ];
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getColor(): string
    {
        return $this->color;
    }

    /**
     * @return int
     */
    public function getAppearanceDate() : int
    {
        return $this->appearanceDate;
    }

    /**
     * @return int|null
     */
    public function getFallDate() : ?int
    {
        return $this->fallDate;
    }

    /**
     * @return int
     */
    public function getSize(): int
    {
        return $this->size;
    }

    /**
     * @return int
     */
    public function getStatus() : int
    {
        return $this->status;
    }

    /**
     * @param int $percent
     */
    public function changeSize(int $percent) : void
    {
        if($percent > 100 || $percent < 0) {
            throw new \DomainException('Invalid percent');
        }

        $status = $this->checkStatus();
        if(self::STATUS_IN_TREE === $status) {
            throw new \DomainException('Сan\'t eat');
        }

        if($this->status === self::STATUS_FALL) {
            $this->size = $this->size - $percent;
        }

        if($this->size <= 0) {
            $this->size = 0;
            $this->status = self::STATUS_DELETE;
        }
    }

    /**
     * @param int $status
     */
    public function changeStatus(int $status) : void
    {
        switch(true) {
            case !in_array($status, self::STATUSES) :
                throw new \DomainException('Invalid status');
            case self::STATUS_FALL === $status && self::STATUS_IN_TREE === $this->status:
                $this->status = self::STATUS_FALL;
                if(is_null($this->fallDate)) {
                    $this->fallDate = time();
                }
                break;
            case self::STATUS_DELETE === $status :
                $this->status = self::STATUS_DELETE;
                break;
        }
    }

    /**
     * @return int
     */
    public function checkStatus() : int
    {
        if(self::STATUS_FALL === $this->status && $this->fallDate < time() - self::ROTTEN_TIME * 60){
            $this->status = self::STATUS_ROTTEN;
        }
        return $this->status;
    }
}