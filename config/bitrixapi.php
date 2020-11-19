<?php

return [
    'webhookUrl' => env('BITRIX_WEBHOOK_URL'),
    'ignoreSsl' => env('BITRIX_IGNORE_SSL', false),
    'logDir' => env('BITRIX_LOG_DIR', storage_path('logs/bitrix')),
    'logEnabled' => env('BITRIX_LOG', false),
    'dumpLog' => env('BITRIX_DUMP_LOGS', false),
];
