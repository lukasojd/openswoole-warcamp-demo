<?php

declare(strict_types=1);

use App\Kernel;
use OpenSwoole\Server;
use Swoole\Constant;

$_SERVER['APP_RUNTIME_OPTIONS'] = [
    'host' => '0.0.0.0',
    'port' => 80,
    'mode' => Server::POOL_MODE,
    'sock_type' => SWOOLE_SOCK_TCP,
    'env' => 'prod',
    'debug' => false,
    'settings' => [
        Constant::OPTION_LOG_LEVEL => SWOOLE_LOG_ERROR,
        Constant::OPTION_WORKER_NUM => getenv('SWOOLE_WORKER_NUM'),
        Constant::OPTION_LOG_FILE => '/dev/null',
        Constant::OPTION_REACTOR_NUM => getenv('SWOOLE_REACTOR_NUM'),
        Constant::OPTION_DISPATCH_MODE => 3,
        Constant::OPTION_ENABLE_STATIC_HANDLER => false,
        Constant::OPTION_PACKAGE_MAX_LENGTH => 10 * 1024 * 1024,
        Constant::OPTION_MAX_REQUEST => getenv('SWOOLE_MAX_REQUEST'),
        Constant::OPTION_MAX_REQUEST_GRACE => getenv('MAX_REQUEST_GRACE'),
        Constant::OPTION_HTTP_PARSE_COOKIE => false,
        Constant::OPTION_HTTP_COMPRESSION => true,
        Constant::OPTION_HTTP_COMPRESSION_LEVEL => 9,
    ],
];

require_once dirname(__DIR__) . '/vendor/autoload_runtime.php';
return static fn (array $context): Kernel => new Kernel($context['APP_ENV'], (bool) $context['APP_DEBUG']);
