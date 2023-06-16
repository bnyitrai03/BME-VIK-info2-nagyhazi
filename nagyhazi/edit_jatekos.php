<?php
session_start();
include 'lib.php';
$link = getdb();

if (!isset($_GET['jatekosid'])) {
    header("Location: jatekos.php");
    return;
}
$jatekosid = (int) $_GET['jatekosid'];
$query = sprintf("SELECT id, nev, ertek, nemzetiseg  FROM jatekos where id = %s", mysqli_real_escape_string($link, $jatekosid))
    or die(mysqli_error($link));
$eredmeny = mysqli_query($link, $query);
$row = mysqli_fetch_array($eredmeny);
if (!$row) {
    header("Location: jatekos.php");
    return;
}

if (isset($_POST['mentes'])) {
    $nev = trim(mysqli_real_escape_string($link, $_POST['nev']));
    $ertek = mysqli_real_escape_string($link, $_POST['ertek']);
    $nemzetiseg = trim(mysqli_real_escape_string($link, $_POST['nemzetiseg']));

    if (player_update_valid($nev, $ertek, $nemzetiseg)) {
        $query = sprintf("UPDATE jatekos SET nev='%s', nemzetiseg='%s', ertek='%f' WHERE id='%d'", $nev, $nemzetiseg, $ertek, $jatekosid);
        mysqli_query($link, $query) or die(mysqli_error($link));
        $_SESSION['jatekos_modositas'] = TRUE;
        header("Location: jatekos.php");
        return;
        }

}

if(isset($_POST['torles'])){
    $delete_atigazolas = sprintf('DELETE FROM atigazolas WHERE jatekosid= %s', mysqli_real_escape_string($link, $_GET['jatekosid']));
    $delete_jatekos = sprintf('DELETE FROM jatekos WHERE id= %s', mysqli_real_escape_string($link, $_GET['jatekosid']));
    mysqli_query($link, $delete_atigazolas) or die(mysqli_error($link));
    mysqli_query($link, $delete_jatekos) or die(mysqli_error($link));
    $_SESSION['jatekos_torles'] = TRUE;
    header("Location: jatekos.php");
    return;
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
            <h1>Játékos szerkesztése</h1>
        </main>

        <form method="POST">
            <table class="table">
                <thead>
                    <tr>
                        <th style="text-align:center;">
                            Adatok módosítása
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <label for="nev">Játékos neve:</label>
                            <input class="form-control" name="nev" id="nev" type="text" value=" <?= $row['nev'] ?>"/>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="ertek">Érték: [Millió &#8364;]</label>
                            <input class="form-control" name="ertek" id="ertek" type="float"
                                value="<?= $row['ertek'] ?>"/>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="nemzetiseg">Nemzetiség:</label>
                            <input class="form-control" name="nemzetiseg" id="nemzetiseg" type="text"
                                value=" <?= $row['nemzetiseg'] ?>"/>
                        </td>
                    </tr>
                </tbody>
            </table>
            <input type="submit" class="btn btn-primary" style="margin-right:50px;" name="mentes" id="mentes" value="Mentés"/>
            <input class="btn btn-danger" name="torles" id="torles" type="submit" value="Törlés"/>
        </form>

    </div>

    <footer>
        <p>&#169;2023 Labdarúgó Átigazolási Portál &#9917;</p>
    </footer>

</body>

<html>