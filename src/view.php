<?php
declare(strict_types=1);

/** Подключает шаблон из templates/, передавая ему только готовые данные. */
function render(string $template, array $data = []): void
{
    extract($data, EXTR_SKIP);
    require __DIR__ . "/../templates/$template.php";
}

/** Экранирование для вывода в HTML. */
function e(mixed $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}
