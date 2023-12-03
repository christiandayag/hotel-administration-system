<?php
include "../TCPDF/tcpdf.php";

$ref=$_GET['ref'];

include('db_connect.php');


class MYPDF extends TCPDF {

//Page header
    public function Header() {
// Logo
        $image_file = K_PATH_IMAGES.'logo_1.jpeg';
        $this->Image($image_file, 16, 13, 40, '', 'JPG', '', 'C', false, 300, '', false, false, 0, false, false, false);
//// Set font
        $this->SetFont('helvetica', 'B', 20);
// Title
        $this->Cell(0, 30, 'ASC yMandaya Hotel', 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }

// Page footer
    public function Footer() {
// Position at 15 mm from bottom
        $this->SetY(-15);
// Set font
        $this->SetFont('helvetica', 'I', 8);
// Page number
        $this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }
}

// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('ASC yMandaya Hotel');
$pdf->SetTitle('ASC yMandaya Hotel');
$pdf->SetSubject('Invoice');
$pdf->SetKeywords('');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    require_once(dirname(__FILE__).'/lang/eng.php');
    $pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set font
$pdf->SetFont('helvetica', '', 12);

// add a page
$pdf->AddPage();

$txt = <<<EOD
Cordillera Administrative Region
ymandayahotel@gmail.com
(0936) 448 3632
EOD;

// print a block of text using Write()
$pdf->Write(0, $txt, '', 0, 'C', true, 0, false, false, 0);

$d=date('d-M-y');
$invoice  = sprintf("%'.04d\n",mt_rand(1,9999999999));


if($_GET['id']){
    $id = $_GET['id'];
    $qry = $conn->query("SELECT rooms.*,room_categories.*,checked.* FROM checked left JOIN rooms on checked.room_id=rooms.id left join room_categories on rooms.category_id=room_categories.id where checked.id='$id'");
    if (mysqli_num_rows($qry) > 0) {
        $row = mysqli_fetch_assoc($qry);
        $select_cat = $conn->query("SELECT rooms.*, room_categories.* from rooms left join room_categories on rooms.category_id=room_categories.id WHERE rooms.id='". $row['room_id']."'");
        if (mysqli_num_rows($select_cat) > 0) {
            $r=mysqli_fetch_assoc($select_cat);
        }

        $date_out=$row['date_out'];
        $date_in=$row['date_in'];

        $calc_days = abs(strtotime($date_out) - strtotime($date_in)) ;
        $calc_days =floor($calc_days / (60*60*24)  );

    }

}
// set some text to print
$html =' 
<div style="margin: auto">
    <h1 style="font-family: Arial">INVOICE</h1>
    <p>'.$d.' <br>Invoice #'.$invoice.' <br>Ref #'.$ref.'</p>
    <hr>
</div>
	<table >
    <tr>
    <th><b>Reference No.</b></th>
     <th><b>Room</b></th>
      <th><b>Particulars</b></th>
       <th><b>Days</b></th>
        <th><b>Amount</b></th>
    </tr>
    <tr>
    <td>'. $ref.'</td>
    <td><b>Category:</b><br>'.$r['name'] .'<br><br><b>Room No.</b>'.$row['room'] .'</td>
    <td><b>Check-in: </b><br>'. date("M d, Y h:i A",strtotime($date_in)) .'<br><br><b>Check-out: </b><br>'. date("M d, Y h:i A",strtotime($date_out)) .'</td>
    <td>'.$calc_days .'</td>
    <td>'.number_format($row['price'],2).'</td>
    </tr>
    <tr>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    </tr>
    <tr>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    </tr>
    <tr>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    </tr>
    <tr>
    <td></td>
    <td></td>
    <td></td>
    <td><b>Vat 12%</b></td>
    <td>'.number_format($row['price'] * $calc_days *.12).'</td>
    </tr>
     <tr>
    <td></td>
    <td></td>
    <td></td>
    <td><b>Vatable Amount</b></td>
    <td>'.number_format($row['price'] * $calc_days - $row['price'] * $calc_days *.12).'</td>
    </tr>
     <tr>
    <td></td>
    <td></td>
    <td></td>
    <td><b>Total Amount</b></td>
    <td>'.number_format($row['price'] * $calc_days ,2).'</td>
    </tr>
    </table>
    <br>

';

$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output('Invoice_'.$d.'_'.$invoice.'.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+