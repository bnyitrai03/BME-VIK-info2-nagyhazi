<?php
session_start();
include 'lib.php';
$link = getdb();

if (!isset($_GET['csapatid'])) {
    header("Location: csapat.php");
    return;
}
$csapatid = (int) $_GET['csapatid'];
$query = sprintf("SELECT id, nev, nemzetiseg  FROM csapat where id = %s", mysqli_real_escape_string($link, $csapatid))
    or die(mysqli_error($link));
$eredmeny = mysqli_query($link, $query);
$row = mysqli_fetch_array($eredmeny);
if (!$row) {
    header("Location: csapat.php");
    return;
}

if (isset($_POST['mentes'])) {
    $nev = trim(mysqli_real_escape_string($link, $_POST['nev']));
    $nemzetiseg = trim(mysqli_real_escape_string($link, $_POST['nemzetiseg']));

    if (team_update_valid($nev, $nemzetiseg)) {
        $query = sprintf("UPDATE csapat SET nev='%s', nemzetiseg='%s' WHERE id='%d'", $nev, $nemzetiseg, $csapatid);
        mysqli_query($link, $query) or die(mysqli_error($link));
        $_SESSION['csapat_modositas'] = TRUE;
        header("Location: csapat.php");
        return;
        }

}

if(isset($_POST['torles'])){
    //az olyan átigazolás rekordok törlése, ahol a regi_csapatid hivatkozik a csapat(id) oszlopára
    $delete_atigazolas_regicsapat = sprintf('DELETE FROM atigazolas WHERE regi_csapatid= %s', mysqli_real_escape_string($link, $_GET['csapatid']));
    //az olyan átigazolás rekordok törlése, ahol az uj_csapatid hivatkozik a csapat(id) oszlopára
    $delete_atigazolas_ujcsapat= sprintf('DELETE FROM atigazolas WHERE uj_csapatid= %s', mysqli_real_escape_string($link, $_GET['csapatid']));
    $delete_csapat = sprintf('DELETE FROM csapat WHERE id= %s', mysqli_real_escape_string($link, $_GET['csapatid']));
    mysqli_query($link, $delete_atigazolas_regicsapat) or die(mysqli_error($link));
    mysqli_query($link, $delete_atigazolas_ujcsapat) or die(mysqli_error($link));
    mysqli_query($link, $delete_csapat) or die(mysqli_error($link));
    $_SESSION['csapat_torles'] = TRUE;
    header("Location: csapat.php");
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
            <h1>Csapat szerkesztése</h1>
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
                            <label for="nev">Csapat neve:</label>
                            <input class="form-control" name="nev" id="nev" type="text" value=" <?= $row['nev'] ?>"/>
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