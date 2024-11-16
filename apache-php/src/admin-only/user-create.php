<?php 
require_once "../helper.php";
require_once "api.php";
require_once '../session_reader.php';
require_once '../localizator.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_name = $_POST["name"];
    $new_password = $_POST["password"];

    create_user(false, 0, $new_name, $new_password);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars(getLocalizedText("user-create-page-title", $language)); ?></title>
    <?php applyStyle(); ?>
</head>
<body>
<h1><?php echo htmlspecialchars(getLocalizedText("user-create-page-header", $language)); ?></h1>
<?php 
echo "<form method='post' action='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "'>";
echo getLocalizedText("username", $language) . ": <input name='name' required><br>";
echo getLocalizedText("password", $language) . ": <input type='password' name='password' required><br>
<button type='submit'>" . getLocalizedText("save", $language) . "</button>
</form>";
echo "<button onclick='window.location.replace(\"/admin-only/user-list.php\")'>" . getLocalizedText("back", $language) . "</button>";
?>
</body>
</html>