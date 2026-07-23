<?php

function e($string)
{
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}

function redirect($url)
{
    header("Location: $url");
    exit;
}

function isPost()
{
    return $_SERVER['REQUEST_METHOD'] === 'POST';
}

function currentYear()
{
    return date('Y');
}