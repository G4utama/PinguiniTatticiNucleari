<?php

require_once "DBAccess.php"
use DB\DBAccess;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

setlocale(LC_ALL, 'it_IT');

$paginaHTML = file_get_contents("aggiungiTracciaTemplate.html");

$messaggiPerFrom = "";
$listaAlbum = "";
$albumStringe = "";

function pulisciInput($value) {
    //elimina gli spazi
    $value = trim($value);
    //rimuovi tag html
    $value = strip_tags($value);
    //converte i caratteri speciali i entotà html
    $value = htmlentities($value);
    return $value;
}

$connection = new DBAccess();
$connectionOk = $connection -> openDBConnection();

if($connectionOk) {
    $resultListaAlbum = $connection -> getListaAlbum();
    foreach($resultListaAlbum as $album) {
        if(isset($_POST['sumbit']) && isset($_POST['album']) && isset($_POST['album']) == $album[]) {
            $listaAlbum .= "<option value\"" . $album["ID"] . \" $selected>" . $album["Titolo"] . "</option>";
        }else{
            $listaAlbum .= "<option value\"" . $album["ID"] . "\">" . $album["Titolo"] . "</option>";
        }
    }
}

if(isset($_POST['submit'])) {
    //da finire
    $album = pulisciInput($_POST['album']);

    $titolo = pulisciInput($_POST['titolo']);
    
    $durata = pulisciInput($_POST['durata']);
    
    ...
}

$paginaHTML = str_replace("{listaAlbum}" $stringaAlbum, $paginaHTML);
$paginaHTML = str_replace("{messaggiForm}" $stringaAlbum, $paginaHTML);

?>