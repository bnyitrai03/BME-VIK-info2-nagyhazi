<?php
session_start();
?>
<html>

<head>
    <?php include 'head.php' ?>
</head>

<body>
    <?php include 'menu.html'; ?>

    <div class="container">
        <main>
            <h1> Üdvözöljük <?php echo $_SESSION['felhasznalonev']; ?> a Labdarúgó Átigazolási Portálon!</h1>
        </main>

        <div class="picture">
            <img src="transzfer.png">
        </div>
    </div>

    <footer style="position: absolute; bottom: 0;">
         &#169;2023 Labdarúgó Átigazolási Portál &#9917; 
    </footer>

</body>

</html>