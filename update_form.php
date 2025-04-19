<?php
$host = "localhost";
$username = "thevizji_formbuilder";
$password = "formbuilder@2025";
$database = "thevizji_formbuilder";

$pdo = new PDO("mysql:host=localhost;dbname=thevizji_formbuilder", "thevizji_formbuilder", "formbuilder@2025");

$id = 27;  // Hardcoded ID for update

$fields = array_keys($_POST);
$setString = implode(", ", array_map(fn($field) => "$field = :$field", $fields));

$sql = "UPDATE form_configurations SET $setString WHERE id = :id";
$stmt = $pdo->prepare($sql);

$_POST['id'] = $id;  
if ($stmt->execute($_POST)) {
    echo json_encode(['success' => true, 'message' => '✅ Form updated successfully!']);
} else {
    echo json_encode(['success' => false, 'message' => '❌ Update failed!']);
}
?>
