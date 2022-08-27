<?php

namespace application\core\interfaces;


interface RepositoryInterface
{
    public function get(string $id): EntityInterface;
    public function add(EntityInterface $aggregate): self;
    public function save(): void;
    public function clear(): void;
}