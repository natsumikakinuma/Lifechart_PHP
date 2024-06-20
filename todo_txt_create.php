<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$successMessage = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // フォームからデータを取得
    $age = $_POST['age'] ?? '';
    $happiness = $_POST['happiness'] ?? '';
    $title = $_POST['title'] ?? '';
    $description = $_POST['description'] ?? '';

    // データをフォーマット
    $line = "{$age} {$happiness} {$title} {$description}\n";

    // ファイルに書き込み
    $dataFile = 'data/todo.txt';

    // ディレクトリとファイルの権限を確認
    if (!is_dir('data')) {
        mkdir('data', 0755, true);
    }
    
    $file = fopen($dataFile, 'a');
    if ($file) {
        if (flock($file, LOCK_EX)) {
            fwrite($file, $line);
            flock($file, LOCK_UN);
            $successMessage = "データが書き込まれました。";
        } else {
            echo "ファイルをロックできませんでした。\n";
        }
        fclose($file);
    } else {
        echo "ファイルを開けませんでした。\n";
    }
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ライフチャート入力</title>
  <link rel="stylesheet" href="style.css">
</head>

<body>
  <div class="container">
    <?php if ($successMessage): ?>
      <p><?= htmlspecialchars($successMessage) ?></p>
    <?php endif; ?>
    <form action="todo_txt_create.php" method="post">
      <fieldset>
        <legend>ライフチャート入力</legend>
        <label for="age">年齢:</label>
        <input type="number" id="age" name="age" min="1" max="50" required><br>
        <label for="happiness">幸福度 (-5から5):</label>
        <input type="number" id="happiness" name="happiness" min="-5" max="5" required><br>
        <label for="title">タイトル:</label>
        <input type="text" id="title" name="title" required><br>
        <label for="description">出来事:</label>
        <textarea id="description" name="description" required></textarea><br>
        <input type="submit" value="送信">
      </fieldset>
    </form>
    <a href="todo_txt_read.php" class="button">ライフチャートを表示</a>
    <a href="todo_txt_delete.php" class="button">エントリを消去</a>
  </div>
</body>

</html>

