<?php
$host = "startrek_payroll_mysql";
$db_name = "payroll";
$db_username = "root";
$db_password = "sploitme";

$conn = new mysqli($host, $db_username, $db_password, $db_name);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
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
    $sql = "select username, salary from users where username = '$user' and password = '$pass'";
    error_log("QUERY:" . $sql);

    if ($conn->multi_query($sql)) {
        do {
            /* store first result set */
            echo "<center>";
            echo "<h2>Welcome, " . $user . "</h2><br>";
            echo "<table style='border-radius: 25px; border: 2px solid black;' cellspacing=30>";
            echo "<tr><th>帳號</th><th>薪資</th></tr>";
            if ($result = $conn->store_result()) {
                while ($row = $result->fetch_assoc()) {
                    $keys = array_keys($row);
                    echo "<tr>";
                    foreach ($keys as $key) {
                        echo "<td>" . $row[$key] . "</td>";
                    }
                    echo "</tr>\n";
                }
                $result->free();
            }
            if (!$conn->more_results()) {
                echo "</table></center>";
            }
        } while ($conn->next_result());
    }
}
?>