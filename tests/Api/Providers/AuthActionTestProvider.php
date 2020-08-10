<?php
declare(strict_types=1);

return [
    [
        // Устаревшее API.
        1,
        'api/v0/auth',
        [
            'apiKey' => '26e19771-55c8-4581-a6cc-4acad8ff88db',
        ],
    ],
    [
        // Неверные параметры запроса.
        2,
        'api/v1/auth',
        [
            'apiKey' => '26e19771-55c8-4581-a6cc-4acad8ff88db',
        ],
    ],
    [
        // OK.
        3,
        'api/v1/auth',
        [
            'apiKey'    => '26e19771-55c8-4581-a6cc-4acad8ff88db',
            'apiSecret' => '949229ea-4823-49a2-bce3-ba774cc768fd',
        ],
    ],
    [
        // Неверный параметр apiKey.
        4,
        'api/v1/auth',
        [
            'apiKey'    => 'xxx',
            'apiSecret' => '7d1da9e9-f254-4a22-b785-0046789ff37d',
        ],
    ],
    [
        // Неверный параметр apiSecret.
        5,
        'api/v1/auth',
        [
            'apiKey'    => '26e19771-55c8-4581-a6cc-4acad8ff88db',
            'apiSecret' => 'xxx',
        ],
    ],
];
