<?php
declare(strict_types=1);

require_once __DIR__ . '/storage.php';

const DEFAULT_USER = 'Гость';

/** Имя текущего пользователя из session (или значение по умолчанию). */
function currentUser(): string
{
    return $_SESSION['display_name'] ?? DEFAULT_USER;
}

/** Сохраняет имя в session, только если такой пользователь есть в users.json. */
function setUser(string $name): ?string
{
    $names = array_column(loadJson('users'), 'name');
    if (!in_array($name, $names, true)) {
        return 'Выбран неизвестный пользователь.';
    }
    $_SESSION['display_name'] = $name;
    return null;
}

function clearUser(): void
{
    unset($_SESSION['display_name']);
}
