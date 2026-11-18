<?php

if (isset($_POST['submit'])){
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $data  = "$name,$phone";

    if (strlen($name) < 50 && is_numeric($phone))
        file_put_contents("data.txt", $data . PHP_EOL,FILE_APPEND | LOCK_EX);
    else
        echo "<p> لطفا مقادیر رو به درستی وارد کیند</p>";
}

$array_contact = [];
if (file_exists("data.txt")){
    $lines = file_get_contents("data.txt");
    $lines = explode(PHP_EOL, $lines);
    $lines = array_filter($lines , function($line){
        return !empty($line);
    });

    foreach ($lines as $index ){
        $parts = explode(",", $index);
        $user = [
            "name" => $parts[0],
            "phone" => $parts[1]
        ];
        $array_contact[] = $user;
    }
}
if (isset($_POST["delete"])){
        file_put_contents("data.txt" , '');
        header('Location: index.php');
        exit;
}

?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>دفترچه تلفن</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Vazirmatn:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
    <h2>دفترچه تلفن</h2>

    <form method="post" action="" class="add-form">
        <input type="text" name="name"  placeholder="نام" required>
        <input type="tel" name="phone" placeholder="شماره تلفن" required>
        <button type="submit" name="submit">افزودن</button>
    </form>

    <table>
        <thead>
        <tr>
            <th>نام</th>
            <th>شماره تلفن</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        <?php if (isset($array_contact)): ?>
        <?php foreach ($array_contact as $item): ?>
        <tr>
            <td><?php echo htmlspecialchars($item['name']) ?></td>
            <td><?php echo htmlspecialchars($item['phone'])?></td>
        </tr>
        <?php endforeach; ?>
        <?php endif; ?>
        </tbody>
    </table>
    <form method="post" action="" style="margin-top:14px">
        <button type="submit" name="delete" class="bulk-delete">حذف همه مخاطبین</button>
    </form>
</div>

</body>
</html>
