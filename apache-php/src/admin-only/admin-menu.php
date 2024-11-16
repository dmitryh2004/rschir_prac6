<?php 
require_once '../session_reader.php';
require_once '../localizator.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title><?php echo htmlspecialchars(getLocalizedText("admin-menu-page-title", $language)); ?></title>
        <?php applyStyle(); ?>
    </head>
    <body>
        <h1><?php echo htmlspecialchars(getLocalizedText("admin-menu-page-header", $language)); ?></h1>
        <ul>
        <li><a href="user-list.php"><?php echo htmlspecialchars(getLocalizedText("to-user-list", $language)); ?></a></li>
        <li><a href="service-list.php"><?php echo htmlspecialchars(getLocalizedText("to-service-list", $language)); ?></a></li>
        <li><a href="settings.php"><?php echo htmlspecialchars(getLocalizedText("settings", $language)); ?></a></li>
        <li><a href="upload.php"><?php echo htmlspecialchars(getLocalizedText("upload-pdf", $language)); ?></a></li>
        <li><a href="download.php"><?php echo htmlspecialchars(getLocalizedText("download-pdf", $language)); ?></a></li>
        <li><a href="generate-fixtures.php"><?php echo htmlspecialchars(getLocalizedText("generate-fixtures", $language)); ?></a></li>
        <li><a href="show-stats.php"><?php echo htmlspecialchars(getLocalizedText("show-stats", $language)); ?></a></li>
        </ul>
        <button onclick="window.location.replace('/index.html')"><?php echo htmlspecialchars(getLocalizedText("to_mainpage", $language)); ?></button>
    </body>
</html>