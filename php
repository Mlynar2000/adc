<?php
// Konfigurácia databázy
$db_host = "localhost";    // Hostiteľ (napr. 127.0.0.1 alebo localhost)
$db_user = "username";     // Používateľské meno databázy
$db_pass = "password";     // Heslo do databázy
$db_name = "database";     // Názov databázy

// Kontrola, či bol parameter 'adc' odoslaný
if (isset($_GET['adc'])) {
    $adc = intval($_GET['adc']); // Získanie hodnoty ADC ako celé číslo

    // Pripojenie k databáze
    $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

    // Kontrola pripojenia
    if ($conn->connect_error) {
        die("Pripojenie zlyhalo: " . $conn->connect_error);
    }

    // Uloženie hodnoty ADC do tabuľky
    $sql = "INSERT INTO adc_values (value, timestamp) VALUES (?, NOW())";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("i", $adc);
        if ($stmt->execute()) {
            echo "Hodnota ADC úspešne uložená: " . $adc;
        } else {
            echo "Chyba pri ukladaní: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Chyba pri príprave SQL dotazu: " . $conn->error;
    }

    // Zatvorenie pripojenia
    $conn->close();
} else {
    echo "Žiadna hodnota ADC nebola poslaná.";
}
?>
