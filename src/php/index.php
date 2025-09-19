<?php
$result = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // 入店・退店の日時
    $enterTime = new DateTimeImmutable($_POST['enter']);
    $exitTime = new DateTimeImmutable($_POST['exit']);

    // 滞在時間
    $stayMinutes = ($exitTime->getTimestamp() - $enterTime->getTimestamp()) / 60;

    // 料金
    if ($stayMinutes <= 60) {
        $price = 500; // 1時間まで
    } elseif ($stayMinutes <= 180) {
        $price = 800; // 3時間パック
    } elseif ($stayMinutes <= 300) {
        $price = 1500; // 5時間パック
    } elseif ($stayMinutes <= 480) {
        $price = 1900; // 8時間パック
    } else {
        // 10分ごとに100円超過
        $price = 1900 + ceil(($stayMinutes - 480) / 10) * 100;
    }

    // 税抜き・税込み
    $taxRate = 0.1;
    $taxIncluded = $price + ($price * $taxRate);

    $result = "税抜価格: {$price} 円<br>"
        . "税込価格: {$taxIncluded} 円";
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>料金計算</title>
</head>

<body>
    <h1>料金計算フォーム</h1>
    <form action="" method="post">
        入店日時: <input type="datetime-local" name="enter" required><br>
        退店日時: <input type="datetime-local" name="exit" required><br>
        <button type="submit">計算</button>
    </form>

    <p><?= $result ?></p>
</body>

</html>