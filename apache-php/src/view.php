<?php 
require_once 'session_reader.php';
require_once 'localizator.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars(getLocalizedText("view-page-title", $language)); ?></title>
    <?php applyStyle(); ?>
</head>
<body>
<?php require_once 'helper.php'; $id = $_GET["id"];
if (!isset($id) || !is_numeric($id)) throw new Exception();

$mysqli = openMysqli();
$stmt = $mysqli->prepare('SELECT * FROM services WHERE id=?');
$stmt->bind_param('i', $id);
$stmt->execute();
$result = $stmt->get_result();
$service = $result->fetch_assoc();
echo "<h1>" . getLocalizedText("view-page-header", $language) . "</h1>";
echo "<table border='1'>
    <tr>
        <th>ID</th>
        <th>" . getLocalizedText("service-title", $language) . "</th>
        <th>" . getLocalizedText("service-desc", $language) . "</th>
        <th>" . getLocalizedText("service-cost", $language) . "</th>
    </tr>
    <tr>
        <td>" . $service['ID'] . "</td>
        <td>" . $service['title'] . "</td>
        <td>" . $service['description'] . "</td>
        <td>" . $service['cost'] . "</td>
    </tr>
</table>";
$mysqli->close();
?>
<button onclick="window.location.replace('/services.php')"><?php echo htmlspecialchars(getLocalizedText("back", $language)); ?></button>
<button onclick="window.location.replace('/index.html')"><?php echo htmlspecialchars(getLocalizedText("to_mainpage", $language)); ?></button>
</body>
</html>