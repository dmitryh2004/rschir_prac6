<?php 
require_once "../session_reader.php";
require_once "../localizator.php";
applyStyle();
    if (isset($_GET['file'])) {
        $filePath = $_GET['file']; // Получаем путь к файлу из GET-запроса
    
        // Проверяем, существует ли файл
        if (file_exists($filePath)) {
            // Удаляем файл
            if (unlink($filePath)) {
                echo getLocalizedText("file-delete-success", $language);
            } else {
                echo getLocalizedText("file-delete-error", $language);
            }
        } else {
            echo getLocalizedText("file-delete-not-found", $language);
        }
    } else {
        echo getLocalizedText("file-delete-not-selected", $language);
    }
?>
<a href="download.php"><button><?php echo htmlspecialchars(getLocalizedText("back", $language)); ?></button></a>