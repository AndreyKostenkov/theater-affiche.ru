<?php
include 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Проверка, что файл действительно является изображением
    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if ($check !== false) {
        $uploadOk = 1;
    } else {
        echo "Файл не является изображением.";
        $uploadOk = 0;
    }

    // Проверка наличия файла
    if (file_exists($target_file)) {
        echo "Извините, файл уже существует.";
        $uploadOk = 0;
    }

    // Проверка размера файла
    if ($_FILES["image"]["size"] > 500000) {
        echo "Извините, ваш файл слишком большой.";
        $uploadOk = 0;
    }

    // Разрешенные форматы файлов
    $allowed_formats = array("jpg", "jpeg", "png", "gif");
    if (!in_array($imageFileType, $allowed_formats)) {
        echo "Извините, разрешены только JPG, JPEG, PNG и GIF файлы.";
        $uploadOk = 0;
    }

    // Проверка на ошибки
    if ($uploadOk == 0) {
        echo "Извините, ваш файл не был загружен.";
    } else {
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            echo "Файл " . htmlspecialchars(basename($_FILES["image"]["name"])) . " был загружен.";

            // Сохранение информации о файле в базе данных
            $image_url = $target_file;

            $stmt = $conn->prepare("UPDATE Shows SET image_url = ? WHERE title = ?");
            $stmt->bind_param("ss", $image_url, $title);

            if ($stmt->execute()) {
                echo "Изображение успешно сохранено в базе данных.";
            } else {
                echo "Ошибка при сохранении изображения в базе данных: " . $stmt->error;
            }

            $stmt->close();
        } else {
            echo "Извините, произошла ошибка при загрузке вашего файла.";
        }
    }
}
?>
