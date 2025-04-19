<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Builder</title>
</head>
<body>
    <h2>Form Configuration</h2>
    <form action="save_form_config.php?action=create" method="POST" enctype="multipart/form-data">
        <label>First Name Label: <input type="text" name="first_name_label"></label><br>
        <label>First Name Placeholder: <input type="text" name="first_name_placeholder"></label><br>
        <label>Required: <input type="checkbox" name="first_name_required"></label><br>

        <label>Last Name Label: <input type="text" name="last_name_label"></label><br>
        <label>Last Name Placeholder: <input type="text" name="last_name_placeholder"></label><br>
        <label>Required: <input type="checkbox" name="last_name_required"></label><br>

        <label>Email Label: <input type="text" name="email_label"></label><br>
        <label>Email Placeholder: <input type="text" name="email_placeholder"></label><br>
        <label>Required: <input type="checkbox" name="email_required"></label><br>

        <label>Dropdown Label: <input type="text" name="dropdown_label"></label><br>
        <label>Dropdown Placeholder: <input type="text" name="dropdown_placeholder"></label><br>
        <label>Required: <input type="checkbox" name="dropdown_required"></label><br>

        <label>Dropdown Option 1 Name: <input type="text" name="dropdown_option_name1"></label><br>
        <label>Dropdown Option 1 Value: <input type="text" name="dropdown_option_value1"></label><br>
        <label>Dropdown Option 2 Name: <input type="text" name="dropdown_option_name2"></label><br>
        <label>Dropdown Option 2 Value: <input type="text" name="dropdown_option_value2"></label><br>

        <label>Message Label: <input type="text" name="message_label"></label><br>
        <label>Message Placeholder: <input type="text" name="message_placeholder"></label><br>
        <label>Required: <input type="checkbox" name="message_required"></label><br>

        <label>Upload CSV File: <input type="file" name="csv_file_with_data"></label><br>
        
        <button type="submit">Save Configuration</button>
    </form>
</body>
</html>
