<?php

function debuguear($variable) : string {
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    exit;
}

// Escapa / Sanitizar el HTML
function sanitizar($html) : string {
    $sani = htmlspecialchars($html);
    return $sani;
}