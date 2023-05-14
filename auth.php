<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dbecommerce";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["register"])) {
        $firstname = $_POST["firstname"];
        $lastname = $_POST["lastname"];
        $username = $_POST["username"];
        $password = hash('sha256', $_POST["password"]);

        $sql = "INSERT INTO tbluseraccount (username, password, firstname, lastname) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssss", $username, $password, $firstname, $lastname);

        if ($stmt->execute()) {
            $_SESSION['auth'] = true;
            $_SESSION['username'] = $username;
            header("Location: index.php");
            exit();
        } else {
            echo "Registration failed.";
            exit();
        }
    } elseif (isset($_POST["login"])) {
        $username = $_POST["username"];
        $password = hash('sha256', $_POST["password"]);

        $sql = "SELECT * FROM tbluseraccount WHERE username = ? AND password = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if ($user) {
            $_SESSION['auth'] = true;
            $_SESSION['username'] = $username;
            header("Location: index.php");
            exit();
        } else {
            echo "Invalid username or password.";
            exit();
        }
    } elseif (isset($_POST["logout"])) {
        session_destroy();
        header("Location: login.php");
        exit();
    } elseif (isset($_POST["update"])) {
        $firstname = $_POST["firstname"];
        $lastname = $_POST["lastname"];
        $username = $_POST["username"];
        $password = hash('sha256', $_POST["password"]);

        $sql = "UPDATE tbluseraccount SET username = ?, password = ?, firstname = ?, lastname = ? WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssss", $username, $password, $firstname, $lastname, $username);

        if ($stmt->execute()) {
            $_SESSION['username'] = $username;
            header("Location: profile.php");
            exit();
        } else {
            echo "Update profile failed.";
            exit();
        }
    }
}
