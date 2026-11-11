<?php /** @var string $message */ ?>
<section class="hero error-box">
    <h1>Не удалось загрузить данные</h1>
    <p><?= e($message) ?></p>
    <p class="muted">Проверьте файлы в папке data/ (образец — dataset/).</p>
</section>
