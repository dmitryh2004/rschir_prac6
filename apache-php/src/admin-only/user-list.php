<?php 
require_once '../session_reader.php';
require_once '../localizator.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars(getLocalizedText("user-list-page-title", $language)); ?></title>
    <?php applyStyle(); ?>
</head>
<style>
    table {
        text-align: center;
    }
</style>
<body>
<h1><?php echo htmlspecialchars(getLocalizedText("user-list-page-header", $language)); ?></h1>
<?php
require_once '../helper.php';
require_once 'api.php';
$result = read_user(false, 0);
?>
<table border="1">
    <tr>
        <th>ID</th>
        <th><?php echo htmlspecialchars(getLocalizedText("username", $language)); ?></th>
        <th><?php echo htmlspecialchars(getLocalizedText("password-hash", $language)); ?></th>
        <th><?php echo htmlspecialchars(getLocalizedText("actions", $language)); ?></th>
    </tr>
    <?php foreach ($result as $row): ?>
        <tr>
            <td><?php echo htmlspecialchars($row['ID']); ?></td>
            <td><?php echo htmlspecialchars($row['name']); ?></td>
            <td><?php echo htmlspecialchars($row['password']); ?></td>
            <td>
                <?php 
                    $current_user = $_SERVER['REMOTE_USER'];
                    if ($current_user != $row['name']) {
                        echo "<a href='/admin-only/user-update.php?id=" . $row['ID'] . "'>" . 
                        htmlspecialchars(getLocalizedText("edit", $language)) . "</a><br>";
                        echo "<a href='/admin-only/user-delete.php?id=" . $row['ID'] . "'>" . 
                        htmlspecialchars(getLocalizedText("delete", $language)) . "</a>";
                    }
                    else {
                        echo "<b>" . htmlspecialchars(getLocalizedText("its-you", $language)) . "</b>";
                    }
                ?>
            </td>
        </tr>
    <?php endforeach; ?>
    <tr>
        <td colspan="4">
            <button onclick="window.location.replace('user-create.php');"><?php echo htmlspecialchars(getLocalizedText("add-user", $language)); ?></button>
        </td>
    </tr>
</table>
<button onclick="window.location.replace('/admin-only/service-list.php')"><?php echo htmlspecialchars(getLocalizedText("to-service-list", $language)); ?></button>
<button onclick="window.location.replace('/admin-only/admin-menu.php')"><?php echo htmlspecialchars(getLocalizedText("to-admin-menu", $language)); ?></button>
<button onclick="window.location.replace('/index.html')"><?php echo htmlspecialchars(getLocalizedText("to_mainpage", $language)); ?></button>
</body>
</html>