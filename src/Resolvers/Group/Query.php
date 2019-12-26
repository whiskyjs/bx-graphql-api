<?php

namespace WJS\API\Resolvers\Group;

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

        $query = \CGroup::GetList(
            $by,
            $order,
            $filter
        );

        while ($group = $query->GetNext()) {
            $result[] = $group;
        }

        return $result;
    }

    /**
     * @param string $userId
     * @return array
     */
    public static function getUserGroupIds(string $userId): array
    {
        return \CUser::GetUserGroup($userId);
    }
}
