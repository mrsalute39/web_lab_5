<?php session_start(); ?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <title>Главная</title>
</head>

<body>

<?php if (isset($_SESSION['username'])): ?>
    <p>Данные из сессии:</p>
    <ul>
        <li>Имя: <?= $_SESSION['username'] ?></li>
        <li>Количество блюд: <?= $_SESSION['theme'] ?></li>
    </ul>
<?php else: ?>
    <p>Данных пока нет.</p>
<?php endif; ?>

<a href="form.html">Заполнить форму</a>
<a href="view.php">Посмотреть все данные</a>

<?php if (isset($_SESSION['errors'])): ?>
    <ul style="color:red;">
        <?php foreach ($_SESSION['errors'] as $error): ?>
            <li><?= $error ?></li>
        <?php endforeach; ?>
    </ul>
    <?php unset($_SESSION['errors']); ?>
<?php endif; ?>

<?php if (isset($_SESSION['api_data'])): ?>
    <h3>Данные из API:</h3>
    <pre><?= print_r($_SESSION['api_data'], true) ?></pre>
    <?php unset($_SESSION['api_data']); ?>
<?php endif; ?>

<?php
require_once 'UserInfo.php';
$info = UserInfo::getInfo();
?>
<h3>Информация о пользователе:</h3>
<p>Данные успешно загружены (скрыто для приватности).</p>

<?php
require 'db.php';
require 'Student.php';

$order = new Student($pdo);
$all = $order->getAll();
?>

<h2>Сохранённые данные:</h2>
<ul>
<?php foreach ($all as $row): ?>
    <li>
        <strong><?= htmlspecialchars($row['username']) ?></strong> |
        Ресторан: <?= htmlspecialchars($row['theme']) ?> |
        Блюд: <?= htmlspecialchars($row['age']) ?> |
        Оплата онлайн: <?= $row['prize'] ? 'Да' : 'Нет' ?> |
        Коробка: <?= $row['difficulty'] === 'c' ? 'Легко' : 'Сложно' : 'ПМ' ?>
    </li>
<?php endforeach; ?>
</ul>

<a href="form.html">Заполнить форму</a>

</body>
</html>