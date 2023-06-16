<?php
session_start();
include 'lib.php';
$link = getdb();

if (isset($_POST['regisztracio'])) {

    $felhasznalonev = trim(mysqli_real_escape_string($link, $_POST['felhasznalonev']));
    $jelszo = trim(mysqli_real_escape_string($link, $_POST['jelszo']));
    $jelszo2 = trim(mysqli_real_escape_string($link, $_POST['jelszo2']));

    if (registration_valid($felhasznalonev, $jelszo, $jelszo2, $link)) {
        $hash = password_hash($jelszo, PASSWORD_DEFAULT);
        $default_skin = 'green_style.css';
        $query = sprintf("INSERT INTO felhasznalo(felhasznalonev, jelszo, skin) VALUES ('%s', '%s', '%s')", $felhasznalonev, $hash, $default_skin);
        mysqli_query($link, $query) or die(mysqli_error($link));
        mysqli_close($link);
        $_SESSION['sikeres_regisztracio'] = TRUE;
        header("Location: login.php");
        return;
    }

    unset($_POST['regisztracio']);
}
?>

<html>

<head>
    <?php include 'head.php' ?>
</head>

<body>
    <?php include 'login_menu.html'; ?>

    <div class="container">

        <main>
            <h1>Labdarúgó Átigazolási Portál</h1>
        </main>

        <form method="POST">
            <table class="table">
                <thead>
                    <tr>
                        <th style="text-align:center;">
                            Regisztráció
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <label for="felhasznalonev">Felhasználónév:</label>
                            <input class="form-control" name="felhasznalonev" id="felhasznalonev" type="text"
                                placeholder="picicica58" />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="jelszo">Jelszó:</label>
                            <input class="form-control" name="jelszo" id="jelszo" type="text" placeholder="*******" />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="jelszo2">Jelszó megerősítése:</label>
                            <input class="form-control" name="jelszo2" id="jelszo2" type="text" placeholder="*******" />
                        </td>
                    </tr>
                </tbody>
            </table>
            <input class="btn btn-primary" name="regisztracio" type="submit" value="Regisztráció" />
        </form>

        <div class="picture">
            <img src="transzfer.png">
        </div>

    </div>

    <footer style="position: absolute; bottom: 0;">
        &#169;2023 Labdarúgó Átigazolási Portál &#9917;
    </footer>
</body>

</html>