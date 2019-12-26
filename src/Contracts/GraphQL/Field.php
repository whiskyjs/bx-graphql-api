<?php

namespace WJS\API\Contracts\GraphQL;

use GraphQL\Type\Definition\Type as GenericType;

interface Field
{
    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @return GenericType
     */
    public function getType(): GenericType;

    /**
     * @return string
     */
    public function getParentClass(): string;

    /**
     * @return array
     */
    public function getArgs(): array;

    /**
     * @param array $data
     * @param array $args
     * @param array|null $context
     * @return mixed
     */
    public function resolve(array $data, array $args = [], ?array $context = null);
}
