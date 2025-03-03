<?php

// ! Logs maker (see /server.log)
/**
 * Checks if the given IP address is valid.
 *
 * @param string $ip The IP address to validate.
 * @return bool Returns true if the IP address is valid, false otherwise.
 */
function isValidIpAddress($ip)
{
    if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4) !== false) {
        return true;
    }
    if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6) !== false) {
        return true;
    }
    return false;
}

/**
 * Prepends new content to the beginning of a file.
 *
 * @param string $filePath The path to the file.
 * @param string $newContent The content to be prepended.
 * @return bool Returns true if the content was successfully prepended, false otherwise.
 */
function prependToFile($filePath, $newContent)
{
    if (!file_exists($filePath)) {
        return false;
    }
    $currentContent = file_get_contents($filePath);
    $file = fopen($filePath, 'w');
    if ($file === false) {
        return false;
    }
    fwrite($file, $newContent . PHP_EOL);
    fwrite($file, $currentContent);
    fclose($file);
    return true;
}



// ! default section
session_start();

require '../vendor/autoload.php';

use Dotenv\Dotenv;

// ? check if .env exists, if not, create it and set default password with hash.
if (!file_exists("../.env")) {
    file_put_contents("../.env", 'KEY_ACCESS=$2y$10$ctTRFAaSpHWhjJ.4D63Zi.bTM5h4lka9hDyuytXJYI/ge/stLJ1QO ' . "\n" . 'CRYPT_KEY=' . uniqid());

    header("location: ./login?err=1");
    exit();
} else {
    $dotenv = Dotenv::createImmutable('../');
    $dotenv->load();
}

$KEY_ACCESS = $_ENV['KEY_ACCESS'];

if (isset($_POST['password'])) {

    $password = htmlentities($_POST['password']);

    if ($password == password_verify($password, $KEY_ACCESS)) {

        $_SESSION['keyaccess'] = $KEY_ACCESS;
        if (isset($_GET['redirect'])) {
            header('Location: ' . $_GET['redirect']);
        } else {
            header("location: ./");
        }
        exit();
    } else {
    }
} else {
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="./src/css/style.css">
    <script src="./node_modules/lucide/dist/umd/lucide.js"></script>
</head>

<style>
    .topAnimationLoad {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 3px;

        /* background-color: #fff; */
    }

    .topAnimationLoad #headertohundred {
        width: 0%;
        height: 3px;
        background-color: #fd4e2b;
    }
</style>

<body>

    <div class="topAnimationLoad">
        <div id="headertohundred"></div>
    </div>

    <div class="ccenter">
        <i data-lucide="shield-ellipsis"></i>
        <h1>Login</h1>
        <form action="" method="post">
            <label for="password">Clé de connexion</label>
            <input type="password" name="password" placeholder="Password">
            <input type="submit" id="buttonlogin" onclick="loginAnimation();             document.getElementById('buttonlogin').value = 'Connexion en cours...';" value="Login">
        </form>
    </div>

    <script>
        loginAnimation = () => {
            headertohundred = document.getElementById('headertohundred');

            for (let i = 0; i <= 100; i++) {
                setTimeout(() => {
                    headertohundred.style.width = i + '%';
                }, i * 16);
            }
        }
    </script>

</body>
<script>
    lucide.createIcons();
</script>

</html>