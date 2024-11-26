<?php
session_start();
include 'includes/db.php';

$show_id = isset($_GET['id']) ? $_GET['id'] : null;

if (!$show_id) {
    header("Location: index.php");
    exit();
}

$query = "SELECT * FROM Shows WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $show_id);
$stmt->execute();
$result = $stmt->get_result();
$show = $result->fetch_assoc();

if (!$show) {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($show['title']); ?></title>
    <link rel="stylesheet" href="css/styles.css">
    <style>
        .show-details img {
            max-width: 100%;
            height: auto;
        }
    </style>
</head>
<body>
    <header>
        <h1><?php echo htmlspecialchars($show['title']); ?></h1>
        <nav>
            <a href="index.php">Главная</a>
            <?php if (isset($_SESSION['user_id'])): ?>
                <p>Добро пожаловать, <?php echo htmlspecialchars($_SESSION['user_name']); ?>!</p>
                <a href="logout.php">Выйти</a>
            <?php else: ?>
                <a href="login.php">Войти</a>
                <a href="register.php">Зарегистрироваться</a>
            <?php endif; ?>
        </nav>
    </header>
    <main>
        <div class="show-details">
            <img src="<?php echo htmlspecialchars($show['image_url']); ?>" alt="<?php echo htmlspecialchars($show['title']); ?>">
            <h2><?php echo htmlspecialchars($show['title']); ?></h2>
            <p>Тип: <?php echo htmlspecialchars($show['type']); ?></p>
            <p>Длительность: <?php echo htmlspecialchars($show['duration']); ?> мин</p>
            <p>Описание: <?php echo htmlspecialchars($show['description']); ?></p>
            <a href="<?php echo htmlspecialchars($show['trailer_url']); ?>" target="_blank">Смотреть трейлер</a>
        </div>
    </main>
</body>
</html>
