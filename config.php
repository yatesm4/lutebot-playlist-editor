<?php
/**
 * Various configs / settings for application
 */

/* ---------- GLOBALS ---------- */

$_UPLOADS = null;
$_RESULTS = array();

/* ---------- FUNCTIONS ---------- */

function is_mime($file, $mime)
{
    try {
        $file_type = strtolower(pathinfo($file, PATHINFO_EXTENSION));
        // collect results
        $is_mime = $file_type == $mime;
        return [
            "mime_type"     => $file_type,  // the MIME type of the file
            "mime_valid"    => $is_mime,    // is it the specified argument mime type
            "message"       => $is_mime     // user friendly message
                ? "VALID"
                : "INVALID"
        ];
    }
    catch(Exception $ex) {
        return [
            "mime_type" => null,
            "mime_valid" => false,
            "message" => $ex->getMessage()
        ];
    }
}

function validate_file($file, $mime)
{
    $result = file_validation_result_model();
    $result["mime_check"] = is_mime($file, $mime);
    return $result;
}

function file_validation_result_model()
{
    return [
        "mime_check" => null
    ];
}

?>