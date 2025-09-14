<?php
session_start();

// 📌 بيانات تسجيل الدخول للأونر
$owner_username = "Saed_SR";
$owner_password = "qwertyuiop[]asdfghjkl;'\\";

// 📌 إعداد الاتصال بقاعدة البيانات
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "supermc";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("فشل الاتصال بقاعدة البيانات: " . $conn->connect_error);
}

// 📌 تسجيل دخول
if (isset($_POST['login'])) {
    if ($_POST['username'] === $owner_username && $_POST['password'] === $owner_password) {
        $_SESSION['owner'] = true;
    } else {
        echo "<p style='color:red'>❌ خطأ في تسجيل الدخول</p>";
    }
}

// 📌 تسجيل خروج
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: index.php");
    exit;
}

// 📌 حفظ التقديم
if (isset($_POST['apply'])) {
    $name = $_POST['name'];
    $age = $_POST['age'];
    $country = $_POST['country'];
    $whyChoose = $_POST['whyChoose'];
    $experience = $_POST['experience'];
    $benefit = $_POST['benefit'];
    $discord = $_POST['discord'];
    $mcname = $_POST['mcname'];
    $whyHere = $_POST['whyHere'];

    $sql = "INSERT INTO applications (name, age, country, whyChoose, experience, benefit, discord, mcname, whyHere) 
            VALUES ('$name','$age','$country','$whyChoose','$experience','$benefit','$discord','$mcname','$whyHere')";

    if ($conn->query($sql) === TRUE) {
        echo "<p style='color:green'>✅ تم إرسال التقديم بنجاح!</p>";
    } else {
        echo "<p style='color:red'>❌ خطأ: " . $conn->error . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="ar">
<head>
<meta charset="UTF-8">
<title>SuperMC Staff Application</title>
<style>
    body {
        font-family: Arial, sans-serif;
        background: linear-gradient(to bottom, #ff0000, #550000);
        color: white;
        text-align: center;
    }
    .container {
        width: 60%;
        margin: auto;
        padding: 20px;
    }
    input, textarea {
        width: 80%;
        padding: 10px;
        margin: 5px;
        border: none;
        border-radius: 5px;
    }
    button {
        padding: 10px 20px;
        border: none;
        background: blue;
        color: white;
        border-radius: 5px;
        cursor: pointer;
    }
    .application {
        background: #222;
        margin: 10px;
        padding: 15px;
        border-radius: 10px;
        text-align: left;
    }
</style>
</head>
<body>

<div class="container">
<?php if (!isset($_SESSION['owner'])): ?>
    <h1>📋 نموذج التقديم على ستاف SuperMC</h1>
    <form method="POST">
        <input type="text" name="name" placeholder="اسمك" required><br>
        <input type="number" name="age" placeholder="عمرك" required><br>
        <input type="text" name="country" placeholder="بلدك" required><br>
        <textarea name="whyChoose" placeholder="لماذا نختارك؟" required></textarea><br>
        <textarea name="experience" placeholder="ايش خبراتك؟" required></textarea><br>
        <textarea name="benefit" placeholder="ايش تفيدنا؟" required></textarea><br>
        <input type="text" name="discord" placeholder="اسمك في ديسكورد" required><br>
        <input type="text" name="mcname" placeholder="اسمك في ماين كرافت" required><br>
        <textarea name="whyHere" placeholder="ليش تبي تقدم هنا؟" required></textarea><br>
        <button type="submit" name="apply">إرسال التقديم</button>
    </form>

    <hr>
    <h2>🔑 تسجيل دخول الأونر</h2>
    <form method="POST">
        <input type="text" name="username" placeholder="اسم المستخدم"><br>
        <input type="password" name="password" placeholder="كلمة المرور"><br>
        <button type="submit" name="login">تسجيل دخول</button>
    </form>

<?php else: ?>
    <h1>👑 لوحة تحكم الأونر</h1>
    <a href="index.php?logout=1" style="color:yellow">تسجيل خروج</a>
    <hr>
    <?php
    $result = $conn->query("SELECT * FROM applications ORDER BY id DESC");
    while($row = $result->fetch_assoc()) {
        echo "<div class='application'>";
        echo "<b>الاسم:</b> " . $row['name'] . "<br>";
        echo "<b>العمر:</b> " . $row['age'] . "<br>";
        echo "<b>البلد:</b> " . $row['country'] . "<br>";
        echo "<b>الديسكورد:</b> " . $row['discord'] . "<br>";
        echo "<b>ماين كرافت:</b> " . $row['mcname'] . "<br>";
        echo "<b>لماذا نختارك:</b> " . $row['whyChoose'] . "<br>";
        echo "<b>خبراتك:</b> " . $row['experience'] . "<br>";
        echo "<b>تفيدنا بـ:</b> " . $row['benefit'] . "<br>";
        echo "<b>ليش هنا:</b> " . $row['whyHere'] . "<br>";
        echo "</div>";
    }
    ?>
<?php endif; ?>
</div>

</body>
</html>
