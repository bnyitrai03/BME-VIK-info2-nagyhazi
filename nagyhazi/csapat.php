<?php
session_start();
include 'lib.php';
$link = getdb();

if (isset($_POST['hozzaadas'])) {

    if ($_POST['token'] == $_SESSION['token']) {
        //egyedi token, ha a felhasználó refresheli az oldalt, akkor a formba beírt értékek ne kerüljenek mégegyszer elküldésre
        $nev = mysqli_real_escape_string($link, $_POST['nev']);
        $nemzetiseg = trim(mysqli_real_escape_string($link, $_POST['nemzetiseg']));

        if (team_input_valid($nev, $nemzetiseg, $link)) {
            $query = sprintf("INSERT INTO csapat(nev, nemzetiseg) VALUES ('%s', '%s')", $nev, $nemzetiseg);
            mysqli_query($link, $query) or die(mysqli_error($link));
            echo '<div class="alert alert-success" role="alert">A csapat bekerült az adatbázisba!</div>';
        }
    }
    unset($_POST['hozzaadas']);
}

$token = uniqid();
$_SESSION['token'] = $token;
//token generálása

if(isset($_SESSION['csapat_modositas'])){
    echo '<div class="alert alert-success" role="alert">A csapat adatai sikeresen módosultak!</div>';
    unset($_SESSION['csapat_modositas']);
}
//visszajelzés a csapat módosításáról

if(isset($_SESSION['csapat_torles'])){
    echo '<div class="alert alert-success" role="alert">A csapat törlése megtörtént!</div>';
    unset($_SESSION['csapat_torles']);
}
//visszajelzés a csapat törléséről
?>

<html>

<head>
    <?php include 'head.php' ?>
</head>

<body>
    <?php include 'menu.html'; ?>

    <div class="container">

        <main>
            <h1>Csapatok</h1>
        </main>

        <?php
        $kereses = null;
        if (isset($_POST['kereses'])) {
            $kereses =  mysqli_real_escape_string($link, strtolower($_POST['kereses']));
        }
        ?>

        <div class="search_bar">
            <form class="form-inline" method="post">
                <input class="form-control" type="search" name="kereses" placeholder="Keresés..." value="<?= $kereses ?>">
                <button class="btn btn-primary" type="submit" style="height: 38px;"><i class="fa fa-search"></i></button>
            </form>
        </div>

        <?php
        $query = "SELECT id, nev, nemzetiseg FROM csapat";
        if (isset($kereses)) {
            $query = $query . sprintf(" WHERE LOWER(nev) LIKE '%%%s%%' ", $kereses);
        }
        $data = mysqli_query($link, $query) or die(mysqli_error($link));
        ?>

        <table class="table" style=" margin-top: 0px; padding-top: 0px; border-top: 0px;">
            <thead>
                <tr>
                    <th>Csapatnév</th>
                    <th>Nemzetiség</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_array($data)):
                /* az id=1-es a "Még nincs csapata", az id=2-es pedig a "Visszavonult" státusz,
                ezeket nem akarjuk megjeleníteni, mint csapat */
                if($row['id'] == 1 or $row['id'] == 2){
                    continue;
                } 
                ?>
                    <tr>
                        <td>
                            <?= $row['nev'] ?>
                        </td>
                        <td>
                            <?= $row['nemzetiseg'] ?>
                        </td>
                        <td style="width: 100px">
                            <a class="btn btn-primary btn-sm" href="edit_csapat.php?csapatid=<?= $row['id'] ?>">
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
                            Új Csapat Hozzáadása
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <label for="nev">Csapat neve:</label>
                            <input class="form-control" name="nev" id="nev" type="text" placeholder="Manchester city" />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="nemzetiseg">Nemzetiség:</label>
                            <input class="form-control" name="nemzetiseg" id="nemzetiseg" type="text"
                                placeholder="angol" />
                        </td>
                    </tr>
                </tbody>
            </table>
            <input class="btn btn-primary" name="hozzaadas" type="submit" value="Hozzáadás" />
            <input type="hidden" name="token" value="<?php echo $token; ?>">
            <!-- egyedi token, ha a felhasználó refresheli az oldalt, akkor a formba beírt értékek ne kerüljenek mégegyszer elküldésre -->
        </form>

    </div>

    <footer>
        <p>&#169;2023 Labdarúgó Átigazolási Portál &#9917;</p>
    </footer>
</body>

</html>