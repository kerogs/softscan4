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
$dotenv = Dotenv::createImmutable(__DIR__.'/../');
$dotenv->load();

$ADMIN_PASSWORD = $_ENV['ADMIN_PASSWORD'];

if (isset($_POST['password'])) {

    $password = htmlentities($_POST['password']);

    if ($password == password_verify($password, $ADMIN_PASSWORD)) {

        $_SESSION['keyaccess'] = $ADMIN_PASSWORD;
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

    <div class="login">
        <div class="topAnimationLoad">
            <div id="headertohundred"></div>
        </div>

        <div class="ccenter">
            <div class="icon">
                <i data-lucide="shield-ellipsis"></i>
            </div>
            <h1>Connexion requise</h1>
            <form action="" method="post">
                <div class="inputgroup">
                    <i data-lucide="key-square"></i>
                    <input type="password" id="passwordInput" name="password" placeholder="Password" autofocus maxlength="16" minlength="4" required>
                </div>
                <button type="submit" id="buttonlogin" onclick="loginAnimation();  document.getElementById('buttonlogin').innerHTML = 'Connexion en cours...';">
                    Envoyer
                </button>
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

            document.getElementById('passwordInput').addEventListener('input', function() {
                const password = this.value;
                const button = document.getElementById('buttonlogin');

                if (password.length >= 4 && password.length <= 16) {
                    button.classList.add('active');
                    button.removeAttribute('disabled');
                } else {
                    button.classList.remove('active');
                    button.setAttribute('disabled', 'true');
                }
            });
        </script>

        <div class="background">
            <div class="dot" title="Dot">
                <svg>
                    <defs>
                        <pattern id="dot-pattern" width="32" height="32" patternUnits="userSpaceOnUse"
                            patternContentUnits="userSpaceOnUse" x="0" y="0">
                            <circle cx="16" cy="16" r="1.5"></circle>
                        </pattern>
                    </defs>
                    <rect width="100%" height="100%" stroke-width="0" fill="url(#dot-pattern)" />
                </svg>
            </div>
        </div>

    </div>
</body>
<script>
    lucide.createIcons();
</script>

</html>