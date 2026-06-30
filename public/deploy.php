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

$candidates = [
    '/opt/alt/php83/usr/bin/php',
    '/opt/cpanel/ea-php83/root/usr/bin/php',
    '/usr/local/bin/ea-php83',
    '/usr/bin/php83',
    '/usr/local/bin/php83',
    '/opt/alt/php82/usr/bin/php',
    '/usr/bin/php',
];

$php = null;
foreach ($candidates as $candidate) {
    if (is_executable($candidate)) {
        $php = $candidate;
        break;
    }
}

if ($php === null) {
    echo "No working CLI PHP binary found among candidates:\n";
    foreach ($candidates as $candidate) {
        echo " - {$candidate} (exists: " . (file_exists($candidate) ? 'yes' : 'no') . ", executable: " . (is_executable($candidate) ? 'yes' : 'no') . ")\n";
    }
    exit;
}

function run(string $cmd): void
{
    echo "\n\$ {$cmd}\n";
    flush();

    $env = [
        'HOME' => '/home/sumithssign',
        'COMPOSER_HOME' => '/home/sumithssign/.composer',
        'PATH' => getenv('PATH') ?: '/usr/local/bin:/usr/bin:/bin',
    ];

    $process = proc_open($cmd, [1 => ['pipe', 'w'], 2 => ['pipe', 'w']], $pipes, dirname(__DIR__), $env);

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

run("{$php} {$root}/artisan db:seed --force");

echo "\n\n=== DONE. DELETE public/deploy.php NOW VIA FILE MANAGER. ===\n";
