<?php include 'config.php'; ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Resident Management System</title>
        <style>
            body { font-family: Arial, sans-serif; margin: 20px; }
            .container { max-width: 1200px; margin: 0 auto; }
            .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
            table { width: 100%; border-collapse: collapse; margin-top: 20px; }
            th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
            th { background-color: #f2f2f2; }
            tr:nth-child(even) { background-color: #f9f9f9; }
            .action-btn { padding: 5px 10px; margin: 0 5px; text-decoration: none; border-radius: 3px; }
            .edit-btn { background-color: #4CAF50; color: white; }
            .delete-btn { background-color: #f44336; color: white; }
            .add-btn { background-color: #2196F3; color: white; padding: 10px 15px; border-radius: 3px;}
            .search-form { margin-bottom: 20px; background: #f2f2f2; padding: 15px; border-radius: 5px; }
            .form-group { margin-bottom: 10px; }
            label { display: inline-block; width: 150px; }
            input[type="text"], input[type="date"], input[type="email"], input[type="tel"], select, textarea {
                padding: 8px; width: 300px; border: 1px solid #ddd; border-radius: 4px;
            }
            button { padding: 8px 15px; background-color: #16C47F; color: white; border: none; border-radius: 4px; cursor: pointer; }
            button:hover { background-color: #007F73; }
            .btn-reset{background-color: #F0A04B;}
            .btn-reset:hover{background-color: #FF9B17;}
        </style>
    </head>
    <body>
    <div class="container">
        <div class="header">
            <h1>Resident Management System</h1>
            <a href="add_resident.php" class="add-btn">Add New Resident</a>
        </div>

        <div class="search-form">
            <h2>Search Residents</h2>
            <form method="GET" action="">
                <div class="form-group">
                    <label for="search_name">Full Name:</label>
                    <input type="text" id="search_name" name="search_name" placeholder="Enter full or partial name">
                </div>
                <div class="form-group">
                    <label for="search_address">Address:</label>
                    <input type="text" id="search_address" name="search_address" placeholder="Enter full or partial address">
                </div>
                <div class="form-group">
                    <label for="search_nic">NIC Number:</label>
                    <input type="text" id="search_nic" name="search_nic" placeholder="Enter NIC number">
                </div>
                <button class="btn-submit" type="submit">Search</button>
                <button class="btn-reset" type="button" onclick="window.location.href='index.php'">Reset</button>
            </form>
        </div>

        <?php
        // Search functionality
        $search_name = isset($_GET['search_name']) ? $_GET['search_name'] : '';
        $search_address = isset($_GET['search_address']) ? $_GET['search_address'] : '';
        $search_nic = isset($_GET['search_nic']) ? $_GET['search_nic'] : '';

        $sql = "SELECT * FROM residents WHERE 1=1";
        if (!empty($search_name)) {
            $sql .= " AND full_name LIKE '%" . $conn->real_escape_string($search_name) . "%'";
        }
        if (!empty($search_address)) {
            $sql .= " AND address LIKE '%" . $conn->real_escape_string($search_address) . "%'";
        }
        if (!empty($search_nic)) {
            $sql .= " AND nic LIKE '%" . $conn->real_escape_string($search_nic) . "%'";
        }
        $sql .= " ORDER BY full_name";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo "<h2>Search Results</h2>";
            echo "<table>";
            echo "<tr><th>ID</th><th>Full Name</th><th>DOB</th><th>NIC</th><th>Address</th><th>Phone</th><th>Actions</th></tr>";

            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['id'] . "</td>";
                echo "<td>" . htmlspecialchars($row['full_name']) . "</td>";
                echo "<td>" . $row['dob'] . "</td>";
                echo "<td>" . htmlspecialchars($row['nic']) . "</td>";
                echo "<td>" . htmlspecialchars(substr($row['address'], 0, 30)) . "...</td>";
                echo "<td>" . htmlspecialchars($row['phone']) . "</td>";
                echo "<td>";
                echo "<a href='edit_resident.php?id=" . $row['id'] . "' class='action-btn edit-btn'>Edit</a>";
                echo "<a href='delete_resident.php?id=" . $row['id'] . "' class='action-btn delete-btn'>Delete</a>";
                echo "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<p>No residents found matching your criteria.</p>";
        }
        ?>
    </div>
    </body>
    </html>
<?php $conn->close(); ?>