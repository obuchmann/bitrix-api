<?php

return [
    /**
     * Basic Bitrix Webhook Url
     * grant all needed permissions
     */
    'webhookUrl' => env('BITRIX_WEBHOOK_URL', ''),

    /**
     * Enable Logging
     */
    'timeout' => env('BITRIX_TIMEOUT', false),

    /**
     * Ignore SSL Certificate Issues
     */
    'ignoreSsl' => env('BITRIX_IGNORE_SSL', false),

    /**
     * Log dir for dump Logs
     */
    'logDir' => env('BITRIX_LOG_DIR', storage_path('logs/bitrix')),

    /**
     * Enable Logging
     */
    'logEnabled' => env('BITRIX_LOG', false),

    /**
     * Dump Logs
     */
    'dumpLog' => env('BITRIX_DUMP_LOGS', false),
];
