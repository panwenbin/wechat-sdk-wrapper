<?php
/**
 * @author Pan Wenbin <panwenbin@gmail.com>
 */

$logFile = $conf['logFile'] ?? 'log.txt';
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $log = '[' . date('Y-m-d H:i:s') . ']' . " Received GET: \r\n";
    $log .= print_r($_GET, true);
    $log .= "\r\n";
    file_put_contents($logFile, $log, FILE_APPEND);
} elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $log = '[' . date('Y-m-d H:i:s') . ']' . " Received POST: \r\n";
    $log .= file_get_contents('php://input');
    $log .= "\r\n";
    file_put_contents($logFile, $log, FILE_APPEND);
}