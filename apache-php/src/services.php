<?php
require_once 'helper.php';
require_once 'session_reader.php';
require_once 'localizator.php';
$mysqli = openMysqli();
$stmt = $mysqli->prepare('SELECT * FROM services');
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars(getLocalizedText("service-page-title", $language)); ?></title>
    <?php applyStyle(); ?>
    <style>
        span {
            margin: 10px;
        }
        .list {
            display: flex;
            flex-direction: column;
        }
        .item {
            display: flex;
            flex-direction: row;
            cursor: pointer;
            text-decoration: underline;
            color: blue;
        }

        .item:hover { background-color: cadetblue; color: blueviolet }
        </style>

</head>
<body>
<h1><?php echo htmlspecialchars(getLocalizedText("service-page-header", $language)); ?></h1>

<table border="1">
    <tr>
        <th>ID</th>
        <th><?php echo htmlspecialchars(getLocalizedText("service-title", $language)); ?></th>
        <th><?php echo htmlspecialchars(getLocalizedText("service-desc", $language)); ?></th>
        <th><?php echo htmlspecialchars(getLocalizedText("service-cost", $language)); ?></th>
        <th><?php echo htmlspecialchars(getLocalizedText("service-link", $language)); ?></th>
    </tr>
    <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?php echo htmlspecialchars($row['ID']); ?></td>
            <td><?php echo htmlspecialchars($row['title']); ?></td>
            <td><?php echo htmlspecialchars($row['description']); ?></td>
            <td><?php echo htmlspecialchars($row['cost']); ?></td>
            <td><?php echo "<a href='view.php?id=" . $row['ID'] . "'>" . 
            getLocalizedText("link", $language) . "</a>"; ?></td>
        </tr>
    <?php endwhile; ?>
</table>
<button onclick="window.location.replace('/index.html')"><?php echo htmlspecialchars(getLocalizedText("to_mainpage", $language)); ?></button>
</body>
</html>