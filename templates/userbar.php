<?php /** @var string $userName */ /** @var array $users */ ?>
<div class="user">
    <span>Пользователь: <b><?= e($userName) ?></b></span>
    <form method="post" action="index.php?page=notes" class="inline">
        <input type="hidden" name="action" value="set_user">
        <select name="name" aria-label="Выбор пользователя">
            <?php foreach ($users as $u): ?>
                <option value="<?= e($u['name']) ?>" <?= $u['name'] === $userName ? 'selected' : '' ?>><?= e($u['name']) ?></option>
            <?php endforeach; ?>
        </select>
        <button class="btn" type="submit">Войти</button>
    </form>
    <form method="post" action="index.php?page=notes" class="inline">
        <input type="hidden" name="action" value="clear_user">
        <button class="btn secondary" type="submit">Очистить</button>
    </form>
</div>
