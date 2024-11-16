<?php 
require_once "../helper.php";
require_once "api.php";
require_once '../session_reader.php';
require_once '../localizator.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_name = $_POST["name"];
    $new_password = $_POST["password"];

    update_user(false, $_GET["id"], $new_name, $new_password, $language);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars(getLocalizedText("user-update-page-title", $language)); ?></title>
    <?php applyStyle(); ?>
</head>
<body>
<h1><?php echo htmlspecialchars(getLocalizedText("user-update-page-header", $language)); ?></h1>
<?php 
$db = openMysqli();
$userID = $_GET["id"];

$result = read_user(false, $userID);

if ($result) {
    $result = $result[0];
    echo "<form method='post' action='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "?id=" . $userID . "'>";
    echo getLocalizedText("username", $language) . ": <input name='name' value='" . $result["name"] . "' required><br>";
    echo getLocalizedText("new-password", $language) . ": <input type='password' name='password' value='' required><br>
    <button type='submit'>" . getLocalizedText("save", $language) . "</button>
    </form>";
    echo "<button onclick='window.location.replace(\"/admin-only/user-list.php\")'>" . getLocalizedText("back", $language) . "</button>";
}
else {
    echo "<p style='color: #ff0000'>" . getLocalizedText("error", $language) . ": " . getLocalizedText("user-with", $language) . "id=" . $userID . " " . getLocalizedText("not-found", $language) . ".</p>";
}
$db->close();
?>
</body>
</html>