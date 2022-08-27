<?php
namespace application\domain\builders;

use application\core\interfaces\BuilderInterface;
use application\domain\Apple;
use application\core\Hydrator;
use application\domain\settings\AppleInterface;
use Ramsey\Uuid\Uuid;

final class AppleBuilder implements BuilderInterface, AppleInterface
{
    public function build()
    {
        $apple = new \StdClass;
        $apple->id = (string)Uuid::uuid4();
        $apple->color = $this->createColor();
        $apple->appearanceDate = time();
        return Hydrator::instance(Apple::class, $apple);
    }

    private function createColor()
    {
        return self::COLORS[array_rand(self::COLORS)];
    }
}