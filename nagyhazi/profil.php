<?php
session_start();
include 'lib.php';
$link = getdb();

if (isset($_POST['valtoztatas'])) {
    $skin = $_POST['skin'].'_style.css';
    $query = sprintf("UPDATE felhasznalo SET skin = '%s' WHERE id='%d'", $skin, $_SESSION['id']);
    mysqli_query($link, $query) or die(mysqli_error($link));
    mysqli_close($link);
    $_SESSION['skin'] = $skin;
    unset($_POST['valtoztatas']);
}
?>

<html>

<head>
    <?php include 'head.php' ?>
</head>

<body>
    <?php include 'menu.html'; ?>

    <div class="container">
        <main>
            <h1>Profil</h1>
        </main>

        <table class="table">
            <thead>
                <tr>
                    <th>Felhasználónév</th>
                    <th>Kiválasztott téma</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <?php echo $_SESSION['felhasznalonev']; ?>
                    </td>
                    <td>
                        <?php
                        $skin = substr_replace($_SESSION['skin'], "", -10);
                        // eltávolítjuk a 'style.css'-t, így csak a téma marad
                        echo $skin;
                        ?>
                    </td>
                    <td style="width: 100px">
                        <a class="btn btn-primary btn-sm" href="logout.php">
                            Kijelentkezés 
                        </a>
                    </td>
                </tr>
            </tbody>
        </table>

        <form method="POST">
            <table class="table">
                <thead>
                    <tr>
                        <th style="text-align:center;">
                            Téma váltás
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <label>Téma színe:</label>
                            <select class="form-control" name="skin" id="skin">
                                <option value="green">zöld</option>
                                <option value="dark">sötét</option>
                                <option value="brown">barna</option>
                                <option value="purple">lila</option>
                            </select>
                        </td>
                    </tr>
                </tbody>
            </table>
            <input class="btn btn-primary" name="valtoztatas" type="submit" value="Változtatás" />
        </form>

    </div>

    <footer style="position: absolute; bottom: 0;">
        &#169;2023 Labdarúgó Átigazolási Portál &#9917;
    </footer>

</body>

</html>