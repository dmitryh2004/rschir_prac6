<?php 
require_once "../session_reader.php";
require_once "../localizator.php";
?>
<?php 
require_once "graph-creator.php";
get_pie_chart();
get_amount_distribution();
get_cost_per_client();
overlay_watermarks();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars(getLocalizedText("show-stats-page-title", $language)); ?></title>
    <?php applyStyle(); ?>
</head>
<style>
    table {
        text-align: center;
    }
</style>
<body>
    <h1><?php echo htmlspecialchars(getLocalizedText("show-stats-page-header", $language)); ?></h1>
    <a href="admin-menu.php"><button><?php echo htmlspecialchars(getLocalizedText("to-admin-menu", $language)); ?></button></a><br>
    <?php
        require_once '../helper.php';
        require_once 'api.php';
        $result = read_entries_with_service_name(false, 0);
    ?>
<table border="1">
    <tr>
        <th>ID</th>
        <th><?php echo htmlspecialchars(getLocalizedText("customer-name", $language)); ?></th>
        <th><?php echo htmlspecialchars(getLocalizedText("service-title", $language)); ?></th>
        <th><?php echo htmlspecialchars(getLocalizedText("amount", $language)); ?></th>
        <th><?php echo htmlspecialchars(getLocalizedText("comment", $language)); ?></th>
    </tr>
    <?php foreach ($result as $row): ?>
        <tr>
            <td><?php echo htmlspecialchars($row['entry_id']); ?></td>
            <td><?php echo htmlspecialchars($row['customer_name']); ?></td>
            <td><?php echo htmlspecialchars($row['title']); ?></td>
            <td><?php echo htmlspecialchars($row['amount']); ?></td>
            <td><?php echo htmlspecialchars($row['comment']); ?></td>
        </tr>
    <?php endforeach; ?>
</table>

<h2><?php echo htmlspecialchars(getLocalizedText("stats-graph1-name", $language)); ?></h2>
<img src="./storage/graph1.png"><br>
<h2><?php echo htmlspecialchars(getLocalizedText("stats-graph2-name", $language)); ?></h2>
<img src="./storage/graph2.png"><br>
<h2><?php echo htmlspecialchars(getLocalizedText("stats-graph3-name", $language)); ?></h2>
<img src="./storage/graph3.png"><br>
<br><a href="admin-menu.php"><button><?php echo htmlspecialchars(getLocalizedText("to-admin-menu", $language)); ?></button></a>
</body>
</html>