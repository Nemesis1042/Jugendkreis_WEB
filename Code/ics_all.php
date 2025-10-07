<?php
require_once "config.php";

$events = $db->query("SELECT * FROM events WHERE date <> '0000-00-00' ORDER BY date ASC")->fetchAll(PDO::FETCH_ASSOC);

$lines = [];
$lines[] = "BEGIN:VCALENDAR";
$lines[] = "VERSION:2.0";
$lines[] = "PRODID:-//Jugendkreis Aulendorf//DE";

foreach ($events as $e) {
    $title = preg_replace("/\r|\n/", " ", html_entity_decode($e['title'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'));
    $desc  = preg_replace("/\r|\n/", "\\n", strip_tags($e['desc']));
    $date  = date("Ymd", strtotime($e['date']));
    $start = $date . "T190000";
    $end   = $date . "T210000";

    $lines[] = "BEGIN:VEVENT";
    $lines[] = "UID:all-" . (int)$e['id'] . "@jugendkreis-aule.com";
    $lines[] = "DTSTAMP:" . gmdate("Ymd\THis\Z");
    $lines[] = "DTSTART:$start";
    $lines[] = "DTEND:$end";
    $lines[] = "SUMMARY:$title";
    $lines[] = "DESCRIPTION:$desc";
    $lines[] = "LOCATION:Dobelmühle, Aulendorf";
    $lines[] = "END:VEVENT";
}

$lines[] = "END:VCALENDAR";

header('Content-Type: text/calendar; charset=utf-8');
header('Content-Disposition: attachment; filename="jugendkreis_alle_termine.ics"');
echo implode("\n", $lines);
