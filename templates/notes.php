<?php /** @var array $notes */ ?>
<section id="notes" class="hero">
    <span class="pill">заметки</span>
    <h1>Список учебных заметок</h1>
    <form method="post" action="index.php?page=notes" class="inline">
        <input type="hidden" name="action" value="add_note">
        <input type="text" name="title" placeholder="Новая заметка" maxlength="120" required aria-label="Текст заметки">
        <button class="btn" type="submit">Добавить</button>
    </form>
    <?php if (!$notes): ?>
        <p class="muted">Заметок пока нет.</p>
    <?php else: ?>
        <table class="table">
            <thead><tr><th>ID</th><th>Заметка</th><th>Статус</th></tr></thead>
            <tbody>
            <?php foreach ($notes as $n): ?>
                <tr>
                    <td><?= e($n['id']) ?></td>
                    <td><?= e($n['title']) ?></td>
                    <td><span class="pill"><?= $n['done'] ? 'выполнено' : 'в работе' ?></span></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</section>
