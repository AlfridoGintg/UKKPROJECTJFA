<?php

function check()
{
    return isset($_SESSION['role']);
}

function user()
{
    return $_SESSION['user'] ?? null;
}


