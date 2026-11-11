<?php /** @var array $scenarios */ /** @var array $results */ ?>
<section id="scenarios" class="hero">
    <span class="pill">session_scenarios.json</span>
    <h1>Сценарии session</h1>
    <p class="muted">Запустите сценарий в обычной вкладке, затем откройте страницу в приватном окне: там session будет пустой — имя «Гость».</p>
    <?php if (!$scenarios): ?>
        <p class="muted">Сценариев нет.</p>
    <?php else: ?>
        <table class="table">
            <thead><tr><th>Сценарий</th><th>Значение</th><th>Ожидается</th><th>Сейчас</th><th></th></tr></thead>
            <tbody>
            <?php foreach ($scenarios as $i => $s): $actual = $results[$i]; ?>
                <tr>
                    <td><?= e($s['scenario']) ?></td>
                    <td><?= e($s['value'] ?? '—') ?></td>
                    <td><?= e($s['expected']) ?></td>
                    <td class="<?= $actual === $s['expected'] ? 'ok-text' : 'bad-text' ?>"><?= e($actual) ?></td>
                    <td>
                        <form method="post" action="index.php?page=scenarios" class="inline">
                            <input type="hidden" name="action" value="run_scenario">
                            <input type="hidden" name="index" value="<?= e($i) ?>">
                            <button class="btn" type="submit">Выполнить</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</section>
