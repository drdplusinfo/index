<?php
$documentRoot = $documentRoot ?? (PHP_SAPI !== 'cli' ? \rtrim(\dirname($_SERVER['SCRIPT_FILENAME']), '\/') : \getcwd());
$webRoot = $webRoot ?? $documentRoot . '/web/passed';
$vendorRoot = $vendorRoot ?? $documentRoot . '/vendor';

require_once $vendorRoot . '/autoload.php';

$hideHomeButton = true;

$controller = $controller ?? new \DrdPlus\RulesSkeleton\RulesController(
        $documentRoot,
        $webRoot,
        $vendorRoot
    );
$controller->setFreeAccess();
$controller->setContactsFixed();

include $vendorRoot . '/drd-plus/rules-skeleton/index.php';