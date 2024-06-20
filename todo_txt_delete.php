<?php
$str = "";
$array = [];

$file = fopen('data/todo.txt', 'r');
flock($file, LOCK_EX);

if ($file) {
  while ($line = fgets($file)) {
    $lineArray = explode(" ", $line, 4); // 4つ目の要素で区切る
    // 各要素の取得と空白の処理
    $age = isset($lineArray[0]) ? (int)$lineArray[0] : "";
    $happiness = isset($lineArray[1]) ? (int)$lineArray[1] : "";
    $title = isset($lineArray[2]) ? $lineArray[2] : "";
    $description = isset($lineArray[3]) ? str_replace("\n", "", $lineArray[3]) : "";

    $array[] = [
      "age" => $age,
      "happiness" => $happiness,
      "title" => $title,
      "description" => $description,
      "line" => $line // 元の行データを保持
    ];
  }
}
flock($file, LOCK_UN);
fclose($file);
?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>エントリの消去</title>
  <link rel="stylesheet" href="style.css">
</head>

<body>
  <div class="container">
    <h2>エントリの消去</h2>
    <ul>
      <?php foreach ($array as $entry): ?>
        <li>
          年齢: <?= $entry['age'] ?>, 幸福度: <?= $entry['happiness'] ?>, タイトル: <?= $entry['title'] ?>, 出来事: <?= $entry['description'] ?>
          <form action="todo_txt_delete_confirm.php" method="post" style="display:inline;">
            <input type="hidden" name="line" value="<?= htmlspecialchars($entry['line']) ?>">
            <button type="submit">消去</button>
          </form>
        </li>
      <?php endforeach; ?>
    </ul>
    <a href="todo_txt_input.php" class="button">入力画面に戻る</a>
  </div>
</body>

</html>

