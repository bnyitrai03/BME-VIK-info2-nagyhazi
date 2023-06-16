# BME-VIK-info2-nagyhazi
# Specifikáció

## Feladat informális leírása

A feladat célja labdarúgók átigazolásait tartalmazó adatbázis kezelése. Eltárolni és megjeleníteni tudjuk labdarúgók tulajdonságait pl. érték, emellett tárolunk csapatokat is. Az átigazolás oldalon megnézhetjük, hogy melyik játékos mikor, hova és mennyi pénzért igazolt el.

## Elérhető funkciók 

Az alkalmazás következő funkciókat biztosítja:

* Játékosok kezelése:
    - Új játékos létrehozása
    - Meglévő játékos adatainak módosítása
    - Játékos törlése
    - Tárolt játékosok listázása, keresés a nevük alapján

*	Csapatok kezelése:
    - Új csapat létrehozása
    -	Meglévő csapat adatainak módosítása
    -	Csapat törlése
    -	Csapatok listázása
    
*	Átigazolások kezelése:
    -	Új átigazolás létrehozása
    -	Átigazolás módosítása
    -	Átigazolás törlése
    -	Keresés dátum alapján
    
*	Felhasználó kezelése:
    -	felhasználó azonosítása névvel, jelszóval
    -	skin választás
    -	választott skin elmentése felhasználónként

## Adatbázis séma

Az adatbázisban a következő entitásokat és attribútumokat tároljuk:

*	Játékos: név, érték, nemzetiség
*	Csapat: név, nemzetiség
*	Átigazolás: régi csapat, új csapat, összeg, dátum
*   Felhasználó: felhasználónév, jelszó, skin

A fenti adatok tárolását az alábbi sémával oldjuk meg:
![image](https://user-images.githubusercontent.com/126956031/236509332-8d942d70-d9cc-4022-b8de-6e80db74471b.png)

