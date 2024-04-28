<?php
if(isset($_SESSION['Sucess'])){
    echo "<h1><font color=green>$_SESSION[Sucess]</font></h1>";
    unset($_SESSION['Sucess']);
}
if(isset($_SESSION['Error'])){
    echo "<h1><font color=red>$_SESSION[Error]</font></h1>";
    unset($_SESSION['Error']);
}
?>
