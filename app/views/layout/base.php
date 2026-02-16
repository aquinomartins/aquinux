<?php

declare(strict_types=1);

require __DIR__ . '/header.php';
require __DIR__ . '/navbar.php';

if (isset($contentView) && is_file($contentView)) {
    require $contentView;
} elseif (isset($content)) {
    echo $content;
}

require __DIR__ . '/footer.php';
