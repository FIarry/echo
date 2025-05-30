<?php
session_start();
session_destroy();
header("Location: /echo/index.php");
