<?php

use Illuminate\Support\Facades\File;

return [
    'support_url' => 'https://codecanyon.net/user/codenamenina',

    'server' => [
        'php' => [
            'name' => 'PHP Version >= 8.1.0',
            'version' => '>= 8.1.0',
            'check' => fn() => version_compare(PHP_VERSION, '8', '>')
        ],
        'pdo' => [
            'name' => 'PDO',
            'check' => fn() => extension_loaded('pdo_mysql')
        ],
        'mbstring' => [
            'name' => 'Mbstring extension',
            'check' => fn() => extension_loaded('mbstring')
        ],
        'fileinfo' => [
            'name' => 'Fileinfo extension',
            'check' => fn() => extension_loaded('fileinfo')
        ],
        'openssl' => [
            'name' => 'OpenSSL extension',
            'check' => fn() => extension_loaded('openssl')
        ],
        'tokenizer' => [
            'name' => 'Tokenizer extension',
            'check' => fn() => extension_loaded('tokenizer')
        ],
        'json' => [
            'name' => 'Json extension',
            'check' => fn() => extension_loaded('json')
        ],
        'curl' => [
            'name' => 'Curl extension',
            'check' => fn() => extension_loaded('curl')
        ],
        'exif' => [
            'name' => 'Exif extension',
            'check' => fn() => extension_loaded('exif')
        ],
        'mysqli_connect' => [
            'name' => 'Mysqli_Connect extension',
            'check' => fn() => function_exists('mysqli_connect')
        ],
    ],

    'folders' => [
        'storage.framework' => [
            'name' => base_path() .'storage'.DIRECTORY_SEPARATOR.'framework',
            'check' => fn() => File::chmod('../storage/framework') >= 755
        ],
        'storage.logs' => [
            'name' => base_path() .'storage'.DIRECTORY_SEPARATOR.'logs',
            'check' => fn() => File::chmod('../storage/logs') >= 755
        ],
        'storage.cache' => [
            'name' => base_path() .'bootstrap'.DIRECTORY_SEPARATOR.'cache',
            'check' => fn() => File::chmod('../bootstrap/cache') >= 755
        ],
    ],

    'database' => [
        'seeders' => true
    ],

    'commands' => [

    ],
];
