 <?php
session_start();

if (!isset($_POST['id'])) {
    die("No ID provided");
}

$id = $_POST['id'];
$filename = 'quotes.json';

$raw = file_get_contents($filename);
if ($raw === false) {
    die("Could not read $filename");
}

$quotes = json_decode($raw, true);
if (!is_array($quotes)) {
    die("Invalid JSON in $filename");
}

$quotes = array_filter($quotes, fn($quote) => $quote['id'] != $id);

$result = file_put_contents($filename, json_encode(array_values($quotes), JSON_PRETTY_PRINT));
if ($result === false) {
    die("Failed to write to $filename");
}

header("Location: index.php");
exit;