<?php
session_start();
include 'lib.php';
$link = getdb();

if (isset($_POST['hozzaadas'])) {

    if ($_POST['token'] == $_SESSION['token']) {
        //egyedi token, ha a felhasználó refresheli az oldalt, akkor a formba beírt értékek ne kerüljenek mégegyszer elküldésre
        $jatekosid = mysqli_real_escape_string($link, $_POST['jatekosid']);
        $osszeg = mysqli_real_escape_string($link, $_POST['osszeg']);
        $datum =  date('Y-m-d', strtotime($_POST['datum']));
        $uj_csapatid =  mysqli_real_escape_string($link, $_POST['uj_csapatid']);
        $regi_csapatid = regi_csapat_kereso($jatekosid, $link);

        if (transfer_input_valid($jatekosid, $regi_csapatid, $uj_csapatid, $osszeg, $datum, $link)) {
            $query = sprintf("INSERT INTO atigazolas(jatekosid, regi_csapatid, uj_csapatid, osszeg, datum) VALUES ('%d', '%d', '%d', '%f', '%s')",
            $jatekosid, $regi_csapatid, $uj_csapatid, $osszeg, $datum);
            mysqli_query($link, $query) or die(mysqli_error($link));
            //megváltoztatjuk a játékos értéket annyira, amennyiért leigazolták
            $ertek_frissites = sprintf("UPDATE jatekos SET ertek='%f' WHERE id='%d'", $osszeg, $jatekosid);
            mysqli_query($link, $ertek_frissites) or die(mysqli_error($link));
            echo '<div class="alert alert-success" role="alert">Az átigazolás bekerült az adatbázisba!</div>';
        }
    }
    unset($_POST['hozzaadas']);
}

$token = uniqid();
$_SESSION['token'] = $token;
//token generálása

if(isset($_SESSION['atigazolas_modositas'])){
    echo '<div class="alert alert-success" role="alert">Az átigazolás adatai sikeresen módosultak!</div>';
    unset($_SESSION['atigazolas_modositas']);
}
//visszajelzés az átigazolás módosításáról

if(isset($_SESSION['atigazolas_torles'])){
    echo '<div class="alert alert-success" role="alert">Az átigazolás törlése megtörtént!</div>';
    unset($_SESSION['atigazolas_torles']);
}
//visszajelzés az átigazolás törléséről
?>

<html>

<head>
    <?php include 'head.php' ?>
</head>

<body>
    <?php include 'menu.html'; ?>

    <div class="container">

        <main>
            <h1>Átigazolások</h1>
        </main>

        <?php  
        $query = "SELECT atigazolas.id AS atigazolasid, jatekos.nev AS jatekosnev, osszeg, datum, regi_csapat.nev AS regi_csapatnev, uj_csapat.nev AS uj_csapatnev 
        FROM jatekos INNER JOIN atigazolas ON jatekos.id = atigazolas.jatekosid
        INNER JOIN csapat AS regi_csapat ON regi_csapat.id = atigazolas.regi_csapatid
        INNER JOIN csapat AS uj_csapat ON uj_csapat.id = atigazolas.uj_csapatid
        ORDER BY datum DESC";
        $data = mysqli_query($link, $query) or die(mysqli_error($link));
        ?>

        <table class="table">
            <thead>
                <tr>
                    <th>Név</th>
                    <th>Átigazolási díj</th>
                    <th>Régi csapat</th>
                    <th></th>
                    <th>Új csapat</th>
                    <th>Dátum</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_array($data)): ?>
                    <tr>
                        <td>
                            <?= $row['jatekosnev'] ?>
                        </td>
                        <td>
                            <?= $row['osszeg'] ?>M &#8364;
                        </td>
                        <td>
                            <?= $row['regi_csapatnev'] ?>
                        </td>
                        <td><i class='fa fa-arrow-right'></i></td>
                        <td>
                            <?= $row['uj_csapatnev'] ?>
                        </td>
                        <td>
                            <?= $row['datum'] ?>
                        </td>
                        <td style="width: 100px">
                            <a class="btn btn-primary btn-sm" href="edit_atigazolas.php?atigazolasid=<?= $row['atigazolasid'] ?>">
                                <i class='fa fa-edit'></i> Szerkesztés
                            </a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <?php mysqli_close($link); ?>


        <form method="POST">
            <table class="table">
                <thead>
                    <tr>
                        <th style="text-align:center;">
                            Új Átigazolás Létrehozása
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <label for='jatekosid'>Játékos neve:</label>
                            <select class="form-control" name='jatekosid' id='jatekosid'>
                            <?php 
                            $link = getdb();
                            $queryjatekos = "SELECT id, nev FROM jatekos";
                            $jatekosdata = mysqli_query($link, $queryjatekos) or die(mysqli_error($link));
                            while ($rowjatekos = mysqli_fetch_array($jatekosdata)):
                            ?>
                            <option value="<?=$rowjatekos['id']?>"><?=$rowjatekos['nev']?></option>
                            <?php endwhile; ?>
                            </select>                          
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="osszeg">Átigazolási díj: [Millió &#8364;]</label>
                            <input class="form-control" name="osszeg" id="osszeg" type="float" placeholder="80.5" />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for='uj_csapatid'>Új csapat:</label>
                            <select class="form-control" name='uj_csapatid' id='uj_csapatid'>
                            <?php 
                            $query_uj_csapat = "SELECT id, nev FROM csapat";
                            $uj_csapat_data = mysqli_query($link, $query_uj_csapat) or die(mysqli_error($link));
                            while ($row_uj_csapat = mysqli_fetch_array($uj_csapat_data)):
                            ?>
                            <option value="<?=$row_uj_csapat['id']?>"><?=$row_uj_csapat['nev']?></option>
                            <?php endwhile; ?>
                            </select>                          
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="datum">Dátum:</label>
                            <input class="form-control" name="datum" id="datum" type="date"/>
                        </td>
                    </tr>
                </tbody>
            </table>
            <input class="btn btn-primary" name="hozzaadas" type="submit" value="Hozzáadás" />
            <input type="hidden" name="token" value="<?php echo $token; ?>">
            <!-- egyedi token, ha a felhasználó refresheli az oldalt, akkor a formba beírt értékek ne kerüljenek mégegyszer elküldésre -->
        </form>
        <?php mysqli_close($link); ?>

    </div>

    <footer>
        <p>&#169;2023 Labdarúgó Átigazolási Portál &#9917;</p>
    </footer>
</body>

</html>


