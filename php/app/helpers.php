<?php
/**
 * User: nano
 * Datetime: 2021/9/25 5:29 下午
 */

/**
 * @param int $code
 * @param string $message
 * @param array $data
 * @return array
 */
function returnJson(int $code = 0, string $message = 'success', array $data = []): array
{
    return [
        'code' => $code,
        'message' => $message,
        'data' => (object)$data
    ];
}