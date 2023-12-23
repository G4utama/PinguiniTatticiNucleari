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
    if(strlen($titolo) <= 2) {
        $messaggiPerForm .= "<li>Il titolo deve essere presente ed essere formato da almeno 3 caratteri</li>"
    }
    
    $durata = pulisciInput($_POST['durata']);
    if(strlen($durata) == 0) {
        $messaggiPerForm .= "<li>Durata del brano non presente</li>"
    }else{
        if(!preg_match("/\d{2}:\d{2}/", $durata)) {
            $messaggiPerForm .= "<li>Durata nel formato non corretto</li>"
        }
    }

    if(isset($_POST["esplicito"])) {
        if($_POST["esplicito"] == 'Yes') {
            $esplicito = 1;
        }else{
            $esplicito = 0;
        }
    }else{
        $messaggiPerForm .= "<li>Informazione sul brano esplicito non presente</li>"
    }
    
    $dataRadio = pulisciInput($_POST["dataRadio"]);
    if(strlen($dataRadio) > 0 && !preg_match("/\d{4}\-\d{2}\-\d{2}/", $dataRadio)) {
        $messaggiPerForm .= "<li>Data di uscita nel formato non corretto: " . $dataRadio . "</li>";
    }

    $urlVideo = pulisciInput($_POST["urlVideo"]);
    if(strlen($urlVideo) && !filter_var($urlVideo, FILTER_VALIDATE_URL)) {
        $messaggiPerForm .= "<li>Url del video non valido</li>"
    }

    $note = pulisciInput($_POST["note"]);

    if($messaggiPerForm == "") {
        $connessione = new DBAccess();
        $connessioneOk = $connessione -> openDBConnection();

        if($connessioneOk) {
            $resultInsert = $connessione -> insertNewTrack($album, $titolo, $durata, $esplicito, $dataRadio, $urlVideo, $note);
            if($resultInsert) {
                $messaggiPerForm = "<div id=\"greetings\"><p>Brano aggiunto correttamente</p</div>>";
            }else{
                $messaggiPerForm = "<div id=\"messageErrors\"><p>Errore nell\'inserimento del brano. Riprovare</p></div>";
            }
        }else{
            $messaggiPerForm = "<div id=\"messageErrors\"><p>Errore nella connessione al DB. Riprovare</p></div>";
        }
    }else{
        $messaggiPerForm = "<div id=\"messageErrors\"><ul>" . $messaggiPerForm . "</ul></div>";
    }
}

$connessione -> closeConnection();

$paginaHTML = str_replace("{messaggiForm}", $messaggiPerForm, $paginaHTML);
$paginaHTML = str_replace("{listaAlbum}", $listaAlbum, $paginaHTML);
$paginaHTML = str_replace("{valoreTitolo}", $titolo, $paginaHTML);
$paginaHTML = str_replace("{valoreDurata}", $durata, $paginaHTML);
if($esplicito == 1) {
    $paginaHTML = str_replace("{checkedYes}", $checked, $paginaHTML);
}
if($esplicito == 0) {
    $paginaHTML = str_replace("{checkedNo}", $checked, $paginaHTML);
}
$paginaHTML = str_replace("{checkedYes}", "", $paginaHTML);
$paginaHTML = str_replace("{checkedNo}", "", $paginaHTML);

?>