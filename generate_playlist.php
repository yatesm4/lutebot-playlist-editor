<?php
include 'config.php';

$fcount = count($_FILES['files']['name']);
if($fcount <= 0) { return; }

$plname = $_POST['playlistName'] ?? "MyPlaylist.xml";
$plname .= $_POST['playlistName'] != null ? ".xml" : "";
$plpath = $_POST['pathName'] ?? "";

//header('Content-Disposition: attachment; filename="'.$plname.'"');
//header('Content-Type: text/xml');

$xml = new DOMDocument();
$xml->formatOutput = true;
$xml->preserveWhiteSpace = true;

// load template file
$xml->load('playlist_template.xml');

// get container for playlist items
$playListItemsArray = $xml->getElementsByTagName('ArrayOfPlayListItem')[0];

// apend playlist items to the xml file
for($i = 0; $i < $fcount; $i++)
{
    // Validate the file
    $filev = validate_file($_FILES['files']['name'][$i], 'mid');

    // Process validation results
    if ($filev["mime_check"]["mime_valid"] == true) { } else { continue; }

    // Create Playlist Item element in xml doc
    $pli = $xml->createElement("PlayListItem");
    
    // Append name elm with the MIDI filename
    $pli_name = $xml->createElement("Name", substr_replace($_FILES['files']['name'][$i],"",-4));
    $pli->appendChild($pli_name);

    // Append path elm with the MIDI files path ON THE CLIENT SIDE
    $pli_path = $xml->createElement("Path", $plpath."\\".$_FILES['files']['name'][$i]);
    $pli->appendChild($pli_path);

    // Append isactive elm 
    $pli_ia = $xml->createElement("IsActive", "false");
    $pli->appendChild($pli_ia);

    // Add to array
    $playListItemsArray->appendChild($pli);
}

// do some whack ass formatting sheit and return the formatted xml doc
$outputXML = $xml->saveXML();
$xml = new DOMDocument();
$xml->preserveWhiteSpace = false;
$xml->formatOutput = true;
$xml->loadXML($outputXML);
$outputXML = $xml->saveXML();
echo $outputXML;
?>