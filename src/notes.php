<?php
declare(strict_types=1);

require_once __DIR__ . '/storage.php';

function loadNotes(): array
{
    return loadJson('notes');
}
