<?php

namespace App\Http\Controllers;
use Dompdf\Exception;
use Illuminate\Http\Request;
use PhpOffice\PhpWord\Shared\Converter;
use PhpOffice\PhpWord\Style\TablePosition;

class FicheController extends Controller
{
    public function createWordDocx(){
        // New Word Document

        $phpWord = new \PhpOffice\PhpWord\PhpWord();
        $section = $phpWord->addSection(array('marginLeft' => 700,'marginRight' => 700));
        $header = array('size' => 12, 'bold' => true,'marginBottom' => 0);
        $noSpace = array('spaceAfter' => 0);

        //$section->addText('Table with colspan and rowspan', $header);
        $styleTable = array('borderSize' => 6, 'borderColor' => '000009','align' => 'center','valign' => 'center','cellMargin' => 40);

        $myFontStyle = array('bold' => true, 'align' => 'center');
        $myFontStyle['name'] = 'Cambria';
        $myFontStyle['size'] = 14;

        $myFontStyle2 = array( 'align' => 'center');
        $myFontStyle2['name'] = 'Times New Roman';
        $myFontStyle2['size'] = 14;
        $phpWord->addTableStyle('Fancy Table', $styleTable);
        $table = $section->addTable('Fancy Table');

        $table->addRow();
        $fancyTableCellStyle = array('valign' => 'center','bgColor' => 'f2eded','valign' => 'center');
        $fancyTableCellStyle2 = array('valign' => 'center','valign' => 'center');
        $table->addCell(15000, $fancyTableCellStyle)->addText("Demandes de partenariat avec le Conseil provincial",$myFontStyle,array('align' => 'center','spaceAfter' => 0));


        $table->addRow();
        $table->addCell(10000, $fancyTableCellStyle2)->addText("Fiche de la demande",$myFontStyle2,array('align' => 'center','underline' => 'single','spaceAfter' => 0));


        //table 2
        $section->addText("");
        $phpWord->addTableStyle('Fancy Table2', $styleTable);
        $table = $section->addTable('Fancy Table2');


        $myFontStyle2['size'] = 10;

        $table->addRow();
        $table->addCell(15000, $fancyTableCellStyle2)->addText("Commune territoriale :",$myFontStyle2,$noSpace);


        //table 3
        $styleTable3 = array('align' => 'center','valign' => 'center','cellMargin' => 40);
        $cellRowSpan = array('vMerge' => 'restart', 'valign' => 'center');
        $cellRowContinue = array('vMerge' => 'continue');
        $cellColSpan = array('gridSpan' => 2, 'valign' => 'center');
        $cellHCentered = array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER);
        $cellVCentered = array('valign' => 'center');


        $cellRowSpan = array('vMerge' => 'restart');
        $section->addText("");
        $phpWord->addTableStyle('Fancy Table3', $styleTable3);
        $table = $section->addTable('Fancy Table3');


        $myFontStyle2['size'] = 10;

        $table->addRow();
        $table->addCell(1000,array('borderTopSize' => 6,'borderLeftSize' => 6))->addText('Secteur :');
        $table->addCell(5000,array('borderTopSize' => 6))->addText('Voirie');
        $table->addCell(3000,array('borderTopSize' => 6,'borderLeftSize' => 6))->addText('N° de la demande :',array('align' => 'right'));
        $table->addCell(3000,array('borderTopSize' => 6,'borderRightSize' => 6));



        $table->addRow();
        $table->addCell(1000,array('borderLeftSize' => 6));
        $table->addCell();
        $table->addCell(2500,array('borderLeftSize' => 6))->addText('Date de la réception :',array('align' => 'right'));
        $table->addCell(3000,array('borderRightSize' => 6));


        $table->addRow();
        $table->addCell(1000,array('borderLeftSize' => 6,'borderBottomSize' => 6));
        $table->addCell(1000,array('borderBottomSize' => 6));
        $table->addCell(2500,array('borderLeftSize' => 6,'borderBottomSize' => 6))->addText('Montant global en DHS :',array('align' => 'right'));
        $table->addCell(3000,array('borderRightSize' => 6,'borderBottomSize' => 6));


        //table 4
        $section->addText("");
        $section->addText('OBJET :', $header);
        $fancyTableStyle4 = array( 'cellSpacing' => 50);
        $phpWord->addTableStyle('Fancy Table4', $fancyTableStyle4);
        $table = $section->addTable('Fancy Table4');
        $myFontStyle2['size'] = 10;
        $table->addRow();
        $table->addCell(7500, array('borderTopSize' => 6));
        $table->addCell(7500, array('borderTopSize' => 6));




        $fancyTableFontStyle = array('bold' => true);
        $table->addRow();
        $table->addCell(7500, array('borderColor' => '006699','borderSize' => 6,'cellSpacing' => 50))->addText('Row 1', $fancyTableFontStyle);
        $table->addCell(7500, array('borderColor' => '006699','borderSize' => 6,'cellSpacing' => 50))->addText('Row 2', $fancyTableFontStyle);


        //table 5
        $section->addText("");
        $section->addText('PORTEUR DU PROJET  :', $header);
        $fancyTableStyle4 = array( 'cellSpacing' => 50);
        $phpWord->addTableStyle('Fancy Table4', $fancyTableStyle4);
        $table = $section->addTable('Fancy Table4');
        $myFontStyle2['size'] = 10;
        $table->addRow();
        $table->addCell(7500, array('borderTopSize' => 6));
        $table->addCell(7500, array('borderTopSize' => 6));


        //table 6
        $section->addText("");
        $section->addText('TYPE DES INTERVENTIONS :', $header);
        $phpWord->addTableStyle('Fancy Table4', $styleTable3);
        $table = $section->addTable('Fancy Table4');
        $myFontStyle2['size'] = 10;
        $table->addRow();
        $table->addCell(7500, array('borderTopSize' => 6));
        $table->addCell(7500, array('borderTopSize' => 6));




        $fancyTableFontStyle = array('bold' => true);
        $table->addRow();
        $table->addCell(15000, array('borderColor' => '006699','borderSize' => 6,'gridSpan' => 2))->addText('Row 1', $fancyTableFontStyle);




        // Saving the document as OOXML file...
        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save('helloWorld.docx');

        // Your browser will name the file "myFile.docx"
        // regardless of what it's named on the server
        header("Content-Disposition: attachment; filename=helloWorld.docx");
        readfile('helloWorld.docx'); // or echo file_get_contents($temp_file);
        unlink('helloWorld.docx');  // remove temp file


    }
}
