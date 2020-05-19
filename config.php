<?php

return [
    "wjs" => [
        "api" => [
            "event_monitor" => [
                "cookie_name" => "WJS_API_EVENT_MONITOR",
            ],
            "graphql" => [
                "endpoint" => "/bitrix/tools/wjs_api_graphql.php",
                "authorization_header" => "X-Authorization",
            ],
        ],
    ],
];
