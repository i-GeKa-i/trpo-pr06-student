<?php
declare(strict_types=1);

require_once __DIR__ . '/storage.php';

function loadNotes(): array
{
    return loadJson('notes');
}

function addNote(string $title): ?string
{
    $title = trim($title);
    if ($title === '') {
        return 'Введите текст заметки.';
    }
    if (!preg_match('/^.{1,120}$/su', $title)) {
        return 'Заметка слишком длинная (максимум 120 символов) или содержит недопустимые символы.';
    }
    $notes = loadNotes();
    $id = $notes ? max(array_column($notes, 'id')) + 1 : 1;
    $notes[] = ['id' => $id, 'title' => $title, 'done' => false];
    saveJson('notes', $notes);
    return null;
}
