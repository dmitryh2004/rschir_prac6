<?php 
require_once "../session_reader.php";
require_once "../localizator.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars(getLocalizedText("service-list-page-title", $language)); ?></title>
    <?php applyStyle(); ?>
</head>
<style>
    table {
        text-align: center;
    }
</style>
<body>
<h1><?php echo htmlspecialchars(getLocalizedText("service-list-page-header", $language)); ?></h1>
<?php
require_once '../helper.php';
require_once 'api.php';
$result = read_service(false, 0);
?>
<table border="1">
    <tr>
        <th>ID</th>
        <th><?php echo htmlspecialchars(getLocalizedText("service-title", $language)); ?></th>
        <th><?php echo htmlspecialchars(getLocalizedText("service-desc", $language)); ?></th>
        <th><?php echo htmlspecialchars(getLocalizedText("service-cost", $language)); ?></th>
        <th><?php echo htmlspecialchars(getLocalizedText("actions", $language)); ?></th>
    </tr>
    <?php foreach ($result as $row): ?>
        <tr>
            <td><?php echo htmlspecialchars($row['ID']); ?></td>
            <td><?php echo htmlspecialchars($row['title']); ?></td>
            <td><?php echo htmlspecialchars($row['description']); ?></td>
            <td><?php echo htmlspecialchars($row['cost']); ?></td>
            <td>
                <?php 
                    echo "<a href='/admin-only/service-update.php?id=" . $row['ID'] . "'>" . getLocalizedText("edit", $language) . "</a><br>";
                    echo "<a href='/admin-only/service-delete.php?id=" . $row['ID'] . "'>" . getLocalizedText("delete", $language) . "</a>";
                ?>
            </td>
        </tr>
    <?php endforeach; ?>
    <tr>
        <td colspan="5">
            <button onclick="window.location.replace('service-create.php');"><?php echo htmlspecialchars(getLocalizedText("add-service", $language)); ?></button>
        </td>
    </tr>
</table>
<button onclick="window.location.replace('/admin-only/user-list.php')"><?php echo htmlspecialchars(getLocalizedText("to-user-list", $language)); ?></button>
<button onclick="window.location.replace('/admin-only/admin-menu.php')"><?php echo htmlspecialchars(getLocalizedText("to-admin-menu", $language)); ?></button>
<button onclick="window.location.replace('/index.html')"><?php echo htmlspecialchars(getLocalizedText("to_mainpage", $language)); ?></button>
</body>
</html>