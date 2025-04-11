<?php include 'config.php'; ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Edit Resident</title>
        <style>
            body { font-family: Arial, sans-serif; margin: 20px; }
            .container { max-width: 800px; margin: 0 auto; }
            .form-group { margin-bottom: 15px; }
            label { display: inline-block; width: 150px; font-weight: bold; }
            input[type="text"], input[type="date"], input[type="email"], input[type="tel"], select, textarea {
                padding: 8px; width: 300px; border: 1px solid #ddd; border-radius: 4px;
            }
            button { padding: 10px 15px; background-color: #4CAF50; color: white; border: none; border-radius: 4px; cursor: pointer; }
            button:hover { background-color: #45a049; }
            .error { color: red; margin-left: 160px; }
            .back-btn { background-color: #2196F3; margin-right: 10px; }
            .delete-btn { background-color: #f44336; }
        </style>
    </head>
    <body>
    <div class="container">
        <h1>Edit Resident</h1>

        <?php
        // Get resident ID from URL
        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;

        // Fetch resident data
        $sql = "SELECT * FROM residents WHERE id = $id";
        $result = $conn->query($sql);

        if ($result->num_rows == 0) {
            echo "<p>Resident not found.</p>";
            echo "<a href='index.php'>Back to list</a>";
            exit();
        }

        $resident = $result->fetch_assoc();

        // Form submission handling
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $errors = [];

            // Validate inputs
            if (empty($_POST['full_name'])) {
                $errors['full_name'] = "Full name is required";
            }
            if (empty($_POST['dob'])) {
                $errors['dob'] = "Date of birth is required";
            }
            if (empty($_POST['nic'])) {
                $errors['nic'] = "NIC is required";
            } elseif (!preg_match('/^[0-9]{9}[VvXx]$/', $_POST['nic'])) {
                $errors['nic'] = "Invalid NIC format (should be 9 digits followed by V, X, or v, x)";
            }
            if (empty($_POST['address'])) {
                $errors['address'] = "Address is required";
            }
            if (empty($_POST['phone'])) {
                $errors['phone'] = "Phone number is required";
            }
            if (empty($_POST['email'])) {
                $errors['email'] = "Email is required";
            } elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                $errors['email'] = "Invalid email format";
            }
            if (empty($_POST['gender'])) {
                $errors['gender'] = "Gender is required";
            }

            if (empty($errors)) {
                // Prepare and bind
                $stmt = $conn->prepare("UPDATE residents SET full_name=?, dob=?, nic=?, address=?, phone=?, email=?, occupation=?, gender=? WHERE id=?");
                $stmt->bind_param("ssssssssi", $full_name, $dob, $nic, $address, $phone, $email, $occupation, $gender, $id);

                // Set parameters
                $full_name = $_POST['full_name'];
                $dob = $_POST['dob'];
                $nic = $_POST['nic'];
                $address = $_POST['address'];
                $phone = $_POST['phone'];
                $email = $_POST['email'];
                $occupation = $_POST['occupation'];
                $gender = $_POST['gender'];

                // Execute
                if ($stmt->execute()) {
                    echo "<p style='color: green;'>Resident updated successfully!</p>";
                } else {
                    echo "<p style='color: red;'>Error: " . $stmt->error . "</p>";
                }
                $stmt->close();
            }
        }
        ?>

        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?id=" . $id); ?>">
            <div class="form-group">
                <label for="full_name">Full Name:</label>
                <input type="text" id="full_name" name="full_name" value="<?php echo htmlspecialchars($resident['full_name']); ?>" required>
                <?php if (isset($errors['full_name'])) echo "<div class='error'>" . $errors['full_name'] . "</div>"; ?>
            </div>

            <div class="form-group">
                <label for="dob">Date of Birth:</label>
                <input type="date" id="dob" name="dob" value="<?php echo htmlspecialchars($resident['dob']); ?>" required>
                <?php if (isset($errors['dob'])) echo "<div class='error'>" . $errors['dob'] . "</div>"; ?>
            </div>

            <div class="form-group">
                <label for="nic">NIC Number:</label>
                <input type="text" id="nic" name="nic" value="<?php echo htmlspecialchars($resident['nic']); ?>" required>
                <?php if (isset($errors['nic'])) echo "<div class='error'>" . $errors['nic'] . "</div>"; ?>
            </div>

            <div class="form-group">
                <label for="address">Address:</label>
                <textarea id="address" name="address" rows="3" required><?php echo htmlspecialchars($resident['address']); ?></textarea>
                <?php if (isset($errors['address'])) echo "<div class='error'>" . $errors['address'] . "</div>"; ?>
            </div>

            <div class="form-group">
                <label for="phone">Phone Number:</label>
                <input type="tel" id="phone" name="phone" value="<?php echo htmlspecialchars($resident['phone']); ?>" required>
                <?php if (isset($errors['phone'])) echo "<div class='error'>" . $errors['phone'] . "</div>"; ?>
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($resident['email']); ?>" required>
                <?php if (isset($errors['email'])) echo "<div class='error'>" . $errors['email'] . "</div>"; ?>
            </div>

            <div class="form-group">
                <label for="occupation">Occupation:</label>
                <input type="text" id="occupation" name="occupation" value="<?php echo htmlspecialchars($resident['occupation']); ?>">
            </div>

            <div class="form-group">
                <label for="gender">Gender:</label>
                <select id="gender" name="gender" required>
                    <option value="Male" <?php echo ($resident['gender'] == 'Male') ? 'selected' : ''; ?>>Male</option>
                    <option value="Female" <?php echo ($resident['gender'] == 'Female') ? 'selected' : ''; ?>>Female</option>
                    <option value="Other" <?php echo ($resident['gender'] == 'Other') ? 'selected' : ''; ?>>Other</option>
                </select>
                <?php if (isset($errors['gender'])) echo "<div class='error'>" . $errors['gender'] . "</div>"; ?>
            </div>

            <div class="form-group">
                <button type="button" class="back-btn" onclick="window.location.href='index.php'">Back</button>
                <button type="submit">Update Resident</button>
                <button type="button" class="delete-btn" onclick="window.location.href='delete_resident.php?id=<?php echo $id; ?>'">Delete Resident</button>
            </div>
        </form>
    </div>
    </body>
    </html>
<?php $conn->close(); ?>