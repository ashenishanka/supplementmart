<?php

// ONE-TIME DEPLOY SCRIPT - DELETE THIS FILE IMMEDIATELY AFTER A SUCCESSFUL RUN.
// Visit: https://www.supplementmart.lk/deploy.php?key=3967f0ebd4c8582e1a87c016c2721224bfb9db03bede02fd

$secret = '3967f0ebd4c8582e1a87c016c2721224bfb9db03bede02fd';

if (($_GET['key'] ?? '') !== $secret) {
    http_response_code(404);
    exit('Not found');
}

header('Content-Type: text/plain');

$root = dirname(__DIR__);
$php  = PHP_BINARY;

function run(string $cmd): void
{
    echo "\n\$ {$cmd}\n";
    flush();

    $process = proc_open($cmd, [1 => ['pipe', 'w'], 2 => ['pipe', 'w']], $pipes, dirname(__DIR__));

    if (! is_resource($process)) {
        echo "FAILED TO START PROCESS\n";

        return;
    }

    echo stream_get_contents($pipes[1]);
    echo stream_get_contents($pipes[2]);
    fclose($pipes[1]);
    fclose($pipes[2]);

    $exitCode = proc_close($process);
    echo "[exit code: {$exitCode}]\n";
}

echo "PHP binary: {$php}\n";
echo "Project root: {$root}\n";

run("{$php} {$root}/composer.phar install --no-dev --optimize-autoloader --working-dir={$root}");
run("{$php} {$root}/artisan migrate --force");
run("{$php} {$root}/artisan config:cache");
run("{$php} {$root}/artisan route:cache");
run("{$php} {$root}/artisan view:cache");

echo "\n\n=== DONE. DELETE public/deploy.php NOW VIA FILE MANAGER. ===\n";
