<?php
session_start();
include 'includes/db.php';

if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("INSERT INTO Users (username, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $username, $password);

    if ($stmt->execute()) {
        header("Location: login.php");
        exit();
    } else {
        $error = "Ошибка при регистрации.";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <header>
        <h1>Регистрация</h1>
        <nav>
            <a href="index.php">Главная</a>
        </nav>
    </header>
    <main>
        <form action="register.php" method="post">
            <label for="username">Имя пользователя:</label>
            <input type="text" id="username" name="username" required>
            <label for="password">Пароль:</label>
            <input type="password" id="password" name="password" required>
            <button type="submit">Зарегистрироваться</button>
        </form>
        <?php if (isset($error)): ?>
            <p><?php echo $error; ?></p>
        <?php endif; ?>
    </main>
</body>
</html>
