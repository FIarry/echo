<?php
session_start();
session_destroy();
header("Location: /proekt/index.php");