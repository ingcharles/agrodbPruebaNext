<?php
session_start();

if (empty($_SESSION['count'])) {
   $_SESSION['count'] = 1;
} else {
   $_SESSION['count']++;
}

?>

<p>
Hola visitante, ha visto esta p�gina <?php echo $_SESSION['count']; ?> veces.
</p>
