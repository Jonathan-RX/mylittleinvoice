<?php
	/*
		This file is part of MyLittleInvoice.

    MyLittleInvoice is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License.

    MyLittleInvoice is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with Foobar.  If not, see <http://www.gnu.org/licenses/>
		*/
include('include/fpdf/fpdf.php');

include('config.php');

		 global $bd;
		 if(!empty($_GET['id_quote'])){$type_doc = 'quote';$id_doc = $_GET['id_quote'];}
		 if(!empty($_GET['id_invoice'])){$type_doc = 'invoice';$id_doc = $_GET['id_invoice'];}
	     // Enregistrement d'un nouveau devis
	     if(!empty($_GET['id_quote']) OR !empty($_GET['id_invoice'])){
		     $results = $bd->get_results('SELECT * FROM ' . $bd->prefix . $type_doc . 's where id="' . $id_doc . '"');
		     $results = $results[0];
		     $customer = unserialize($results->customer);
	     }else{
		     $customer = array('Prénom et nom',
						     'Adresse ',
						     'Complément d\'adresse',
						     'Code postal et ville',
						     'Téléphone',
						     'Mail');
						     $results = new stdClass;
						     $results->id = '00000';
	     } 
	     
	     // Chargement des infos vendeur
	     $entreprise = $bd->get_results('SELECT * FROM ' . $bd->prefix . 'options WHERE option_name = "entreprise_contact"');
	     $entreprise = unserialize($entreprise[0]->option_value);
class PDF extends FPDF
{

    function RoundedRect($x, $y, $w, $h, $r, $corners = '1234', $style = '')
    {
        $k = $this->k;
        $hp = $this->h;
        if($style=='F')
            $op='f';
        elseif($style=='FD' || $style=='DF')
            $op='B';
        else
            $op='S';
        $MyArc = 4/3 * (sqrt(2) - 1);
        $this->_out(sprintf('%.2F %.2F m',($x+$r)*$k,($hp-$y)*$k ));

        $xc = $x+$w-$r;
        $yc = $y+$r;
        $this->_out(sprintf('%.2F %.2F l', $xc*$k,($hp-$y)*$k ));
        if (strpos($corners, '2')===false)
            $this->_out(sprintf('%.2F %.2F l', ($x+$w)*$k,($hp-$y)*$k ));
        else
            $this->_Arc($xc + $r*$MyArc, $yc - $r, $xc + $r, $yc - $r*$MyArc, $xc + $r, $yc);

        $xc = $x+$w-$r;
        $yc = $y+$h-$r;
        $this->_out(sprintf('%.2F %.2F l',($x+$w)*$k,($hp-$yc)*$k));
        if (strpos($corners, '3')===false)
            $this->_out(sprintf('%.2F %.2F l',($x+$w)*$k,($hp-($y+$h))*$k));
        else
            $this->_Arc($xc + $r, $yc + $r*$MyArc, $xc + $r*$MyArc, $yc + $r, $xc, $yc + $r);

        $xc = $x+$r;
        $yc = $y+$h-$r;
        $this->_out(sprintf('%.2F %.2F l',$xc*$k,($hp-($y+$h))*$k));
        if (strpos($corners, '4')===false)
            $this->_out(sprintf('%.2F %.2F l',($x)*$k,($hp-($y+$h))*$k));
        else
            $this->_Arc($xc - $r*$MyArc, $yc + $r, $xc - $r, $yc + $r*$MyArc, $xc - $r, $yc);

        $xc = $x+$r ;
        $yc = $y+$r;
        $this->_out(sprintf('%.2F %.2F l',($x)*$k,($hp-$yc)*$k ));
        if (strpos($corners, '1')===false)
        {
            $this->_out(sprintf('%.2F %.2F l',($x)*$k,($hp-$y)*$k ));
            $this->_out(sprintf('%.2F %.2F l',($x+$r)*$k,($hp-$y)*$k ));
        }
        else
            $this->_Arc($xc - $r, $yc - $r*$MyArc, $xc - $r*$MyArc, $yc - $r, $xc, $yc - $r);
        $this->_out($op);
    }

    function _Arc($x1, $y1, $x2, $y2, $x3, $y3)
    {
        $h = $this->h;
        $this->_out(sprintf('%.2F %.2F %.2F %.2F %.2F %.2F c ', $x1*$this->k, ($h-$y1)*$this->k,
            $x2*$this->k, ($h-$y2)*$this->k, $x3*$this->k, ($h-$y3)*$this->k));
    }

// En-tête
public $entreprise = '';
public $doc = '';
public $customer = '';
public $nbr_pages = 1;
public $doc_type = '';
function Header()
{
    // Logo
    global $bd;
    $this->SetLineWidth('0.1');
    $logo = $bd->get_option('logo');
    $info_logo = getimagesize($logo);
    $w = $info_logo[0];
    $h = $info_logo[1];
    if ($w > 48){
	    $h = round($h*(4800/$w)/100);
	    $w = 48;
	}
	if ($h > 48){
		$w = round($w*(4800/$h)/100);
	    $h = 48;
	}
	$h = $h/3.8;
	$w = $w/3.8;
	$hp = $h/2;
	$wp = $w/2;
    $this->SetDrawColor('228','228','228');
    $this->Line('10','20','200','20');
    $this->Image($logo,$wp,$hp,$w,$h);
    // Police Arial gras 15
    //$this->SetFont('Helvetica','',15);
    $this->AddFont('SourceSansPro','','SourceSansPro-Light.php');
    $this->AddFont('SourceSansProBold','','SourceSansPro-Bold.php');
    $this->SetFont('SourceSansPro','',16);
    // Police Awesome font
    // Décalage à droite
    $this->Cell(16);
    // Titre
    $this->Text(19,17,$this->entreprise['name'],0,0,'C');
    
    $this->SetFont('SourceSansPro','',9);
    $this->SetTextColor('102','102','102');
    $this->Text(175,16, 'Date: '.$this->doc->date,0,0,'C');
    
    // Saut de ligne
    $this->Ln(20);
    $count = 28;
    $this->SetFont('SourceSansPro','',10.5);
    foreach($this->customer as $c){
	    $this->Text(10,$count, iconv('UTF-8', 'windows-1252', $c),0,0,'C');
	    $count = $count+5;
    }
    $this->SetFont('SourceSansProBold','',10);
    if($this->doc_type == 'quote'){
    	$this->Text(141,28, iconv('UTF-8', 'windows-1252', 'Devis n°'),0,0,'C');
    $this->SetFont('SourceSansPro','',10);
    $this->Text(154,28, iconv('UTF-8', 'windows-1252', $this->doc->id),0,0,'C');
    }elseif($this->doc_type == 'invoice'){
		$this->Text(141,28, iconv('UTF-8', 'windows-1252', 'Facture n°'),0,0,'C');
    $this->SetFont('SourceSansPro','',10);
    $this->Text(158,28, iconv('UTF-8', 'windows-1252', $this->doc->id),0,0,'C');
    } 
    $this->SetFont('SourceSansProBold','',10);
    $this->Text(141,38, iconv('UTF-8', 'windows-1252', 'N° de commande: '),0,0,'C');
    $this->SetFont('SourceSansPro','',10);
    $this->Text(169,38, iconv('UTF-8', 'windows-1252', $this->doc->order_number),0,0,'C');
    $this->SetFont('SourceSansProBold','',10);
    if($this->doc_type == 'quote'){
    $this->Text(141,42, iconv('UTF-8', 'windows-1252', 'Echéance du devis: '),0,0,'C');
    $this->SetFont('SourceSansPro','',10);
    $this->Text(171,42, iconv('UTF-8', 'windows-1252', $this->doc->date_end),0,0,'C');
    }elseif($this->doc_type == 'invoice'){
    $this->Text(141,42, iconv('UTF-8', 'windows-1252', 'Echéance de règlement: '),0,0,'C');
    $this->SetFont('SourceSansPro','',10);
    $this->Text(179,42, iconv('UTF-8', 'windows-1252', $this->doc->date_end),0,0,'C');
    } 
    $this->SetFont('SourceSansProBold','',10);
    $this->Text(141,47, iconv('UTF-8', 'windows-1252', 'Compte client: '),0,0,'C');
    $this->SetFont('SourceSansPro','',10);
    $this->Text(165,47, iconv('UTF-8', 'windows-1252', $this->doc->customer_id),0,0,'C');
    // Entête du tableau
    $this->SetFont('SourceSansProBold','',10);
    $this->Text(12,64, iconv('UTF-8', 'windows-1252', 'Qty'),0,0,'C');
    $this->Text(22,64, iconv('UTF-8', 'windows-1252', 'Référence'),0,0,'C');
    $this->Text(50,64, iconv('UTF-8', 'windows-1252', 'Description'),0,0,'C');
    $this->Text(126,64, iconv('UTF-8', 'windows-1252', 'Prix unit.'),0,0,'C');
	$this->Text(154,64, iconv('UTF-8', 'windows-1252', 'TVA (%)'),0,0,'C');
	$this->Text(173,64, iconv('UTF-8', 'windows-1252', 'Sous total'),0,0,'C');
	$this->SetDrawColor('228','228','228');
    $this->Line('10',67,'200',67);
}

// Pied de page
function Footer()
{
    // Positionnement à 1,5 cm du bas
    $this->SetY(-15);
    // Police Arial italique 8
    $this->AddFont('SourceSansPro','','SourceSansPro-Light.php');
    $this->AddFont('SourceSansProBold','','SourceSansPro-Bold.php');
    $this->SetFont('SourceSansPro','',12);
    $this->Text(18,211, iconv('UTF-8', 'windows-1252', 'Méthodes de règlement :'),0,0,'C');
    $this->Text(107,211, iconv('UTF-8', 'windows-1252', 'Montant total :'),0,0,'C');
    $this->SetFont('SourceSansProBold','',10);
    $this->Text(109,223, iconv('UTF-8', 'windows-1252', 'Sous-total HT :'),0,0,'C');
    $this->Text(109,232, iconv('UTF-8', 'windows-1252', 'TVA :'),0,0,'C');
    $this->Text(109,241
    , iconv('UTF-8', 'windows-1252', 'Total :'),0,0,'C');
    // Box info de règlement
    $this->Image('dist/img/credit/visa.png',18,216,0);
    $this->Image('dist/img/credit/mastercard.png',33,216,0);
    $this->Image('dist/img/credit/american-express.png',48,216,0);
    $this->Image('dist/img/credit/paypal2.png',63,216,0);
    $this->SetDrawColor('210','210','210');
    $this->RoundedRect(18, 227, 85, 45, 1, '1234', 'DF');
    $this->SetXY('20','-69');
    $this->SetFont('SourceSansPro','',8);
    $this->SetRightMargin('115');
    $this->SetLeftMargin('20');
    $text = str_replace(array('<br>','<p>','</p>','<b>','</b>'),array('
','','','',''),iconv('UTF-8', 'windows-1252', $this->doc->infos));
    $this->Write('6',$text);
    //$this->Cell('74','20',iconv('UTF-8', 'windows-1252', $this->doc->infos));
    // Numéro de page
    $this->SetDrawColor('249','249','249');
    $this->Line('10','275','200','275');
    $c = count(unserialize($this->doc->products));
    $c=ceil($c/15);
    $this->Text(191,290,'Page '.$this->PageNo().'/'.$c);
    $this->SetXY(0,-20);
    $this->SetFont('SourceSansPro','',9);
    $text = str_replace(array('<br>','<p>','</p>','<b>','</b>'),array('
','','','',''),iconv('UTF-8', 'windows-1252', $this->doc->footer_infos));
    $this->SetRightMargin('0');
    $this->MultiCell(0,4,$text,0,'C');
    }
}

// Instanciation de la classe dérivée
$pdf = new PDF();
$pdf->entreprise = $entreprise;
$pdf->doc = $results;
$pdf->customer = $customer;
$pdf->doc_type = $type_doc;
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->AddFont('SourceSansPro','','SourceSansPro-Light.php');
$pdf->AddFont('SourceSansProBold','','SourceSansPro-Bold.php');
	$pdf->SetFont('SourceSansPro','',10);
	$count = 73;
	$count_2 = 1;
	$total_products = 0;
	$total_taxes = 0;
foreach(unserialize($results->products) as $p){
	$taxes = $p['price']*($p['taxes']/100);
	if($p['qty'] == ''){
		$total = '';
	}else{
		$total = number_format(($taxes+$p['price'])*$p['qty'],2).$bd->get_option('money_symbole');
	}
	$total_products += $p['price']*$p['qty'];
	$total_taxes += $taxes*$p['qty'];
	if($count_2 > 15){
		$pdf->AddPage();
		$count = 73;
		$count_2 = 1;
		$pdf->nbr_pages = $pdf->nbr_pages+1;
	}
	if($count_2&1){
		$pdf->SetDrawColor('249','249','249');
		$pdf->SetFillColor('249','249','249');
		$pdf->Rect(10,$count-6,190,10,'F');
	}
    $pdf->Text(12,$count, iconv('UTF-8', 'windows-1252', $p['qty']),0,0,'C');
    $pdf->Text(22,$count, iconv('UTF-8', 'windows-1252', $p['ref']),0,0,'C');
    $pdf->Text(50,$count, iconv('UTF-8', 'windows-1252', $p['description']),0,0,'C');
    $pdf->Text(126,$count, iconv('UTF-8', 'windows-1252', $p['price']),0,0,'C');
	$pdf->Text(154,$count, iconv('UTF-8', 'windows-1252', $p['taxes']),0,0,'C');
	$pdf->Text(173,$count, iconv('UTF-8', 'windows-1252', $total),0,0,'C');
	
	$count = $count+9;
	$count_2 += 1;
}
// Affichage du total
	$pdf->SetAutoPageBreak('true',0.1);
	$pdf->SetFont('SourceSansPro','',10);
    $pdf->Text(150,223, iconv('UTF-8', 'windows-1252', number_format($total_products,2).'€'),0,0,'C');
    $pdf->Text(150,232, iconv('UTF-8', 'windows-1252', number_format($total_taxes,2) . '€'),0,0,'C');
    $pdf->Text(150,241
    , iconv('UTF-8', 'windows-1252', number_format($total_products+$total_taxes,2) . '€'),0,0,'C');
    $pdf->SetDrawColor('249','249','249');
    
$pdf->Output();
?>