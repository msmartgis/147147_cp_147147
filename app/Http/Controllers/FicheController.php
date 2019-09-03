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

        $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor('fiches/test.docx');
        $templateProcessor->setValue('OBJECT', 'Objet fr');
        $templateProcessor->setValue('NAME', 'test Name');
        $templateProcessor->saveAs('fiches/fiche.docx');
/*
        header("Content-Disposition: attachment; filename=output.docx");
        readfile($templateProcessor); // or echo file_get_contents($temp_file);
        unlink($templateProcessor);  // remove temp file*/

                /*
                // Saving the document as OOXML file...

                $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($templateProcessor, 'Word2007');
                $objWriter->save('helloWorld.docx');

                // Your browser will name the file "myFile.docx"
                // regardless of what it's named on the server
                header("Content-Disposition: attachment; filename=helloWorld.docx");
                readfile('helloWorld.docx'); // or echo file_get_contents($temp_file);
                unlink('helloWorld.docx');  // remove temp file*/


    }
}
