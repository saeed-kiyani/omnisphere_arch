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

function timeAgo($datetime)
{
    $time = time() - strtotime($datetime);

    if ($time < 60) {
        return "Just now";
    }

    if ($time < 3600) {
        return floor($time / 60) . " mins ago";
    }

    if ($time < 86400) {
        return floor($time / 3600) . " hrs ago";
    }

    if ($time < 172800) {
        return "Yesterday";
    }

    return date("d M Y", strtotime($datetime));
}