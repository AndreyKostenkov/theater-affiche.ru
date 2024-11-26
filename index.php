<?php
session_start();
include 'includes/db.php';

$category = isset($_GET['category']) ? $_GET['category'] : '';
$query = "SELECT * FROM Shows";
if ($category) {
    $query .= " WHERE type = '$category'";
}
$shows = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Афиша</title>
    <link rel="stylesheet" href="css/styles.css">
    <style>
        .dropdown {
            position: relative;
            display: inline-block;
        }
        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #f9f9f9;
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
            z-index: 1;
        }
        .dropdown-content a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }
        .dropdown-content a:hover {
            background-color: #f1f1f1;
        }
        .dropdown:hover .dropdown-content {
            display: block;
        }
        .show-card img {
            max-width: 100%;
            height: auto;
        }
    </style>
</head>
<body>
    <header>
        <h1>Афиша кинотеатра</h1>
        <nav>
            <?php if (isset($_SESSION['user_id'])): ?>
                <p>Добро пожаловать, <?php echo $_SESSION['user_name']; ?>!</p>
                <a href="logout.php">Выйти</a>
            <?php else: ?>
                <a href="login.php">Войти</a>
                <a href="register.php">Зарегистрироваться</a>
            <?php endif; ?>
        </nav>
    </header>
    <main>
        <div class="dropdown">
            <button class="dropbtn">Фильмы</button>
            <div class="dropdown-content">
                <a href="index.php">Все</a>
                <a href="index.php?category=Драма">Драма</a>
                <a href="index.php?category=Боевик">Боевик</a>
                <a href="index.php?category=Комедия">Комедия</a>
                <a href="index.php?category=Мультфильмы">Мультфильмы</a>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="profile.php">Избранное</a>
                <?php endif; ?>
            </div>
        </div>
        <div class="shows">
            <?php if ($shows->num_rows > 0): ?>
                <?php while ($show = $shows->fetch_assoc()): ?>
                    <div class="show-card">
                        <img src="<?php echo htmlspecialchars($show['image_url']); ?>" alt="<?php echo htmlspecialchars($show['title']); ?>">
                        <h2><?php echo htmlspecialchars($show['title']); ?></h2>
                        <p>Тип: <?php echo htmlspecialchars($show['type']); ?></p>
                        <p>Длительность: <?php echo htmlspecialchars($show['duration']); ?> мин</p>
                        <?php if (isset($_SESSION['user_id'])): ?>
                            <button class="add-to-favorites" data-show-id="<?php echo htmlspecialchars($show['id']); ?>">Добавить в избранное</button>
                        <?php endif; ?>
                        <a href="show.php?id=<?php echo htmlspecialchars($show['id']); ?>">Подробнее</a>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>Нет доступных спектаклей или фильмов.</p>
            <?php endif; ?>
        </div>
    </main>
    <script src="js/scripts.js"></script>
</body>
</html>
