<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "StudentManagement";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Помилка підключення: " . $conn->connect_error);
}

// Видалення студента по id, якщо передано
if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);
    $stmt = $conn->prepare("DELETE FROM Students WHERE id = ?");
    $stmt->bind_param("i", $delete_id);
    $stmt->execute();
    $stmt->close();
    header("Location: list_students.php");
    exit;
}

// Вибірка усіх студентів
$sql = "SELECT * FROM Students ORDER BY id DESC";
$result = $conn->query($sql);

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Список студентів</title>
</head>
<body>
    <h2>Список студентів</h2>

    <a href="add_student.php">Додати нового студента</a><br><br>

    <table border="1" cellpadding="8" cellspacing="0">
        <tr>
            <th>ID</th>
            <th>Ім'я</th>
            <th>Вік</th>
            <th>Оцінка</th>
            <th>Дія</th>
        </tr>
        <?php if ($result && $result->num_rows > 0): ?>
            <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= htmlspecialchars($row['name']) ?></td>
                    <td><?= $row['age'] ?></td>
                    <td><?= htmlspecialchars($row['grade']) ?></td>
                    <td>
                        <a href="?delete_id=<?= $row['id'] ?>" onclick="return confirm('Видалити студента?');">Видалити</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="5">Студентів ще немає.</td></tr>
        <?php endif; ?>
    </table>

</body>
</html>
