<?php
// Налаштування підключення до бази
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "StudentManagement";

// Підключення
$conn = new mysqli($servername, $username, $password, $dbname);

// Перевірка підключення
if ($conn->connect_error) {
    die("Помилка підключення: " . $conn->connect_error);
}

// Обробка відправки форми
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name'] ?? '');
    $age = intval($_POST['age'] ?? 0);
    $grade = trim($_POST['grade'] ?? '');

    if ($name && $age > 0 && $grade) {
        $stmt = $conn->prepare("INSERT INTO Students (name, age, grade) VALUES (?, ?, ?)");
        $stmt->bind_param("sis", $name, $age, $grade);
        $stmt->execute();
        $stmt->close();
        $message = "Студента додано!";
    } else {
        $message = "Будь ласка, заповніть всі поля коректно.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Додати студента</title>
</head>
<body>
    <h2>Додати нового студента</h2>

    <?php if (!empty($message)) echo "<p><b>$message</b></p>"; ?>

    <form method="post" action="">
        Ім'я: <input type="text" name="name" required><br><br>
        Вік: <input type="number" name="age" required min="1"><br><br>
        Оцінка: <input type="text" name="grade" required><br><br>
        <input type="submit" value="Додати">
    </form>

    <br>
    <a href="list_students.php">Переглянути список студентів</a>
</body>
</html>
