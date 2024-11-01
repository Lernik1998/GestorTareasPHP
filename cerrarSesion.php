<?php

// Abro sesion
session_start();
// Destruyo variables de sesion
session_unset();
// Destruyo sesion
session_destroy();
// Envio al index.php que nos manda al login.php

header("Location: ./index.php");
exit();
