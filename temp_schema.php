<?php
require 'db.php';
$result = mysqli_query($conn, 'DESCRIBE employees');
if (!$result) {
    die('Error describing table: ' . mysqli_error($conn));
}
echo "Users Table Structure:\n";
while ($row = mysqli_fetch_assoc($result)) {
    print_r($row);
}
?>
