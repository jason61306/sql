<?php
$host = "startrek_payroll_mysql";
$db_name = "payroll";
$db_username = "root";
$db_password = "sploitme";
$charset = "utf8mb4";

$dsn = "mysql:host=$host;dbname=$db_name;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];
try {
    $pdo = new PDO($dsn, $db_username, $db_password, $options);
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}
?>

<?php
if (!isset($_POST['s'])) {
?>
    <center>
        <form action="" method="post">
            <h2>薪資查詢系統登入頁面</h2>
            <table style="border-radius: 25px; border: 2px solid black; padding: 20px;">
                <tr>
                    <td>帳號</td>
                    <td><input type="text" name="user"></td>
                </tr>
                <tr>
                    <td>密碼</td>
                    <td><input type="password" name="password"></td>
                </tr>
                <tr>
                    <td><input type="submit" value="登入" name="s">
                </tr>
            </table>
        </form>
    </center>
<?php
}
?>

<?php
if ($_POST) {
    $user = $_POST['user'];
    error_log("USERNAME:" . $user);
    $pass = $_POST['password'];
    error_log("PASSWORD:" . $pass);
    $stmt = $pdo->prepare("SELECT username, salary From users WHERE username = ? and password = ?");

    if ($stmt->execute([$user, $pass])) {
        echo "<center>";
        echo "<h2>Welcome, " . $user . "</h2><br>";
        echo "<table style='border-radius: 25px; border: 2px solid black;' cellspacing=30>";
        echo "<tr><th>帳號</th><th>薪資</th></tr>";
        if ($keys = $stmt->fetch()) {
            echo "<tr>";
            foreach ($keys as $key) {
                echo "<td>" . $key . "</td>";
            }
            echo "</tr>\n";
        }
    }
    echo "</table></center>";
}
?>