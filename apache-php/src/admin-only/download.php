<?php
require_once "../helper.php";
require_once "../session_reader.php";
require_once "../localizator.php";
$mysqli = openMysqli();
$stmt = $mysqli->prepare("SELECT * FROM users WHERE name=?");
$stmt->bind_param("s", $_SERVER['REMOTE_USER']);
$stmt->execute();
$result = $stmt->get_result()->fetch_assoc();
if (!$result) {
    die(getLocalizedText("unexpected-server-error", $language));
}
// Замените это на реальный идентификатор пользователя
$user_id = $result["ID"];
$directory = "storage/$user_id/";

// Проверяем, существует ли директория
if (!is_dir($directory)) {
    echo getLocalizedText("no-uploaded-files", $language);
    exit;
}

// Получаем список PDF-файлов в директории
$files = array_diff(scandir($directory), array('..', '.'));
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars(getLocalizedText("download-pdf-page-title", $language)); ?></title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
    </style>
    <?php applyStyle(); ?>
</head>
<body>

<h1><?php echo htmlspecialchars(getLocalizedText("download-pdf-page-header", $language)); ?></h1>

<table>
    <thead>
        <tr>
            <th><?php echo htmlspecialchars(getLocalizedText("filename", $language)); ?></th>
            <th><?php echo htmlspecialchars(getLocalizedText("size", $language)); ?></th>
            <th><?php echo htmlspecialchars(getLocalizedText("actions", $language)); ?></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($files as $file): ?>
            <?php if (pathinfo($file, PATHINFO_EXTENSION) === 'pdf'): ?>
                <?php $filePath = "$directory$file"; ?>
                <?php $fileSize = filesize($filePath); ?>
                <tr>
                    <td><?php echo htmlspecialchars($file); ?></td>
                    <td><?php echo round($fileSize / 1024, 2) . ' KB'; ?></td> <!-- Размер в КБ -->
                    <td>
                        <a href="<?php echo $filePath; ?>" download><button><?php echo htmlspecialchars(getLocalizedText("download", $language)); ?></button></a>
                        <?php echo "<button onclick='window.location.replace(\"/admin-only/delete-pdf.php?file=" . $filePath . "\")'>" . htmlspecialchars(getLocalizedText("delete", $language)); ?></button>
                    </td>
                </tr>
            <?php endif; ?>
        <?php endforeach; ?>
    </tbody>
</table>
<button onclick="window.location.replace('/admin-only/admin-menu.php')"><?php echo htmlspecialchars(getLocalizedText("to-admin-menu", $language)); ?></button>
<button onclick="window.location.replace('/index.html')"><?php echo htmlspecialchars(getLocalizedText("to_mainpage", $language)); ?></button>
</body>
</html>