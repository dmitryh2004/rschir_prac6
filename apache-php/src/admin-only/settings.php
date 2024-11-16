<?php
require_once "../session_reader.php";
require_once "../localizator.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Получаем значения из формы
    $theme = isset($_POST['theme']) ? 1 : 0; // 1 - темная тема, 0 - светлая
    $language = $_POST['language']; // "ru" или "en"
    $scale = floatval($_POST['scale']); // Масштаб текста

    // Проверка значений
    if (!in_array($language, ['ru', 'en'])) {
        die("Неверный язык.");
    }

    if ($scale < 0.5 || $scale > 2.0) {
        die("Масштаб текста должен быть от 0.5 до 2.0.");
    }

    $_SESSION["theme"] = $theme;
    $_SESSION["language"] = $language;
    $_SESSION["scale"] = $scale;
    $_SESSION["user"] = $_SERVER["REMOTE_USER"];
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars(getLocalizedText("settings-page-title", $language)); ?></title>
    <?php applyStyle(); ?>
    <style>
        .scale-value {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <h1><?php echo htmlspecialchars(getLocalizedText("settings-page-header", $language)); ?></h1>
    <form action="settings.php" method="POST">
        <label>
            <input type="checkbox" name="theme" value="1" <?php if ($theme) echo htmlspecialchars("checked"); ?>> <?php echo htmlspecialchars(getLocalizedText("dark-theme", $language)); ?>
        </label><br><br>

        <label for="language"><?php echo htmlspecialchars(getLocalizedText("select-language", $language)); ?></label>
        <select name="language" id="language">
            <option value="ru" <?php if ($language == "ru") echo "selected"; ?>>Русский</option>
            <option value="en" <?php if ($language == "en") echo "selected"; ?>>English</option>
        </select><br><br>

        <label for="scale"><?php echo htmlspecialchars(getLocalizedText("text-scale", $language)); ?></label>
        <input type="range" name="scale" id="scale" min="0.5" max="2.0" step="0.1" value=<?php echo htmlspecialchars("'" . $scale . "'"); ?> oninput="updateScaleValue(this.value)">
        <span class="scale-value" id="scaleValue">1.0</span><br><br>

        <button type="submit"><?php echo htmlspecialchars(getLocalizedText("save", $language)); ?></button>
    </form>
    <button onclick="window.location.replace('/admin-only/admin-menu.php')"><?php echo htmlspecialchars(getLocalizedText("to-admin-menu", $language)); ?></button>
    <script>
        function updateScaleValue(value) {
            document.getElementById('scaleValue').textContent = (Math.round(value * 100) + "%");
        }

        // Инициализация значения при загрузке страницы
        document.addEventListener('DOMContentLoaded', function() {
            updateScaleValue(document.getElementById('scale').value);
        });
    </script>
</body>
</html>