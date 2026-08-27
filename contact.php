<?php

require_once "config/database.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $full_name = $_POST["full_name"] ?? '';
    $adresse_email = $_POST["adresse_email"] ?? '';
    $message_TEXT = $_POST["message_TEXT"] ?? '';

    if (empty($full_name) || empty($adresse_email) || empty($message_TEXT)) {
        echo "Veuillez remplir tous les champs.";
        exit;
    }

    $sql = "INSERT INTO contact (full_name, adresse_email, message_TEXT)
            VALUES (:full_name, :adresse_email, :message_TEXT)";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        ':full_name' => $full_name,
        ':adresse_email' => $adresse_email,
        ':message_TEXT' => $message_TEXT
    ]);

   header('location:index.php');
}
?>