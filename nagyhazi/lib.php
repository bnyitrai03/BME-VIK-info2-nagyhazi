<?php
function getdb(){

    $link = mysqli_connect("localhost", "root", "")
        or die(mysqli_error($link));
    mysqli_select_db($link, "atigazolasok");
    mysqli_query($link, "set character_set_results='utf8'");
    mysqli_query($link, "set character_set_client='utf8'");
    return $link;
}

function player_input_valid($nev, $ertek, $nemzetiseg, $link){

    if (empty($nev) or empty($ertek) or empty($nemzetiseg)) {

        echo '<script>alert("A játékos hozzáadása során az összes mezőt töltse ki!")</script>';
        return FALSE;
    }

    if (!preg_match('/^[a-zA-ZáéíóöőúüűÁÉÍÓÖŐÚÜŰ\s]+$/', $nev)) {
        //REGEX: ^[a-zA-ZáéíóöőúüűÁÉÍÓÖŐÚÜŰ\s] == csak betűk lehetnek a névben (angol + magyar) és spacek

        echo '<script>alert("Adja meg egy létező játékos nevét!")</script>';
        return FALSE;
    }

    if (!preg_match('/^[a-zA-ZáéíóöőúüűÁÉÍÓÖŐÚÜŰ]+$/', $nemzetiseg)) {
        //REGEX: ^[a-zA-ZáéíóöőúüűÁÉÍÓÖŐÚÜŰ] == csak betűk lehetnek a nemzetiségben (angol + magyar)

        echo '<script>alert("Adjon meg egy létező nemzetiséget!")</script>';
        return FALSE;
    }

    if (!is_numeric($ertek) and $ertek >= 0) {

        echo '<script>alert("Adja meg a játékos értékét, a helyes fotmátumra ügyelve! [Millió euró, tizedes ponttal elválasztva]")</script>';
        return FALSE;
    }

    $player_already_created = mysqli_query($link, "SELECT nev FROM jatekos WHERE nev ='$nev'") or die(mysqli_error($link));
    if (mysqli_num_rows($player_already_created) > 0) {

        echo '<script>alert("Ez a játékos már szerepel az adatbázisban!")</script>';
        return FALSE;
    }

    return TRUE;
}

function player_update_valid($nev, $ertek, $nemzetiseg){

    if (empty($nev) or empty($ertek) or empty($nemzetiseg)) {

        echo '<script>alert("A játékos hozzáadása során az összes mezőt töltse ki!")</script>';
        return FALSE;
    }

    if (!preg_match('/^[a-zA-ZáéíóöőúüűÁÉÍÓÖŐÚÜŰ\s]+$/', $nev)) {
        //REGEX: ^[a-zA-ZáéíóöőúüűÁÉÍÓÖŐÚÜŰ\s] == csak betűk lehetnek a névben (angol + magyar) és spacek

        echo '<script>alert("Adja meg egy létező játékos nevét!")</script>';
        return FALSE;
    }

    if (!preg_match('/^[a-zA-ZáéíóöőúüűÁÉÍÓÖŐÚÜŰ]+$/', $nemzetiseg)) {
        //REGEX: ^[a-zA-ZáéíóöőúüűÁÉÍÓÖŐÚÜŰ] == csak betűk lehetnek a nemzetiségben (angol + magyar)

        echo '<script>alert("Adjon meg egy létező nemzetiséget!")</script>';
        return FALSE;
    }

    if (!is_numeric($ertek) and $ertek >= 0) {

        echo '<script>alert("Adja meg a játékos értékét, a helyes fotmátumra ügyelve! [Millió euró, tizedes ponttal elválasztva]")</script>';
        return FALSE;
    }

    return TRUE;
}

function team_input_valid($nev, $nemzetiseg, $link){

    if (empty($nev) or empty($nemzetiseg)) {

        echo '<script>alert("A csapat hozzáadása során az összes mezőt töltse ki!")</script>';
        return FALSE;
    }

    if (!preg_match('/^[a-zA-ZáéíóöőúüűÁÉÍÓÖŐÚÜŰ\s]+$/', $nev)) {
        //REGEX: ^[a-zA-ZáéíóöőúüűÁÉÍÓÖŐÚÜŰ\s] == csak betűk lehetnek a névben (angol + magyar) és spacek

        echo '<script>alert("Adja meg egy létező csapat nevét!")</script>';
        return FALSE;
    }

    if (!preg_match('/^[a-zA-ZáéíóöőúüűÁÉÍÓÖŐÚÜŰ]+$/', $nemzetiseg)) {
        //REGEX: ^[a-zA-ZáéíóöőúüűÁÉÍÓÖŐÚÜŰ] == csak betűk lehetnek a nemzetiségben (angol + magyar)

        echo '<script>alert("Adjon meg egy létező nemzetiséget!")</script>';
        return FALSE;
    }

    $team_already_created = mysqli_query($link, "SELECT nev FROM csapat WHERE nev ='$nev'") or die(mysqli_error($link));
    if (mysqli_num_rows($team_already_created) > 0) {

        echo '<script>alert("Ez a csapat már szerepel az adatbázisban!")</script>';
        return FALSE;
    }

    return TRUE;
}

function team_update_valid($nev, $nemzetiseg){

    if (empty($nev) or empty($nemzetiseg)) {

        echo '<script>alert("A csapat hozzáadása során az összes mezőt töltse ki!")</script>';
        return FALSE;
    }

    if (!preg_match('/^[a-zA-ZáéíóöőúüűÁÉÍÓÖŐÚÜŰ\s]+$/', $nev)) {
        //REGEX: ^[a-zA-ZáéíóöőúüűÁÉÍÓÖŐÚÜŰ\s] == csak betűk lehetnek a névben (angol + magyar) és spacek

        echo '<script>alert("Adja meg egy létező csapat nevét!")</script>';
        return FALSE;
    }

    if (!preg_match('/^[a-zA-ZáéíóöőúüűÁÉÍÓÖŐÚÜŰ]+$/', $nemzetiseg)) {
        //REGEX: ^[a-zA-ZáéíóöőúüűÁÉÍÓÖŐÚÜŰ] == csak betűk lehetnek a nemzetiségben (angol + magyar)

        echo '<script>alert("Adjon meg egy létező nemzetiséget!")</script>';
        return FALSE;
    }
    return TRUE;
}

function regi_csapat_kereso($jatekosid, $link){

    //amelyik csapatba utoljára igazolt a játékos az a régi csapata
    $query = sprintf("SELECT uj_csapatid FROM atigazolas WHERE jatekosid = '%s' ORDER BY datum DESC LIMIT 1", $jatekosid);
    $row = mysqli_query($link, $query) or die(mysqli_error($link));
    $data = mysqli_fetch_array($row);
    if(is_null($data)){
        //adatbázistáblába 1es csapatid-val van a "Még nincs csapata" opció
        $regi_csapatid = 1;
    }else{
        $regi_csapatid = $data['uj_csapatid'];
    }
    return $regi_csapatid;
}

function transfer_input_valid($jatekosid, $regi_csapatid, $uj_csapatid, $osszeg, $datum, $link){

    if(empty($datum)){
        echo '<script>alert("Az átigazolás hozzáadása során adja meg a dátumot!")</script>';
        return FALSE;
    }

    if($uj_csapatid == 1){
        //adatbázistáblába 1es csapatid-val van a "Még nincs csapata" opció
        echo'<script>alert("A játékos új csapata nem vehet fel Még nincs csapata értéket!")</script>';
        return FALSE;
    }

    if($uj_csapatid == 2 and $regi_csapatid == 1){
         //adatbázistáblába 1es csapatid-val van a "Még nincs csapata" opció 2es csapatid-val a "Visszavonult" opció
         //ha még nem volt csapata, akkor nem vonulhat vissza a játékos 
         echo'<script>alert("A játékos nem vonulhat vissza, ha még nem játszott egy csapatban sem!")</script>';
         return FALSE;
    }

    if($regi_csapatid == $uj_csapatid){
        echo '<script>alert("A játékos régi és új csapata az átigazolás után nem egyezhet meg!")</script>';
        return FALSE;
    }

    $check_date = mysqli_query($link, "SELECT datum FROM atigazolas WHERE jatekosid ='$jatekosid' ORDER BY datum DESC LIMIT 1") or die(mysqli_error($link));
    $max_datum = mysqli_fetch_array($check_date);
    if(!is_null($max_datum)){
    if ($max_datum['datum'] > $datum) {
        echo '<script>alert("A játékos múltbeli átigazolásait nem lehet változtatni!")</script>';
        return FALSE;
    }
    }
    return TRUE;
}

function registration_valid($felhasznalonev, $jelszo, $jelszo2, $link){

    if(empty($felhasznalonev)){
        echo '<script>alert("Töltse ki a Felhasználónév mezőt!")</script>';
        return FALSE;
    }

    if(empty($jelszo)){
        echo '<script>alert("Töltse ki a Jelszó mezőt")</script>';
        return FALSE;
    }

    if($jelszo != $jelszo2) {
        echo '<script>alert("A megadott jelszavak nem egyeznek!")</script>';
        return FALSE;
    }

    if(strlen($jelszo) < 4){
        echo '<script>alert("A jelszónak legalább 4 karakter hosszúnak kell lennie!")</script>';
        return FALSE;
    }

    $user_already_created = mysqli_query($link, "SELECT felhasznalonev FROM felhasznalo WHERE felhasznalonev ='$felhasznalonev'") or die(mysqli_error($link));
    if (mysqli_num_rows($user_already_created) > 0) {

        echo '<script>alert("Ez a felhasználónév már foglalt!")</script>';
        return FALSE;
    }

    return TRUE;
} 

function login_valid($felhasznalonev, $jelszo){
    if(empty($felhasznalonev)){
        echo '<script>alert("Töltse ki a Felhasználónév mezőt!")</script>';
        return FALSE;
    }

    if(empty($jelszo)){
        echo '<script>alert("Töltse ki a Jelszó mezőt")</script>';
        return FALSE;
    }

    return TRUE;
}
?>
