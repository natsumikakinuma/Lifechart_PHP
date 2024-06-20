<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $lineToDelete = $_POST['line'] ?? '';
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>エントリの消去確認</title>
  <link rel="stylesheet" href="style.css">
</head>

<body>
  <div class="container">
    <h2>エントリの消去確認</h2>
    <p>本当に以下のエントリを消去しますか？</p>
    <p><?= htmlspecialchars($lineToDelete) ?></p>
    <form action="todo_txt_delete_action.php" method="post" style="display:inline;">
      <input type="hidden" name="line" value="<?= htmlspecialchars($lineToDelete) ?>">
      <button type="submit">はい、消去します</button>
    </form>
    <form action="todo_txt_delete.php" method="get" style="display:inline;">
      <button type="submit">いいえ、戻ります</button>
    </form>
  </div>
</body>

</html>
