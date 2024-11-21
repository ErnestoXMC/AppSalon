<?php

function debuguear($variable) : string {
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    exit;
}

// Escapa / Sanitizar el HTML
function s($html) : string {
    $sani = htmlspecialchars($html);
    return $sani;
}

function isAuth(): void{
    if(!isset($_SESSION['login'])){
        header("Location: /");
    }
}