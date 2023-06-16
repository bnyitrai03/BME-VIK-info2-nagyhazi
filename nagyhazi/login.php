<?php
session_start();
include 'lib.php';
$link = getdb();

if (isset($_POST['bejelentkezes'])) {

    $in_felhasznalonev = trim(mysqli_real_escape_string($link, $_POST['felhasznalonev']));
    $in_jelszo = trim(mysqli_real_escape_string($link, $_POST['jelszo']));

    if (login_valid($in_felhasznalonev, $in_jelszo)) {
        $query = sprintf("SELECT id, felhasznalonev, jelszo, skin FROM felhasznalo WHERE felhasznalonev = '%s'", $in_felhasznalonev);
        $user = mysqli_query($link, $query) or die(mysqli_error($link));
        mysqli_close($link);
        $felhasznalo = mysqli_fetch_array($user);
        if (!empty($felhasznalo))
            if (password_verify($in_jelszo, $felhasznalo['jelszo'])) {
                $_SESSION['id'] = $felhasznalo['id'];
                $_SESSION['felhasznalonev'] = $in_felhasznalonev;
                $_SESSION['skin'] = $felhasznalo['skin'];
                header("Location: index.php");
                return;
            } else {
                echo '<script>alert("Helytelen jelszó!")</script>';
            } else {
            echo '<script>alert("Nincs ilyen nevű felhasználó!")</script>';
        }
    }

    unset($_POST['hozzaadas']);
}

if (isset($_SESSION['sikeres_regisztracio'])) {
    echo '<div class="alert alert-success" role="alert">Sikeres regisztráció!</div>';
    unset($_SESSION['sikeres_regisztracio']);
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
                            Bejelentkezés
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
                </tbody>
            </table>
            <input class="btn btn-primary" name="bejelentkezes" type="submit" value="Bejelentkezés" />
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