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

function ultimoServicio(String $actual, String $proximo): bool{
    if($actual !== $proximo){
        return true;
    }
    return false;
}

function isAuth(): void{
    if(!isset($_SESSION['login'])){
        header("Location: /");
    }
}

function isAdmin(): void{
    if(!isset($_SESSION['admin'])){
        header("Location: /");
    }
}