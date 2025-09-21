<?php
// Include the database connection
include 'db.php';

// SQL to create table if it doesn't exist
$tableCreationQuery = "
    CREATE TABLE IF NOT EXISTS hello_world (
        id INT AUTO_INCREMENT PRIMARY KEY,
        message VARCHAR(255) NOT NULL
    );
";

// SQL to insert the default message if the table is empty
$insertQuery = "
    INSERT INTO hello_world (message)
    SELECT 'Hello, World!' 
    WHERE NOT EXISTS (SELECT 1 FROM hello_world WHERE message = 'Hello, World!');
";

// Try to execute the creation query
try {
    // Create table if it doesn't exist
    $pdo->exec($tableCreationQuery);

    // Insert the message if it doesn't already exist
    $pdo->exec($insertQuery);

    // Fetch the message from the database
    $stmt = $pdo->query("SELECT message FROM hello_world WHERE id = 1");
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    // Display the message
    if ($row) {
        echo "<h1>Message from Database:</h1>";
        echo "<p>" . $row['message'] . "</p>";
    } else {
        echo "<p>No message found in the database.</p>";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
