<?php

/* Get resultant XML from the HTML on a page
 * V 1.0 of this method uses file_get_contents
 * I'll add in 'flick' methods to use other
 * HTML retrieval methods when I get the chance
 */

function getXMLFromHTML($link)
{

    for($i=0;$i<10;$i++){
        $html = file_get_contents($link);
        if ($html) break;
    }
    if ($html){
        $doc = new DomDocument();
        @$doc->loadHTML($html);
        $xml = simplexml_import_dom($doc);

        if ($xml) return $xml;
    }
}