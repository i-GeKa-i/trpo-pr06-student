<?php /** @var string $title */ /** @var string $content */ /** @var string $userName */ /** @var array $flash */ ?>
<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($title) ?> — Практическая работа 6</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header class="top">
    <div class="brand">Практическая работа 6</div>
    <nav>
        <a href="index.php?page=notes">Заметки</a>
        <a href="index.php?page=scenarios">Сценарии session</a>
    </nav>
    <?php require __DIR__ . '/userbar.php'; ?>
</header>
<main class="wrap">
    <?php foreach ($flash as $f): ?>
        <p class="flash <?= e($f['type']) ?>" role="status"><?= e($f['text']) ?></p>
    <?php endforeach; ?>
    <?= $content ?>
</main>
</body>
</html>
