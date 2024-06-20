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
  <title>ライフチャート</title>
  <link rel="stylesheet" href="style.css">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
  <div class="container">
    <canvas id="lifeChart"></canvas>
  </div>

  <script>
    document.addEventListener("DOMContentLoaded", function () {
      const info = <?= json_encode($array) ?>;

      // デバッグ用にデータをコンソールに出力
      console.log(info);

      // データセットを準備
      const data = {
        datasets: [{
          label: 'ライフイベント',
          data: info.map(entry => ({
            x: entry.age, // 年齢を使用
            y: entry.happiness,
            title: entry.title,
            description: entry.description,
          })),
          backgroundColor: 'rgba(255, 99, 132, 0.2)',
          borderColor: 'rgba(255, 99, 132, 1)',
          borderWidth: 1,
          pointRadius: 5,
          pointHoverRadius: 10
        }]
      };

      // オプションを設定
      const options = {
        scales: {
          x: {
            title: {
              display: true,
              text: '年齢'
            },
            min: 1,
            max: 50,
            ticks: {
              stepSize: 1
            }
          },
          y: {
            title: {
              display: true,
              text: '幸福度'
            },
            min: -5,
            max: 5,
            ticks: {
              stepSize: 1
            }
          }
        },
        plugins: {
          tooltip: {
            callbacks: {
              label: function (context) {
                const entry = context.raw;
                let label = `年齢: ${entry.x}\n幸福度: ${entry.y}\nタイトル: ${entry.title}\n出来事: ${entry.description}`;
                return label;
              }
            }
          }
        }
      };

      // チャートを描画
      const ctx = document.getElementById('lifeChart').getContext('2d');
      new Chart(ctx, {
        type: 'scatter',
        data: data,
        options: options
      });
    });
  </script>
</body>

</html>

