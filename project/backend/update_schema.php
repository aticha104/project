<?php
require_once __DIR__ . "/db.php";

try {
    // 1. Add end_time and location to meetings table
    $result = $pdo->query("SHOW COLUMNS FROM meetings LIKE 'end_time'");
    if ($result->rowCount() == 0) {
        $pdo->exec("ALTER TABLE meetings ADD COLUMN end_time TIME AFTER meeting_time");
        echo "Column 'end_time' added.\n";
    }

    $result = $pdo->query("SHOW COLUMNS FROM meetings LIKE 'meeting_at'");
    if ($result->rowCount() == 0) {
        $pdo->exec("ALTER TABLE meetings ADD COLUMN meeting_at VARCHAR(255) AFTER end_time");
        echo "Column 'meeting_at' added.\n";
    }

    // 2. Create participants table
    $sql = "CREATE TABLE IF NOT EXISTS participants (
        id INT AUTO_INCREMENT PRIMARY KEY,
        meeting_id INT NOT NULL,
        name VARCHAR(255) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (meeting_id) REFERENCES meetings(meeting_id) ON DELETE CASCADE,
        INDEX idx_meeting_id (meeting_id)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
    $pdo->exec($sql);
    echo "Table 'participants' created or already exists.\n";

    // 3. Update agendas table schema
    $result = $pdo->query("SHOW COLUMNS FROM agendas LIKE 'meeting_id'");
    if ($result->rowCount() == 0) {
        // Add meeting_id if it doesn't exist
        $pdo->exec("ALTER TABLE agendas ADD COLUMN meeting_id INT AFTER agendas_id");
        echo "Column 'meeting_id' added to 'agendas' table.\n";
        
        // If meeting_title exists, try to migrate data (this is optional but good practice)
        $titleCol = $pdo->query("SHOW COLUMNS FROM agendas LIKE 'meeting_title'");
        if ($titleCol->rowCount() > 0) {
            $pdo->exec("UPDATE agendas a JOIN meetings m ON a.meeting_title = m.meeting_title SET a.meeting_id = m.meeting_id");
            echo "Data migrated from 'meeting_title' to 'meeting_id'.\n";
            // We might not want to drop meeting_title just yet if code depends on it, but ideally we should.
            // keeping it for now to be safe, or drop it? The plan said drop it.
             $pdo->exec("ALTER TABLE agendas DROP COLUMN meeting_title");
             echo "Column 'meeting_title' dropped from 'agendas' table.\n";
        }
    }

    $result = $pdo->query("SHOW COLUMNS FROM agendas LIKE 'agenda_order'");
    if ($result->rowCount() == 0) {
        $pdo->exec("ALTER TABLE agendas ADD COLUMN agenda_order INT AFTER meeting_id");
        echo "Column 'agenda_order' added to 'agendas' table.\n";
    }

    // Add indexes and foreign key if not present
    // Check if column is integer
    //$pdo->exec("ALTER TABLE agendas MODIFY COLUMN meeting_id INT NOT NULL");
    
    // Check if FK exists already (simplified check)
    try {
        $pdo->exec("ALTER TABLE agendas ADD FOREIGN KEY (meeting_id) REFERENCES meetings(meeting_id) ON DELETE CASCADE");
        echo "Foreign key added to 'agendas' table.\n";
    } catch (Exception $e) {
        // FK likely already exists or failed
        echo "FK creation note: " . $e->getMessage() . "\n";
    }

    $result = $pdo->query("SHOW INDEX FROM agendas WHERE Key_name = 'idx_meeting_id'");
    if ($result->rowCount() == 0) {
        $pdo->exec("CREATE INDEX idx_meeting_id ON agendas(meeting_id)");
        echo "Index 'idx_meeting_id' added to 'agendas' table.\n";
    }

} catch (PDOException $e) {
    echo "Error updating database: " . $e->getMessage() . "\n";
}
