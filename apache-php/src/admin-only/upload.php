<?php
require_once "../helper.php";
require_once "../session_reader.php";
require_once "../localizator.php";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = htmlspecialchars($_POST['user_id']);
    $target_dir = "storage/$user_id/";

    // Создаем директорию, если она не существует
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0755, true);
    }

    $target_file = $target_dir . basename($_FILES["pdf_file"]["name"]);
    $uploadOk = 1;
    $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Проверка на тип файла
    if ($fileType != "pdf") {
        echo htmlspecialchars(getLocalizedText("error-only-pdf-accepted", $language));
        $uploadOk = 0;
    }

    // Проверка на существование файла
    if (file_exists($target_file)) {
        echo htmlspecialchars(getLocalizedText("error-file-already-exists", $language));
        $uploadOk = 0;
    }

    // Проверка размера файла (например, максимум 5MB)
    if ($_FILES["pdf_file"]["size"] > 5000000) {
        echo htmlspecialchars(getLocalizedText("error-file-too-big", $language));
        $uploadOk = 0;
    }

    // Если все проверки пройдены, загружаем файл
    if ($uploadOk == 1) {
        if (move_uploaded_file($_FILES["pdf_file"]["tmp_name"], $target_file)) {
            echo getLocalizedText("file", $language) . htmlspecialchars(basename($_FILES["pdf_file"]["name"])) . getLocalizedText("uploaded", $language);
        } else {
            echo getLocalizedText("upload-error", $language);
        }
    }
}

$mysqli = openMysqli();
$stmt = $mysqli->prepare("SELECT * FROM users WHERE name=?");
$stmt->bind_param("s", $_SERVER['REMOTE_USER']);
$stmt->execute();
$result = $stmt->get_result()->fetch_assoc();
if (!$result) {
    die(getLocalizedText("unexpected-server-error", $language));
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars(getLocalizedText("upload-pdf-page-title", $language)); ?></title>
    <?php applyStyle(); ?>
</head>
<body>
    <h1><?php echo htmlspecialchars(getLocalizedText("upload-pdf-page-header", $language)); ?></h1>
    <form action="upload.php" method="post" enctype="multipart/form-data">
        <label for="file"><?php echo htmlspecialchars(getLocalizedText("choose-pdf", $language)); ?></label><br>
        <input type="file" name="pdf_file" id="file" accept=".pdf" required><br>
        <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($result["ID"]); ?>"><br>
        <button type="submit"><?php echo htmlspecialchars(getLocalizedText("upload", $language)); ?></button>
    </form>
    <button onclick="window.location.replace('/admin-only/admin-menu.php')"><?php echo htmlspecialchars(getLocalizedText("to-admin-menu", $language)); ?></button>
    <button onclick="window.location.replace('/index.html')"><?php echo htmlspecialchars(getLocalizedText("to_mainpage", $language)); ?></button>
</body>
</html>