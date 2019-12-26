<?php

namespace WJS\API\GraphQL\Schema\Types;

use GraphQL\Type\Definition\EnumType;

class EvaluationLanguageType extends EnumType
{
    const LANGUAGE_PHP = "PHP";
    const LANGUAGE_SQL = "SQL";

    public function __construct()
    {
        parent::__construct([
            'name' => "EvaluationLanguage",
            'description' => "Язык, произвольное выражение на котором сможет выполнить (вычислить) сервер.",
            'values' => [
                'PHP' => [
                    'value' => self::LANGUAGE_PHP,
                    'description' => 'PHP',
                ],
                'SQL' => [
                    'value' => self::LANGUAGE_SQL,
                    'description' => 'SQL',
                ],
            ]
        ]);
    }
}
