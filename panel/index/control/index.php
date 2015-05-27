<?php

    if (!isset($_SESSION['userAdmin']) || !$_SESSION['userAdmin']) die('Доступ закрыт');