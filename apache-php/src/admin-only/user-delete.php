<?php 
require_once "../helper.php";
require_once "api.php";
require_once '../session_reader.php';
require_once '../localizator.php';
$userID = $_GET["id"];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    delete_user(false, $userID, "", "");
}
else {
    $result = read_user(false, $userID);

    if ($result) {
        $result = $result[0];
        echo "<form method='post' action='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "?id=" . $userID . "'>";
        echo getLocalizedText("user-delete-are-you-sure", $language) . " " . $result["name"] . "?<br>
        <button type='submit'>" . getLocalizedText("delete", $language) . "</button>
        </form>";
        echo "<button onclick='window.location.replace(\"/admin-only/user-list.php\")'>" . getLocalizedText("back", $language) . "</button>";
    }
    else {
        echo "<p style='color: #ff0000'>" . getLocalizedText("error", $language) . ": " . getLocalizedText("user-with", $language) . "id=" . $userID . " " . getLocalizedText("not-found", $language) . ".</p>";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars(getLocalizedText("user-delete-page-title", $language)) ?></title>
    <?php applyStyle(); ?>
</head>
</html>