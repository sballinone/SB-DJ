<?php
//============================================================+
// License: GNU-LGPL v3 (http://www.gnu.org/copyleft/lesser.html)
// -------------------------------------------------------------------
// Copyright (C) 2016 Nils Reimers - PHP-Einfach.de
// This is free software: you can redistribute it and/or modify it
// under the terms of the GNU Lesser General Public License as
// published by the Free Software Foundation, either version 3 of the
// License, or (at your option) any later version.
//
// Nachfolgend erhaltet ihr basierend auf der open-source Library TCPDF (https://tcpdf.org/)
// ein einfaches Script zur Erstellung von PDF-Dokumenten, hier am Beispiel einer Rechnung.
// Das Aussehen der Rechnung ist mittels HTML definiert und wird per TCPDF in ein PDF-Dokument übersetzt. 
// Die meisten HTML Befehle funktionieren sowie einige inline-CSS Befehle. Die Unterstützung für CSS ist 
// aber noch stark eingeschränkt. TCPDF läuft ohne zusätzliche Software auf den meisten PHP-Installationen.
// Gerne könnt ihr das Script frei anpassen und auch als Basis für andere dynamisch erzeugte PDF-Dokumente nutzen.
// Im Ordner tcpdf/ befindet sich die Version 6.2.3 der Bibliothek. Unter https://tcpdf.org/ könnt ihr erfahren, ob 
// eine aktuellere Variante existiert und diese ggf. einbinden.
//
// Weitere Infos: http://www.php-einfach.de/experte/php-codebeispiele/pdf-per-php-erstellen-pdf-rechnung/ | https://github.com/PHP-Einfach/pdf-rechnung/


$rechnungs_nummer = $invoiceNumber;
$rechnungs_datum = date("d. M Y");
$lieferdatum = date("d.m.Y");
$pdfAuthor = "Saskia Brückner · World of SB Kreativagentur";

$rechnungs_header = '
<img src="./assets/img/logo/black/Logo-Full.png" style="height: 50px;"><br>
Saskia Brückner
World of SB Kreativagentur
Reichenberger Straße 21
D-71638 Ludwigsburg';

$rechnungs_empfaenger = $invoiceRecipient;

$rechnungs_footer = "Vielen Dank für deinen Kauf. Deine Rechnung wurde bereits online beglichen. Die neue Laufzeit haben wir deinem Konto gutgeschrieben. Viel Spaß bei deiner Reiseplanung mit SB Viatges.

Neue Laufzeit: ".date('d.m.Y',strtotime($validLicense))."



<small>Saskia Brückner · World of SB Kreativagentur<br />Reichenberger Straße 21 · 71638 Ludwigsburg · Deutschland<br />info@saskiabrueckner.com · www.sbviatges.com · USt-ID: (in Gründung)</small>";

//Auflistung eurer verschiedenen Posten im Format [Produktbezeichnuns, Menge, Einzelpreis]
$rechnungs_posten = $invoiceItems;

//Höhe eurer Umsatzsteuer. 0.19 für 19% Umsatzsteuer
if(date('Y') == "2020") {
	$umsatzsteuer = 0.16; 
} else {
	$umsatzsteuer = 0.19; 
}

$pdfName = "SBV".$rechnungs_nummer.".pdf";


//////////////////////////// Inhalt des PDFs als HTML-Code \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\


// Erstellung des HTML-Codes. Dieser HTML-Code definiert das Aussehen eures PDFs.
// tcpdf unterstützt recht viele HTML-Befehle. Die Nutzung von CSS ist allerdings
// stark eingeschränkt.

$html = '
<font face="PT Sans">
<table cellpadding="5" cellspacing="0" style="width: 100%; ">
	<tr>
		<td><br /><br /><br /><br /><br /><br />'.nl2br(trim($rechnungs_empfaenger)).'</td>
	   <td style="text-align: right">
	   '.nl2br(trim($rechnungs_header)).'<br><br><br>
Rechnung SBV'.$rechnungs_nummer.'<br>
'.$rechnungs_datum.'<br>
		</td>
	</tr>

	<tr>
		 <td style="font-size:1.3em; font-weight: bold;">
<br><br>
Rechnung · Invoice
<br>
		 </td>
	</tr>


	<tr>
		<td colspan="2"></td>
	</tr>
</table>
<br><br><br>

<table cellpadding="5" cellspacing="0" style="width: 100%;" border="0">
	<tr style="background-color: #cccccc; padding:5px;">
		<td width="50%" style="padding:5px;"><b>Bezeichnung</b></td>
		<td width="15%" style="text-align: center;"><b>Menge</b></td>
		<td width="15%" style="text-align: center;"><b>Einzelpreis</b></td>
		<td width="20%" style="text-align: center;"><b>Preis</b></td>
	</tr>';
			
	
$gesamtpreis = 0;

foreach($rechnungs_posten as $posten) {
	$menge = $posten[1];
	$einzelpreis = $posten[2];
	$preis = $menge*$einzelpreis;
	$gesamtpreis += $preis;
	$html .= '<tr>
                <td width="50%">'.$posten[0].'</td>
				<td width="15%" style="text-align: center;">'.$posten[1].'</td>		
				<td width="15%" style="text-align: center;">'.number_format($posten[2], 2, ',', '').' €</td>	
                <td width="20%" style="text-align: center;">'.number_format($preis, 2, ',', '').' €</td>
              </tr>';
}
$html .="</table>";



$html .= '
<hr>
<table cellpadding="5" cellspacing="0" style="width: 100%;" border="0">';
if($umsatzsteuer > 0) {
	$netto = $gesamtpreis / (1+$umsatzsteuer);
	$umsatzsteuer_betrag = $gesamtpreis - $netto;
	
	$html .= '
			<tr>
				<td colspan="3" width="80%">Zwischensumme (Netto)</td>
				<td style="text-align: center;" width="20%">'.number_format($netto , 2, ',', '').' €</td>
			</tr>
			<tr>
				<td colspan="3" width="80%">Umsatzsteuer ('.intval($umsatzsteuer*100).'%)</td>
				<td style="text-align: center;" width="20%">'.number_format($umsatzsteuer_betrag, 2, ',', '').' €</td>
			</tr>';
}

$html .='
            <tr>
                <td colspan="3" width="80%"><b>Gesamt: </b></td>
                <td style="text-align: center;" width="20%"><b>'.number_format($gesamtpreis, 2, ',', '').' €</b></td>
            </tr>			
        </table>
<br><br><br>';

if($umsatzsteuer == 0) {
	$html .= 'Nach § 19 Abs. 1 UStG wird keine Umsatzsteuer berechnet.<br><br>';
}

$html .= nl2br($rechnungs_footer);
$html .= "</font>";



//////////////////////////// Erzeugung eures PDF Dokuments \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\

// TCPDF Library laden
require_once('./assets/external/pdf-rechnung-master/tcpdf/tcpdf.php');

// Erstellung des PDF Dokuments
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// Dokumenteninformationen
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor($pdfAuthor);
$pdf->SetTitle('Rechnung '.$rechnungs_nummer);
$pdf->SetSubject('Rechnung '.$rechnungs_nummer);


// Header und Footer Informationen
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// Auswahl des Font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// Auswahl der MArgins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// Automatisches Autobreak der Seiten
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// Image Scale 
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// Schriftart
$pdf->SetFont('dejavusans', '', 10);

// Neue Seite
$pdf->AddPage();

// Fügt den HTML Code in das PDF Dokument ein
$pdf->writeHTML($html, true, false, true, false, '');

//Ausgabe der PDF

//Variante 1: PDF direkt an den Benutzer senden:
//$pdf->Output($pdfName, 'I');

//Variante 2: PDF im Verzeichnis abspeichern:
$pdf->Output(getcwd().'/user_upload/'.$hash."/".$pdfName, 'F');

?>
