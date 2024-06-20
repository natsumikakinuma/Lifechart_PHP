<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $lineToDelete = $_POST['line'] ?? '';

    if ($lineToDelete) {
        $dataFile = 'data/todo.txt';
        $lines = file($dataFile, FILE_IGNORE_NEW_LINES);

        $newLines = array_filter($lines, function($line) use ($lineToDelete) {
            return trim($line) !== trim($lineToDelete);
        });

        file_put_contents($dataFile, implode("\n", $newLines) . "\n");

        echo "データが削除されました。";
    } else {
        echo "削除する行が指定されていません。";
    }

    // リダイレクト
    header("Location: todo_txt_delete.php");
    exit;
}
?>
