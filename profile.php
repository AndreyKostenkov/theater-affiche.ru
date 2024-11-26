<?php
session_start();
include 'includes/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$favorites = $conn->query("SELECT Shows.* FROM Favorites JOIN Shows ON Favorites.show_id = Shows.id WHERE Favorites.user_id = $user_id");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Профиль</title>
    <link rel="stylesheet" href="css/styles.css">
    <style>
        .show-card img {
            max-width: 100%;
            height: auto;
        }
    </style>
</head>
<body>
    <header>
        <h1>Профиль</h1>
        <nav>
            <a href="index.php">Главная</a>
            <p>Добро пожаловать, <?php echo $_SESSION['user_name']; ?>!</p>
            <a href="logout.php">Выйти</a>
        </nav>
    </header>
    <main>
        <h2>Избранные фильмы</h2>
        <div class="favorites">
            <?php if ($favorites->num_rows > 0): ?>
                <?php while ($show = $favorites->fetch_assoc()): ?>
                    <div class="show-card">
                        <img src="<?php echo $show['image_url']; ?>" alt="<?php echo $show['title']; ?>">
                        <h2><?php echo $show['title']; ?></h2>
                        <p>Тип: <?php echo $show['type']; ?></p>
                        <p>Длительность: <?php echo $show['duration']; ?> мин</p>
                        <a href="show.php?id=<?php echo $show['id']; ?>">Подробнее</a>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>Нет избранных фильмов.</p>
            <?php endif; ?>
        </div>
    </main>
</body>
</html>
