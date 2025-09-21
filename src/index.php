<?php
include 'db.php';

$tableCreationQuery = "
    CREATE TABLE IF NOT EXISTS hello_world (
        id INT AUTO_INCREMENT PRIMARY KEY,
        message VARCHAR(255) NOT NULL
    );
";

$insertQuery = "
    INSERT INTO hello_world (message)
    SELECT 'Hello, World!' 
    WHERE NOT EXISTS (SELECT 1 FROM hello_world WHERE message = 'Hello, World!');
";

try {
    $pdo->exec($tableCreationQuery);

    $pdo->exec($insertQuery);

    // Fetch all entries from the hello_world table
    $stmt = $pdo->query("SELECT * FROM hello_world");

    // Check if there are any rows
    if ($stmt->rowCount() > 0) {
        echo "<h1>Messages from Database:</h1>";
        echo "<ul>";
        
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<li>" . htmlspecialchars($row['message']) . "</li>";
        }
        
        echo "</ul>";
    } else {
        echo "<p>No messages found in the database.</p>";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
