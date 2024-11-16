<?php 
require_once "../helper.php";
require_once '../session_reader.php';
require_once '../localizator.php';

function read_entries($debug = false) {
    $mysqli = openMysqli();
    $query_template = "SELECT * FROM entries";
    $stmt = $mysqli->prepare($query_template);
    $stmt->execute();
    $result = $stmt->get_result();

    $data = [];
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    }

    if ($debug) {
        echo json_encode($data);
    }
    else {
        return $data;
    }
}

function read_entries_with_service_name($debug = false) {
    $mysqli = openMysqli();
    $query_template = "SELECT entry_id, customer_name, services.title, amount, comment, services.cost FROM entries 
    JOIN services on entries.service_id = services.ID ORDER BY entry_id";
    $stmt = $mysqli->prepare($query_template);
    $stmt->execute();
    $result = $stmt->get_result();

    $data = [];
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    }

    if ($debug) {
        echo json_encode($data);
    }
    else {
        return $data;
    }
}

function read_user($debug = false, $id = 0) {
    $mysqli = openMysqli();
    $query_template = "SELECT * FROM users";
    if ($id != 0) {
        $query_template = $query_template . " WHERE id = ?";
    }
    $stmt = $mysqli->prepare($query_template);
    if ($id != 0) {
        $stmt->bind_param("i", $id);
    }
    $stmt->execute();
    $result = $stmt->get_result();

    $data = [];
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    }

    if ($debug) {
        echo json_encode($data);
    }
    else {
        return $data;
    }
}

function read_service($debug = false, $id = 0) {
    $mysqli = openMysqli();
    $query_template = "SELECT * FROM services";
    if ($id != 0) {
        $query_template = $query_template . " WHERE id = ?";
    }
    $stmt = $mysqli->prepare($query_template);
    if ($id != 0) {
        $stmt->bind_param("i", $id);
    }
    $stmt->execute();
    $result = $stmt->get_result();

    $data = [];
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    }

    if ($debug) {
        echo json_encode($data);
    }
    else {
        return $data;
    }
}

function create_user($debug = false, $id = 0, $name = "", $password = "") {
    global $language;
    $db = openMysqli();
    $stmt = $db->prepare("INSERT INTO users (name, password) VALUES (?, ?)");

    $hash_password = hash_password($password);

    $stmt->bind_param("ss", $name, $hash_password);
    $stmt->execute();

    echo getLocalizedText("user-create-success", $language);
    $db->close();
}

function create_service($debug = false, $id = 0, $title = "", $description = "", $cost = 0) {
    global $language;
    $db = openMysqli();
    $stmt = $db->prepare("INSERT INTO services (title, description, cost) VALUES (?, ?, ?)");

    $stmt->bind_param("ssi", $title, $description, $cost);
    $stmt->execute();

    echo getLocalizedText("service-create-success", $language);
    $db->close();
}

function update_user($debug = false, $id = 0, $name = "", $password = "") {
    global $language;
    $db = openMysqli();
    $stmt = $db->prepare("UPDATE users SET name = ?, password = ? WHERE id = ?");

    $hash_password = hash_password($password);

    $stmt->bind_param("ssi", $name, $hash_password, $id);
    $stmt->execute();

    echo getLocalizedText("save-success", $language);
    $db->close();
}

function update_service($debug = false, $id = 0, $title = "", $description = "", $cost = 0) {
    global $language;
    $db = openMysqli();
    $stmt = $db->prepare("UPDATE services SET title = ?, description = ?, cost = ? WHERE id = ?");

    $stmt->bind_param("ssii", $title, $description, $cost, $id);
    $stmt->execute();

    echo getLocalizedText("save-success", $language);
    $db->close();
}

function delete_user($debug = false, $id = 0, $name = "", $password = "") {
    global $language;
    $db = openMysqli();
    $stmt = $db->prepare("DELETE FROM users WHERE id = ?");

    $stmt->bind_param("i", $id);
    $stmt->execute();

    echo getLocalizedText("user-delete-success", $language) . "<br>";
    echo "<button onclick='window.location.replace(\"/admin-only/user-list.php\")'>" . getLocalizedText("back", $language) . "</button>";

    $stmt2 = $db->prepare("ALTER TABLE users AUTO_INCREMENT = 1");
    $stmt2->execute();
    $db->close();
}

function delete_service($debug = false, $id = 0, $title = "", $description = "", $cost = 0) {
    global $language;
    $db = openMysqli();
    $stmt = $db->prepare("DELETE FROM services WHERE id = ?");

    $stmt->bind_param("i", $id);
    $stmt->execute();

    echo getLocalizedText("service-delete-success", $language) . "<br>";
    echo "<button onclick='window.location.replace(\"/admin-only/service-list.php\")'>" . getLocalizedText("back", $language) . "</button>";

    $stmt2 = $db->prepare("ALTER TABLE services AUTO_INCREMENT = 1");
    $stmt2->execute();
    $db->close();
}

// для тестирования с постманом
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (isset($_GET["postman"])) {
        $operation = "read";
        $table = $_GET["table"];

        $id = isset($_GET["id"]) ? $_GET["id"] : 0;

        $func_name = $operation . "_" . $table;
        $func_name(true, $id);
    }
}
else if ($_SERVER["REQUEST_METHOD"] == "POST") { 
    if (isset($_POST["postman"])) {
        $operation = "create";
        $table = $_POST["table"];

        $id = isset($_POST["id"]) ? $_POST["id"] : 0;
        $name = isset($_POST["name"]) ? $_POST["name"] : "";
        $password = isset($_POST["password"]) ? $_POST["password"] : "";

        $title = isset($_POST["title"]) ? $_POST["title"] : "";
        $description = isset($_POST["description"]) ? $_POST["description"] : "";
        $cost = isset($_POST["cost"]) ? $_POST["cost"] : "";

        $func_name = $operation . "_" . $table;
        if ($table == "user") {
            $func_name(true, $id, $name, $password);
        }
        else if ($table == "service") {
            $func_name(true, $id, $title, $description, $cost);
        }
    }
}
else if ($_SERVER["REQUEST_METHOD"] == "PUT") {
    parse_str(file_get_contents("php://input"), $_PUT);
    if (isset($_PUT["postman"])) {
        echo "debug";
        $operation = "update";
        $table = $_PUT["table"];

        $id = isset($_PUT["id"]) ? $_PUT["id"] : 0;
        $name = isset($_PUT["name"]) ? $_PUT["name"] : "";
        $password = isset($_PUT["password"]) ? $_PUT["password"] : "";

        $title = isset($_PUT["title"]) ? $_PUT["title"] : "";
        $description = isset($_PUT["description"]) ? $_PUT["description"] : "";
        $cost = isset($_PUT["cost"]) ? $_PUT["cost"] : "";

        $func_name = $operation . "_" . $table;
        if ($table == "user") {
            $func_name(true, $id, $name, $password);
        }
        else if ($table == "service") {
            $func_name(true, $id, $title, $description, $cost);
        }
    }
}
else if ($_SERVER["REQUEST_METHOD"] == "DELETE") {
    parse_str(file_get_contents("php://input"), $_DELETE);
    if (isset($_DELETE["postman"])) {
        echo "debug";
        $operation = "delete";
        $table = $_DELETE["table"];

        $id = isset($_DELETE["id"]) ? $_DELETE["id"] : 0;
        $name = isset($_DELETE["name"]) ? $_DELETE["name"] : "";
        $password = isset($_DELETE["password"]) ? $_DELETE["password"] : "";

        $title = isset($_DELETE["title"]) ? $_DELETE["title"] : "";
        $description = isset($_DELETE["description"]) ? $_DELETE["description"] : "";
        $cost = isset($_DELETE["cost"]) ? $_DELETE["cost"] : "";

        $func_name = $operation . "_" . $table;
        if ($table == "user") {
            $func_name(true, $id, $name, $password);
        }
        else if ($table == "service") {
            $func_name(true, $id, $title, $description, $cost);
        }
    }
}
?>