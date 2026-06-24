<?php
// Check if the message is set in the URL
if (isset($_GET['message'])) {
    $message = htmlspecialchars($_GET['message']);
    echo "<h2>$message</h2>"; // Display the message
} else {
    echo "<h2>Welcome! Your registration was successful.</h2>";
}
?>
