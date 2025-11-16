<?php
include 'db_connect.php';

echo "<h2>Users in Database:</h2>";
$sql = "SELECT id, username, email, password, full_name FROM users";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table border='1' style='border-collapse: collapse;'>";
    echo "<tr><th>ID</th><th>Username</th><th>Email</th><th>Password Hash</th><th>Full Name</th></tr>";
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["id"] . "</td>";
        echo "<td>" . $row["username"] . "</td>";
        echo "<td>" . $row["email"] . "</td>";
        echo "<td>" . $row["password"] . "</td>";
        echo "<td>" . $row["full_name"] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "No users found in database";
}
$conn->close();
?>