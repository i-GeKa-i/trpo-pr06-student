<?php
declare(strict_types=1);

// Единая точка входа: все переходы идут через index.php?page=<имя>.
require __DIR__ . '/../src/view.php';
require __DIR__ . '/../src/notes.php';

$userName = 'Гость';
$flash = [];
$page = $_GET['page'] ?? 'notes';

try {
    if ($page === 'notes') {
        $title = 'Заметки';
        $content = capture('notes', ['notes' => loadNotes()]);
    } else {
        http_response_code(404);
        $title = 'Страница не найдена';
        $content = capture('404', ['page' => (string) $page]);
    }
} catch (StorageException $e) {
    http_response_code(500);
    $title = 'Ошибка данных';
    $content = capture('error', ['message' => $e->getMessage()]);
}

render('layout', compact('title', 'content', 'userName', 'flash'));

/** Рендерит шаблон в строку, чтобы вставить его в layout. */
function capture(string $template, array $data): string
{
    ob_start();
    render($template, $data);
    return (string) ob_get_clean();
}
