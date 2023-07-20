<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];

    if (strlen($password) < 8) {
        echo "Password must be at least 8 characters long.";
        exit;
    }

    if ($password !== $confirm_password) {
        echo "Passwords do not match.";
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format.";
        exit;
    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $users_json = file_get_contents("users.json");
    $users_array = json_decode($users_json, true);

    $user = [
        "name" => $name,
        "email" => $email,
        "password" => $hashed_password
    ];

    $users_array[] = $user;

    $updated_users_json = json_encode($users_array);
    file_put_contents("users.json", $updated_users_json);

    echo "Registration successful!";
}
?>
