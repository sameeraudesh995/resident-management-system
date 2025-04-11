<?php include 'config.php'; ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Delete Resident</title>
        <style>
            body { font-family: Arial, sans-serif; margin: 20px; }
            .container { max-width: 600px; margin: 0 auto; text-align: center; }
            .confirmation-box { background: #f8f8f8; border: 1px solid #ddd; padding: 20px; border-radius: 5px; margin: 20px 0; }
            .btn { padding: 10px 15px; margin: 0 10px; text-decoration: none; border-radius: 4px; color: white; }
            .confirm-btn { background-color: #f44336; }
            .cancel-btn { background-color: #2196F3; }
        </style>
    </head>
    <body>
    <div class="container">
        <h1>Delete Resident</h1>

        <?php
        // Get resident ID from URL
        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;

        // Fetch resident name
        $sql = "SELECT full_name FROM residents WHERE id = $id";
        $result = $conn->query($sql);

        if ($result->num_rows == 0) {
            echo "<p>Resident not found.</p>";
            echo "<a href='index.php' class='btn cancel-btn'>Back to list</a>";
            exit();
        }

        $resident = $result->fetch_assoc();

        // Handle deletion confirmation
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['confirm'])) {
            $delete_sql = "DELETE FROM residents WHERE id = $id";

            if ($conn->query($delete_sql) === TRUE) {
                echo "<p style='color: green;'>Resident deleted successfully!</p>";
                echo "<a href='index.php' class='btn cancel-btn'>Back to list</a>";
                exit();
            } else {
                echo "<p style='color: red;'>Error deleting resident: " . $conn->error . "</p>";
            }
        }
        ?>

        <div class="confirmation-box">
            <p>Are you sure you want to delete the resident:</p>
            <h3><?php echo htmlspecialchars($resident['full_name']); ?></h3>
            <p>This action cannot be undone.</p>

            <form method="POST" action="">
                <button type="submit" name="confirm" class="btn confirm-btn">Confirm Delete</button>
                <a href="index.php" class="btn cancel-btn">Cancel</a>
            </form>
        </div>
    </div>
    </body>
    </html>
<?php $conn->close(); ?>