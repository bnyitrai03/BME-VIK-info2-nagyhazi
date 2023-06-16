<?php
session_start();
include 'lib.php';
$link = getdb();

if (!isset($_GET['atigazolasid'])) {
    header("Location: atigazolas.php");
    return;
}
$atigazolasid = (int) $_GET['atigazolasid'];

$query = sprintf(
    "SELECT jatekos.id AS jatekosid, jatekos.nev AS jatekosnev, atigazolas.osszeg AS osszeg, atigazolas.datum AS datum,
regi_csapat.nev AS regi_csapatnev, uj_csapat.nev AS uj_csapatnev, uj_csapat.id AS uj_csapatid
FROM jatekos INNER JOIN atigazolas ON jatekos.id = atigazolas.jatekosid
INNER JOIN csapat AS regi_csapat ON regi_csapat.id = atigazolas.regi_csapatid
INNER JOIN csapat AS uj_csapat ON uj_csapat.id = atigazolas.uj_csapatid
WHERE atigazolas.id = %s",
    mysqli_real_escape_string($link, $atigazolasid)
)
    or die(mysqli_error($link));

$eredmeny = mysqli_query($link, $query);
$row = mysqli_fetch_array($eredmeny);
if (!$row) {
    header("Location: atigazolas.php");
    return;
}

if (isset($_POST['hozzaadas'])) {
    $osszeg = mysqli_real_escape_string($link, $_POST['osszeg']);
    $datum = date('Y-m-d', strtotime($_POST['datum']));

    $query = sprintf("UPDATE atigazolas SET osszeg ='%s', datum ='%s' WHERE id='%d'", $osszeg, $datum, $atigazolasid);
    mysqli_query($link, $query) or die(mysqli_error($link));
    $_SESSION['atigazolas_modositas'] = TRUE;
    header("Location: atigazolas.php");
    return;
}

if (isset($_POST['torles'])) {
    $delete_atigazolas = sprintf('DELETE FROM atigazolas WHERE id= %s', $atigazolasid);
    mysqli_query($link, $delete_atigazolas) or die(mysqli_error($link));
    $_SESSION['atigazolas_torles'] = TRUE;
    header("Location: atigazolas.php");
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
            <h1>Átigazolások szerkesztése</h1>
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
                            <input type="hidden" name="jatekosid" id="jatekosid" value="<?= $row['jatekosid'] ?>" />
                            <label for='jatekosid'>Játékos neve:</label>
                            <input id="jatekosnev" class="form-control" readonly type="text"
                                value="<?= $row['jatekosnev'] ?>" />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="osszeg">Átigazolási díj: [Millió &#8364;]</label>
                            <input class="form-control" name="osszeg" id="osszeg" type="float"
                                value="<?= $row['osszeg'] ?>" />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="hidden" name="uj_csapatid" id="uj_csapatid"
                                value="<?= $row['uj_csapatid'] ?>" />
                            <label for='uj_csapatid'>Új csapat:</label>
                            <input id="uj_csapatnev" class="form-control" readonly type="text"
                                value="<?= $row['uj_csapatnev'] ?>" />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="datum">Dátum:</label>
                            <input class="form-control" name="datum" id="datum" type="date"
                                value="<?= $row['datum'] ?>" />
                        </td>
                    </tr>
                </tbody>
            </table>
            <input class="btn btn-primary" style="margin-right:50px;" name="hozzaadas" type="submit"
                value="Hozzáadás" />
            <input class="btn btn-danger" name="torles" id="torles" type="submit" value="Törlés" />
        </form>
        <?php mysqli_close($link); ?>
    </div>

    <footer>
        <p>&#169;2023 Labdarúgó Átigazolási Portál &#9917;</p>
    </footer>

</body>

<html>