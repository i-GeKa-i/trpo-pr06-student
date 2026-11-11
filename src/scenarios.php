<?php
declare(strict_types=1);

require_once __DIR__ . '/session.php';

/**
 * Выполняет сценарий из session_scenarios.json над session и
 * возвращает фактическое состояние: guest_or_default | default | stored.
 */
function runScenario(array $s): string
{
    switch ($s['scenario']) {
        case 'set_name':
            $_SESSION['display_name'] = (string) ($s['value'] ?? '');
            break;
        case 'clear':
        case 'new_session':
            clearUser();
            break;
    }
    return actualState($s);
}

/** Сопоставляет текущее состояние session с терминами из поля expected. */
function actualState(array $s): string
{
    $name = currentUser();
    return match ($s['scenario']) {
        'set_name' => $name === ($s['value'] ?? null) ? 'stored' : 'not_stored',
        'clear' => $name === DEFAULT_USER ? 'default' : 'not_cleared',
        default => $name === DEFAULT_USER ? 'guest_or_default' : 'has_name',
    };
}
