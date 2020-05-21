<?php

namespace WJS\API\Resolvers\IBlock\Elements;

use WJS\API\Resolvers\ValueDecoder;
use WJS\API\Resolvers\ValueEncoder;

class Query
{
    /**
     * @var string[]
     */
    private static $valueKeys = [
        "~VALUE",
        "~DESCRIPTION",
        "VALUE_ENUM",
        "VALUE_SORT",
        "VALUE_XML_ID",
    ];

    /**
     * @param array $params
     * @return array
     */
    public static function decodeParams(array $params): array
    {
        $result = [];

        foreach ($params as $paramName => $paramValue) {
            if (in_array($paramName, ["page", "options"])) {
                if (isset($paramValue)) {
                    $result[$paramName] = $paramValue;
                }
            } else {
                $result[$paramName] = [];

                foreach ($paramValue as $pair) {
                    $result[$paramName][$pair["key"]] = ValueDecoder::decode($pair["value"]);
                }
            }
        }

        return $result;
    }

    /**
     * @param array $params
     * @return array
     */
    public static function encodeParams(array $params): array
    {
        $result = [];

        foreach ($params as $paramName => $paramValue) {
            if (in_array($paramName, ["page", "options"])) {
                if (isset($paramValue)) {
                    $result[$paramName] = $paramValue;
                }
            } else {
                $result[$paramName] = [];

                foreach ($paramValue as $key => $value) {
                    $result[$paramName][] = [
                        "key" => (string )$key,
                        "value" => ValueEncoder::encode($value),
                    ];
                }
            }
        }

        return $result;
    }

    /**
     * @param array $elements
     * @return array
     * @throws \JsonException
     */
    public static function encodeElements(array $elements): array
    {
        $result = [];

        foreach ($elements as $element) {
            $encodedElement = [
                "fields" => [],
                "properties" => [],
            ];

            foreach ($element as $k => $v) {
                switch ($k) {
                    case "PROPERTIES":
                        foreach ($v as $code => $property) {
                            $fields = [
                                "ID" => (int) $property["ID"],
                                "CODE" => (string) $code,
                                "PROPERTY_TYPE" => (string) $property["PROPERTY_TYPE"],
                                "USER_TYPE" => $property["USER_TYPE"] ?: null,
                                "MULTIPLE" => $property["MULTIPLE"],
                            ];

                            foreach (static::$valueKeys as $k) {
                                if ($property[$k] && ($property["MULTIPLE"] !== "Y")) {
                                    $value = [$property[$k]];
                                } else {
                                    $value = $property[$k];
                                }

                                $fields[str_replace("~", "", $k)] = array_map(function ($v) use ($property, $k) {
                                    if ($k === "~VALUE") {
                                        return ValueEncoder::encode($v);
                                    } else {
                                        return (string) $v;
                                    }
                                }, $value);
                            }

                            $encodedElement["properties"][] = $fields;
                        }
                        break;
                    default:
                        $encodedElement["fields"][] = [
                            "CODE" => (string) $k,
                            "VALUE" => ValueEncoder::encode($v),
                        ];
                        break;
                }
            }

            $result[] = $encodedElement;
        }

        return $result;
    }

    /**
     * @param array $elements
     * @return array
     * @throws \JsonException
     */
    public static function decodeElements(array $elements): array
    {
        $result = [];
        foreach ($elements as $element) {
            $decodedElement = [];

            foreach ($element as $key => $value) {
                switch ($key) {
                    case "fields":
                        foreach ($value as $field) {
                            $decodedElement[$field["CODE"]] = ValueDecoder::decode($field["VALUE"]);
                        }
                        break;
                    case "properties":
                        $decodedElement["PROPERTIES"] = [];
                        $decodedElement["PROP"] = [];
                        $decodedElement["PROP_DESC"] = [];

                        foreach ($value as $property) {
                            $property["VALUE"] = array_map(function ($value) use ($property) {
                                return ValueDecoder::decode($value);
                            }, $property["VALUE"]);

                            if ($property["MULTIPLE"] !== "Y") {
                                $property["VALUE"] = first_of($property["VALUE"]);
                                $property["DESCRIPTION"] = first_of($property["DESCRIPTION"]);
                            }

                            $decodedElement["PROPERTIES"][$property["CODE"]] = $property;

                            $decodedElement["PROP"][$property["CODE"]] = $property["VALUE"];

                            if ($property["WITH_DESCRIPTION"] === "Y") {
                                $decodedElement["PROP_DESC"][$property["CODE"]] = $property["DESCRIPTION"];
                            }

                            if ($property["PROPERTY_TYPE"] === "L") {
                                $decodedElement["PROP_ENUM"][$property["CODE"]] = $property["VALUE_ENUM"];
                                $decodedElement["PROP_GUID"][$property["CODE"]] = $property["VALUE_XML_ID"];
                                $decodedElement["PROP_SORT"][$property["CODE"]] = $property["VALUE_SORT"];
                            }
                        }
                        break;
                }
            }

            $result[] = $decodedElement;
        }

        return $result;
    }

    /**
     * @param array $params
     * @return array
     * @throws \Exception
     */
    public static function getList(array $params): array
    {
        $args = static::decodeParams($params);

        $elements = \Machaon\Std\IBlock\Query::getElements($args);

        return self::encodeElements($elements);
    }
}
