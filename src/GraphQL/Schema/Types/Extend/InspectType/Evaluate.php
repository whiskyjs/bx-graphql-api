<?php

namespace WJS\API\GraphQL\Schema\Types\Extend\InspectType;

use GraphQL\Type\Definition\Type as GenericType;

use Machaon\Std\Base\Singleton;

use WJS\API\Contracts\GraphQL\Field;
use WJS\API\GraphQL\Schema\Type;
use WJS\API\GraphQL\Schema\Types\InspectType;
use WJS\API\GraphQL\Schema\Types\EvaluationLanguageType;
use WJS\API\GraphQL\Schema\Types\EvaluationResultType;
use WJS\API\Helpers\PHP\Evaluator as EvaluatorPHP;

/**
 * @package WJS\API\GraphQL\Schema\Types\Extend\InspectType
 */
class Evaluate extends Singleton implements Field
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
        return "evaluate";
    }

    /**
     * @inheritDoc
     */
    public function getType(): GenericType
    {
        return Type::getInstance(EvaluationResultType::class);
    }

    /**
     * @inheritDoc
     */
    public function getArgs(): array
    {
        /** @noinspection PhpParamsInspection */
        return [
            "language" => Type::nonNull(Type::getInstance(EvaluationLanguageType::class)),
            "source" => Type::nonNull(Type::string()),
        ];
    }

    /**
     * @param array $data
     * @param array $args
     * @param array|null $context
     * @return array
     */
    public function resolve(array $data, array $args = [], ?array $context = null): array
    {
        $result = EvaluatorPHP::evaluate($args["source"]);

        return [
            "output" => $result->getOutput(),
            "result" => $result->getResult(),
        ];
    }
}
