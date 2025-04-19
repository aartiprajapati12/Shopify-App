<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: application/json');

// Database credentials
$host = "localhost";
$username = "root";
$password = "";
$database = "learn";

$response = ['success' => false, 'message' => '', 'data' => []];

try {
    // ✅ Establish Database Connection
    $conn = new PDO("mysql:host=$host;dbname=$database;charset=utf8", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // ✅ Handle Form Data
        $data = $_POST;

        // ✅ Ensure checkboxes are stored as 1 (checked) or 0 (unchecked)
        $checkbox_fields = ['first_name_required', 'last_name_required', 'email_required', 'dropdown_required', 'message_required'];
        foreach ($checkbox_fields as $field) {
            $data[$field] = isset($data[$field]) ? 1 : 0;
        }

        // ✅ Handle CSV File Upload
        $csvFileName = "";
        $csvData = [];

        if (isset($_FILES['csv_file_with_data']) && $_FILES['csv_file_with_data']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = 'uploads/';
            if (!file_exists($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }

            $fileExt = pathinfo($_FILES['csv_file_with_data']['name'], PATHINFO_EXTENSION);
            if (strtolower($fileExt) !== 'csv') {
                throw new Exception('❌ Only CSV files are allowed.');
            }

            $csvFileName = time() . '_' . basename($_FILES['csv_file_with_data']['name']);
            $targetPath = $uploadDir . $csvFileName;

            if (!move_uploaded_file($_FILES['csv_file_with_data']['tmp_name'], $targetPath)) {
                throw new Exception('❌ File upload failed.');
            }

            // ✅ Read CSV Data After Upload
            if (($handle = fopen($targetPath, "r")) !== FALSE) {
                $isHeader = true; // Skip header row

                while (($row = fgetcsv($handle, 1000, ",")) !== FALSE) {
                    if ($isHeader) {
                        $isHeader = false;
                        continue; // Skip first row
                    }

                    if (count($row) >= 4) { // Ensure row has at least 4 columns
                        $csvData[] = [
                            'category_name' => trim($row[3]), // Category Name is in index [3]
                            'product_name' => trim($row[1]),  // Product Name is in index [1]
                            'price' => floatval($row[2])      // Price is in index [2]
                        ];
                    }
                }
                fclose($handle);
            }

            // ✅ Save File Name to Data Array
            $data['csv_file_with_data'] = $csvFileName;
        }

        // ✅ Insert Form Configuration Data into Database
        $columns = implode(', ', array_keys($data));
        $placeholders = ':' . implode(', :', array_keys($data));
        $sql = "INSERT INTO form_configurations ($columns) VALUES ($placeholders)";
        $stmt = $conn->prepare($sql);
        if ($stmt->execute($data)) {
            $formId = $conn->lastInsertId();
            $response = [
                'success' => true,
                'message' => '🎉 Form and CSV file saved successfully!',
                'form_id' => $formId,
                'csv_file' => $csvFileName
            ];

            // ✅ Insert CSV Data into `csv_data` Table
            if (!empty($csvData)) {
                $csvInsertSql = "INSERT INTO csv_data (form_id, category_name, product_name, price) VALUES (:form_id, :category, :product, :price)";
                $csvStmt = $conn->prepare($csvInsertSql);

                foreach ($csvData as $row) {
                    $csvStmt->execute([
                        ':form_id' => $formId,
                        ':category' => $row['category_name'],
                        ':product' => $row['product_name'],
                        ':price' => $row['price']
                    ]);
                }
            }
        } else {
            throw new Exception('❌ Database insert failed.');
        }
    } else {
        throw new Exception('❌ Invalid request method. Only POST is allowed.');
    }
} catch (PDOException $e) {
    error_log("❌ Database Error: " . $e->getMessage());
    $response['message'] = 'Database error: ' . $e->getMessage();
} catch (Exception $e) {
    error_log("❌ General Error: " . $e->getMessage());
    $response['message'] = $e->getMessage();
}

// ✅ Return JSON Response
echo json_encode($response);
?>
