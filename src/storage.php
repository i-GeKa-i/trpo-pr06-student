<?php
declare(strict_types=1);

/** Ошибка чтения/записи файлового хранилища (показывается пользователю). */
class StorageException extends RuntimeException {}

const DATA_DIR = __DIR__ . '/../data';

/** Читает data/<name>.json и возвращает массив. Бросает StorageException при проблеме. */
function loadJson(string $name): array
{
    $path = DATA_DIR . "/$name.json";
    $raw = is_file($path) ? @file_get_contents($path) : false;
    if ($raw === false) {
        throw new StorageException("Файл data/$name.json не найден или недоступен для чтения.");
    }
    try {
        $data = json_decode($raw, true, flags: JSON_THROW_ON_ERROR);
    } catch (JsonException $e) {
        throw new StorageException("Файл data/$name.json повреждён: " . $e->getMessage());
    }
    if (!is_array($data)) {
        throw new StorageException("Файл data/$name.json должен содержать список записей.");
    }
    return $data;
}

/** Записывает массив в data/<name>.json (с блокировкой, чтобы запросы не портили файл). */
function saveJson(string $name, array $data): void
{
    $json = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_THROW_ON_ERROR);
    if (@file_put_contents(DATA_DIR . "/$name.json", $json . "\n", LOCK_EX) === false) {
        throw new StorageException("Не удалось записать data/$name.json.");
    }
}
