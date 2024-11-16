<?php 
require_once "../session_reader.php";
require_once "../localizator.php";
?>
<?php

require_once '/var/www/vendor/autoload.php';
require_once 'api.php';

$FIXTURES_COUNT = 75;

// erase previous fixtures
$entries = read_entries();

if ($entries) {
    $mysqli = openMysqli();
    $stmt = $mysqli->prepare("DELETE FROM entries");
    $stmt->execute();

    $stmt = $mysqli->prepare("ALTER TABLE entries AUTO_INCREMENT = 1");
    $stmt->execute();
    $mysqli->close();

    echo htmlspecialchars(getLocalizedText("fixtures-erased", $language)) . "<br>";
}

$services = read_service();
$service_ids = [];

if ($services) {
    foreach($services as $service) {
        if (!in_array($service["ID"], $service_ids)) {
            $service_ids[] = $service["ID"];
        }
    }

    $faker = Faker\Factory::create();

    $fixtures = [];

    for ($i = 0; $i < $FIXTURES_COUNT; $i++) {
        $fixtures[] = [
            'customer_name' => $faker->name(),
            'service_id' => $faker->randomElement($service_ids),
            'amount' => $faker->numberBetween(1, 5),
            'comment' => $faker->optional($weight = 0.25)->realText($faker->numberBetween(10, 60)),
        ];
    }

    $mysqli = openMysqli();
    for ($i = 0; $i < $FIXTURES_COUNT; $i++) {
        $temp_stmt = $mysqli->prepare("INSERT INTO entries (customer_name, service_id, amount, comment) VALUES (?, ?, ?, ?);");
        $temp_stmt->bind_param("siis", 
        $fixtures[$i]["customer_name"], 
        $fixtures[$i]["service_id"],
        $fixtures[$i]["amount"],
        $fixtures[$i]["comment"]);
        $temp_stmt->execute();
    }
    $mysqli->close();

    echo $FIXTURES_COUNT . htmlspecialchars(getLocalizedText("fixtures-generated", $language));
}
else {
    echo "No services in database - unable to create fixtures.";
}
?>
<?php applyStyle(); ?>
<br><a href="admin-menu.php"><button><?php echo htmlspecialchars(getLocalizedText("to-admin-menu", $language)); ?></button></a>
