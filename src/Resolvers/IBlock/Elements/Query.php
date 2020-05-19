<?php

namespace WJS\API\Resolvers\IBlock\Elements;

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
                    $result[$paramName][$pair["key"]] = $pair["value"];
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
                        "value" => (string) $value,
                    ];
                }
            }
        }

        return $result;
    }

    /**
     * @param mixed $value
     * @param array $property
     * @return string/null
     * @throws \JsonException
     */
    public static function encodePropertyValue($value, array $property): ?string
    {
        return to_json($value);
    }

    /**
     * @param $value
     * @param array $property
     * @return mixed
     * @throws \JsonException
     */
    public static function decodePropertyValue($value, array $property)
    {
        return from_json($value);
    }

    /**
     * @param string $code
     * @param mixed $value
     * @return string/null
     * @throws \JsonException
     */
    public static function encodeFieldValue(string $code, $value): ?string
    {
        return to_json($value);
    }

    /**
     * @param string $code
     * @param string $value
     * @return mixed
     * @throws \JsonException
     */
    public static function decodeFieldValue(string $code, string $value)
    {
        return from_json($value);
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
                                        return static::encodePropertyValue($v, $property);
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
                            "VALUE" => static::encodeFieldValue($k, $v),
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
                            $decodedElement[$field["CODE"]] = static::decodeFieldValue(
                                $field["CODE"],
                                $field["VALUE"]
                            );
                        }
                        break;
                    case "properties":
                        $decodedElement["PROPERTIES"] = [];
                        $decodedElement["PROP"] = [];
                        $decodedElement["PROP_DESC"] = [];

                        foreach ($value as $property) {
                            $property["VALUE"] = array_map(function ($value) use ($property) {
                                return static::decodePropertyValue($value, $property);
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
