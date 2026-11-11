<?php
declare(strict_types=1);

// Единая точка входа: все переходы идут через index.php?page=<имя>.
require __DIR__ . '/../src/view.php';
require __DIR__ . '/../src/notes.php';
require __DIR__ . '/../src/session.php';

session_start(); // до любого вывода HTML

$page = $_GET['page'] ?? 'notes';

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        handlePost($_POST['action'] ?? '');
    }
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

$flash = pullFlash();
$userName = currentUser();
try {
    $users = loadJson('users');
} catch (StorageException) {
    $users = []; // ошибка уже показана на странице; шапка просто без списка
}
render('layout', compact('title', 'content', 'userName', 'users', 'flash'));

/** Рендерит шаблон в строку, чтобы вставить его в layout. */
function capture(string $template, array $data): string
{
    ob_start();
    render($template, $data);
    return (string) ob_get_clean();
}

/** Обработчик POST-действий: меняет данные и делает redirect (Post/Redirect/Get). */
function handlePost(string $action): never
{
    try {
        if ($action === 'add_note') {
            $error = addNote((string) ($_POST['title'] ?? ''));
            flash($error ? 'error' : 'ok', $error ?? 'Заметка добавлена.');
        }
        if ($action === 'set_user') {
            $error = setUser((string) ($_POST['name'] ?? ''));
            flash($error ? 'error' : 'ok', $error ?? 'Имя сохранено в session.');
        }
        if ($action === 'clear_user') {
            clearUser();
            flash('ok', 'Имя очищено, используется значение по умолчанию.');
        }
    } catch (StorageException $e) {
        flash('error', $e->getMessage());
    }
    header('Location: index.php?page=notes');
    exit;
}

function flash(string $type, string $text): void
{
    $_SESSION['flash'][] = ['type' => $type, 'text' => $text];
}

/** Возвращает и очищает одноразовые сообщения. */
function pullFlash(): array
{
    $f = $_SESSION['flash'] ?? [];
    unset($_SESSION['flash']);
    return $f;
}
