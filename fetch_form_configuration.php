<?php

$pdo = new PDO("mysql:host=localhost;dbname=thevizji_formbuilder", "thevizji_formbuilder", "formbuilder@2025");
$id = $_GET['id'] ?? 27;
$stmt = $pdo->prepare("SELECT * FROM forms WHERE id = ?");
$stmt->execute([$id]);
$formData = $stmt->fetch(PDO::FETCH_ASSOC);

if ($formData) {
    echo json_encode(['success' => true, 'data' => $formData]);
} else {
    echo json_encode(['success' => false, 'message' => '❌ No form data found!']);
}
?>
