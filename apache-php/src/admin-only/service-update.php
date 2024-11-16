<?php 
require_once "../helper.php";
require_once "api.php";
require_once '../session_reader.php';
require_once '../localizator.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_title = $_POST["title"];
    $new_description = $_POST["description"];
    $new_cost = $_POST["cost"];
    update_service(false, $_GET["id"], $new_title, $new_description, $new_cost);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars(getLocalizedText("service-update-page-title", $language)); ?></title>
    <?php applyStyle(); ?>
</head>
<body>
<h1><?php echo htmlspecialchars(getLocalizedText("service-update-page-header", $language)); ?></h1>
<?php 
$db = openMysqli();
$serviceID = $_GET["id"];

$result = read_service(false, $serviceID);

if ($result) {
    $result = $result[0];
    echo "<form method='post' action='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "?id=" . $serviceID . "'>";
    echo getLocalizedText("service-title", $language) . ": <input name='title' value='" . $result["title"] . "' required><br>";
    echo getLocalizedText("service-desc", $language) . ": <input name='description' value='" . $result["description"] . "' required><br>";
    echo getLocalizedText("service-cost", $language) . ": <input type='number' name='cost' value='" . $result["cost"] . "' required><br>
    <button type='submit'>" . getLocalizedText("save", $language) . "</button>
    </form>";
    echo "<button onclick='window.location.replace(\"/admin-only/service-list.php\")'>" . getLocalizedText("back", $language) . "</button>";
}
else {
    echo "<p style='color: #ff0000'>" . getLocalizedText("error", $language) . ": " . getLocalizedText("service-with", $language) . "id=" . $serviceID . " " . getLocalizedText("not-found", $language) . ".</p>";
}
$db->close();
?>
</body>
</html>