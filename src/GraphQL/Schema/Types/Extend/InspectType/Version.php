<?php

namespace WJS\API\GraphQL\Schema\Types\Extend\InspectType;

use GraphQL\Type\Definition\Type as GenericType;

use Machaon\Std\Base\Singleton;

use WJS\API\Contracts\GraphQL\Field;
use WJS\API\GraphQL\Schema\Type;
use WJS\API\GraphQL\Schema\Types\InspectType;
use WJS\API\MetaInfo;

class Version extends Singleton implements Field
{
    /**
     * @inheritDoc
     */
    public function getParentClass(): string
    {
        return InspectType::class;
    }

    /**
     * @inheritDoc
     */
    public function getName(): string
    {
        return "version";
    }

    /**
     * @inheritDoc
     */
    public function getType(): GenericType
    {
        return Type::string();
    }

    /**
     * @inheritDoc
     */
    public function getArgs(): array
    {
        return [];
    }

    /**
     * @param array $data
     * @param array $args
     * @param array|null $context
     * @return string
     */
    public function resolve(array $data, array $args = [], ?array $context = null): string
    {
        $metaInfo = MetaInfo::getInstance();

        return sprintf(
            "%s %s (%s)",
            $metaInfo->getModuleName(),
            $metaInfo->getModuleVersion(),
            $metaInfo->getModuleDate()
        );
    }
}
