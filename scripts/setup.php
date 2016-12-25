<?php
/**
 * Set up a new site
 */
require_once __DIR__.'/../vendor/autoload.php';

/**
 * Drop schema and create
 */
if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
    exec('"vendor/bin/doctrine.bat" orm:schema-tool:drop --force');
    exec('"vendor/bin/doctrine.bat" orm:schema-tool:create');
} else {
    exec('vendor/bin/doctrine orm:schema-tool:drop --force');
    exec('vendor/bin/doctrine orm:schema-tool:create');
}

//LosBootstrap::database();
