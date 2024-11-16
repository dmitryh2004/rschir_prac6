<?php 
require_once "../helper.php";
require_once "api.php";
require_once '../session_reader.php';
require_once '../localizator.php';

$id = $_GET["id"];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    delete_service(false, $id, "", "", 0);
}
else {
    $result = read_service(false, $id)[0];

    if ($result) {
        echo "<form method='post' action='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "?id=" . $id . "'>";
        echo getLocalizedText("service-delete-are-you-sure", $language) . " " . $result["title"] . "?<br>
        <button type='submit'>" . getLocalizedText("delete", $language) . "</button>
        </form>";
        echo "<button onclick='window.location.replace(\"/admin-only/service-list.php\")'>" . getLocalizedText("back", $language) . "</button>";
    }
    else {
        echo "<p style='color: #ff0000'>" . getLocalizedText("error", $language) . ": " . getLocalizedText("service-with", $language) . "id=" . $serviceID . " " . getLocalizedText("not-found", $language) . ".</p>";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars(getLocalizedText("service-delete-page-title", $language)) ?></title>
    <?php applyStyle(); ?>
</head>
</html>