<?php 
require_once "../helper.php";
require_once "api.php";
require_once '../session_reader.php';
require_once '../localizator.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_title = $_POST["title"];
    $new_description = $_POST["description"];
    $new_cost = $_POST["cost"];
    create_service(false, 0, $new_title, $new_description, $new_cost);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars(getLocalizedText("service-create-page-title", $language)); ?></title>
    <?php applyStyle(); ?>
</head>
<body>
<h1><?php echo htmlspecialchars(getLocalizedText("service-create-page-header", $language)); ?></h1>
<?php 
echo "<form method='post' action='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "'>";
echo getLocalizedText("service-title", $language) . ": <input name='title' required><br>";
echo getLocalizedText("service-desc", $language) . ": <input name='description' required><br>";
echo getLocalizedText("service-cost", $language) . ": <input type='number' name='cost' required><br>
<button type='submit'>" . getLocalizedText("save", $language) . "</button>
</form>";
echo "<button onclick='window.location.replace(\"/admin-only/service-list.php\")'>" . getLocalizedText("back", $language) . "</button>";
?>
</body>
</html>