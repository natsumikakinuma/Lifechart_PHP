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
  </div>
</body>

</html>
