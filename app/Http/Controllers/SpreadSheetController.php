<?php

namespace App\Http\Controllers;


use App\Demande;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IComparable;
use DB;

class SpreadSheetController extends Controller
{
    public function demandeSpread_en_cours(Request $request)
    {
        $demandes = Demande::with('porteur', 'communes', 'interventions', 'partenaires', 'session', 'point_desservis')->where([['decision', '=', 'en_cours'], ['etat', '=', 'sans']]);

        
        //filter with communes
        if ($communes_id = $request->get('communes')) {
            if ($communes_id == "all") {
            } else {
                $demandes->whereHas('communes', function ($query) use ($communes_id) {
                    $query->where('communes.id', '=', $communes_id);
                });
            }
        }

        //filter with partenaire
        if ($partenaires_id = $request->get('partenaires')) {
            if ($partenaires_id == "all") {
            } else {
                $demandes->whereHas('partenaires', function ($query) use ($partenaires_id) {
                    $query->where('partenaires_types.id', '=', $partenaires_id);
                });
            }
        }

        //filter with localites
        if ($localites = $request->get('localites')) {
            if ($localites == "all") {
            } else {
                $demandes->whereHas('point_desservis', function ($query) use ($localites) {
                    $query->where('point_desservis.nom_fr', '=', $localites);
                });
            }
        }

        //filter with session
        if ($session_id = $request->get('session')) {
            if ($session_id == "all") {
            } else {
                $demandes->where('session_id', '=', $session_id);
            }
        }

        //filter with daterange
        if ($daterange = $request->get('daterange')) {
            $daterange_splite = explode('-', $daterange);
            $date_start = $daterange_splite[0];

            $date_end = $daterange_splite[1];
            $demandes->where([
                ['date_reception', '>=', trim($date_start)],
                ['date_reception', '<=', trim($date_end)],
            ]);

        }

        //filter with intervention
        if ($interventions_id = $request->get('interventions')) {
            if ($interventions_id == "all") {
            } else {
                $demandes->whereHas('interventions', function ($query) use ($interventions_id) {
                    $query->where('interventions.id', '=', $interventions_id);
                });
            }
        }


        $demandes = $demandes->get();

        $spreadsheet = new Spreadsheet();
        foreach (range('A', 'Z') as $columnId) {
            $spreadsheet->getActiveSheet()->getColumnDimension($columnId)->setWidth(20);
        }

        $sheet = $spreadsheet->getActiveSheet();
        $sheet->getStyle('A:Z')->getAlignment()->setHorizontal('center');
        //page title
        $sheet->setCellValue('C3', "LA LISTE DES DEMANDES");
        $sheet->mergeCells('C3:E3');
        //header        
        $sheet->setCellValue('A4', "NUMERO D'ORDRE");
        $sheet->setCellValue('B4', "DATE DE RECEPTION");
        $sheet->setCellValue('C4', "OBJET FR");
        $sheet->setCellValue('D4', "OBJET AR");
        $sheet->setCellValue('E4', "PORTEUR");
        $sheet->setCellValue('F4', "حامل المشروع");
        $sheet->setCellValue('G4', "INTERVENTIONS");
        $sheet->setCellValue('H4', "MONTANT GLOBAL");
        $sheet->setCellValue('I4', "MONTANT CP");
        $sheet->setCellValue('J4', "COMMUNES");
        $sheet->setCellValue('K4', "SESSION");
        //styling title page
        $sheet->getStyle('C3')->applyFromArray(
            array(
                'font' => array(
                    'size' => 24,
                )
            )
        );

        $styleArray = [
            'font' => [
                'bold' => true,
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ],
            'borders' => [
                'top' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
                'bottom' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
                'left' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
                'right' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],

        ];

        $sheet->getStyle('A4:K4')->applyFromArray($styleArray);
        $sheet->getStyle('A4:K4')->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

        foreach (range('A', 'J') as $columnId) {
            $spreadsheet->getActiveSheet()->getColumnDimension($columnId)->setAutoSize(true);
        }

        for ($i_row_style = 5; $i_row_style <= count($demandes) + 5; $i_row_style++) {
            //boders
            $spreadsheet->getActiveSheet()->getStyle('A' . $i_row_style)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            $spreadsheet->getActiveSheet()->getStyle('B' . $i_row_style)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            $spreadsheet->getActiveSheet()->getStyle('C' . $i_row_style)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            $spreadsheet->getActiveSheet()->getStyle('D' . $i_row_style)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            $spreadsheet->getActiveSheet()->getStyle('E' . $i_row_style)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            $spreadsheet->getActiveSheet()->getStyle('F' . $i_row_style)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            $spreadsheet->getActiveSheet()->getStyle('G' . $i_row_style)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            $spreadsheet->getActiveSheet()->getStyle('H' . $i_row_style)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            $spreadsheet->getActiveSheet()->getStyle('I' . $i_row_style)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            $spreadsheet->getActiveSheet()->getStyle('J' . $i_row_style)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            $spreadsheet->getActiveSheet()->getStyle('K' . $i_row_style)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);


        }

        $row = 5;
        foreach ($demandes as $demande) {
            $sheet->setCellValue('A' . $row, $demande->num_ordre);
            $sheet->setCellValue('B' . $row, $demande->date_reception);
            $sheet->setCellValue('C' . $row, $demande->objet_fr);
            $sheet->setCellValue('D' . $row, $demande->objet_ar);
            $sheet->setCellValue('E' . $row, $demande->porteur ? str_limit($demande->porteur->nom_porteur_fr, 30, '...') : '');
            $sheet->setCellValue('F' . $row, $demande->porteur ? str_limit($demande->porteur->nom_porteur_ar, 30, '...') : '');
            $sheet->setCellValue('G' . $row, $demande->interventions->map(function ($intervention) {
                return str_limit($intervention->nom, 30, '...');
            })->implode(','));
            $sheet->setCellValue('H' . $row, number_format($demande->montant_global, 2, ',', ' '));
            $sheet->setCellValue('I' . $row, $demande->partenaires->map(function ($partenaire) {
                if ($partenaire->id == 1) {
                    return number_format($partenaire->pivot->montant, 2, ',', ' ');
                }
            })->implode(' '));

            $sheet->setCellValue('J' . $row, $demande->communes->map(function ($commune) {
                return str_limit($commune->nom_fr, 95, '...');
            })->implode(','));
            $sheet->setCellValue('K' . $row, $demande->session ? str_limit($demande->session->nom, 30, '...') : '');
            $row++;
        }

        $filename = 'sample-' . time() . '.xlsx';
// Redirect output to a client's web browser (Xlsx)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');
 
// If you're serving to IE over SSL, then the following may be needed
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public'); // HTTP/1.
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
    }



    public function demandeSpread_a_traiter(Request $request)
    {

    }



    /*
     * spreadsheet conventions
     */
    public function conventionsSpreadSheet(Request $request)
    {

    }


    public function conventionSpread(Request $request)
    {

    }
}
