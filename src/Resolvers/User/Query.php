<?php

namespace WJS\API\Resolvers\User;

class Query
{
    /**
     * @param string $by
     * @param string $order
     * @param array $filter
     * @return array
     */
    public static function get($by = "ID", $order = "ASC", array $filter = []): array
    {
        $result = [];

        $query = \CUser::GetList(
            $by,
            $order,
            $filter
        );

        while ($user = $query->GetNext()) {
            $result[] = $user;
        }

        return $result;
    }
}
