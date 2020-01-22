<?php

ignore_user_abort(true);
set_time_limit(0);

$statusCode = 200;

// Emulate sending headers like a PHP framework would.
header('Connection: keep-alive', false, $statusCode);
header('Content-Type: text/event-stream; charset=UTF-8', true, $statusCode);
header('Cache-Control: no-cache', false, $statusCode);
header('X-Accel-Buffering: no', false, $statusCode); // Disables FastCGI Buffering on Nginx.
header('HTTP/1.1 200 OK', true, $statusCode);

$connectionId = uniqid('', true);

error_log(sprintf("Starting new SSE connection with ID: %s\n", $connectionId), 0);
while (true) {
    if (connection_aborted() === 1) {
        error_log(sprintf("Disconnected connection with ID: %s\n", $connectionId));

        return;
    }

    $eventString = sprintf(
        "id: %s\nevent: event-name\ndata: I am a test event sent at: %s\n\n",
        uniqid('', true),
        date(DATE_ISO8601)
    );

    echo $eventString;
    ob_flush();
    flush();

    sleep(2);
}
