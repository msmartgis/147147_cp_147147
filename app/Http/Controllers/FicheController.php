<?php

namespace App\Http\Controllers;
use App\Demande;
use Carbon\Carbon;
use Dompdf\Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response as FacadeResponse;
use Illuminate\Support\Facades\URL;

class FicheController extends Controller
{
    public function createWordDocx(Request $request){
        $ids = array();
        $ids = Input::get('ids');
        if($ids[0] == '')
        {
            return redirect(URL::previous())->with('error', 'Veuillez selectioner des éléments');
        }
        $array_ids = explode(',',$ids[0]);


        for($i = 0 ; $i < count($array_ids) ; $i++)
        {
            $demandes = Demande::with('communes','interventions','partenaires','point_desservis','piste','porteur','piece','sourceFinancement')->find($array_ids[$i]);

            $interventions = $demandes->interventions;
            $pieces = $demandes->piece;
            $partenaires = $demandes->partenaires;


            $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor('fiches/demandes/demande_fiche.docx');
            $templateProcessor->setValue('NUM_ORDRE', $demandes->num_ordre);
            $templateProcessor->setValue('MONTANT_GLOBAL', $demandes->montant_global);
            $templateProcessor->setValue('DATE_RECEPTION', Carbon::parse($demandes->date_reception)->format('d/m/Y'));
            $templateProcessor->setValue('OBJECT_FR', $demandes->objet_fr);
            $templateProcessor->setValue('OBJECT_AR', $demandes->objet_ar);
            $templateProcessor->setValue('PORTEUR_FR', $demandes->porteur->nom_porteur_fr);
            $templateProcessor->setValue('PORTEUR_AR', $demandes->porteur->nom_porteur_ar);
            //interventions
            $int_num = 1;
            foreach($interventions as $intervention){
                $templateProcessor->setValue('INTERVENTIONS_'.$int_num,$intervention->nom);
                $int_num++;
            }
            for($i = $int_num ; $i< 11; $i++ )
            {
                $templateProcessor->setValue('INTERVENTIONS_'.$i,'');
            }


            //pieces type
            $piece_type_num = 1;
            foreach($pieces as $piece){
                $templateProcessor->setValue('PIECE_TYPE_'.$piece_type_num,ucfirst($piece->nom) );
                $piece_type_num++;
            }

            for($i = $piece_type_num ; $i< 11; $i++ )
            {
                $templateProcessor->setValue('PIECE_TYPE_'.$i,'');
            }

            //pieces etat
            $piece_etat_num = 1;
            foreach($pieces as $piece){
                $templateProcessor->setValue('PIECE_ETAT_'.$piece_etat_num,ucfirst($piece->type) );
                $piece_etat_num++;
            }

            for($i = $piece_etat_num ; $i< 11; $i++ )
            {
                $templateProcessor->setValue('PIECE_ETAT_'.$i,'');
            }

            //montage financier
            $partenaire_num = 1;
            foreach($partenaires as $partenaire){
                $templateProcessor->setValue('PARTENAIRE_'.$partenaire_num,$partenaire->nom_fr );
                $partenaire_num++;
            }

            for($i = $partenaire_num ; $i< 11; $i++ )
            {
                $templateProcessor->setValue('PARTENAIRE_'.$i,'');
            }


            $pourcent_num = 1;
            foreach($partenaires as $partenaire){
                $templateProcessor->setValue('PT_'.$pourcent_num,($partenaire->pivot->montant / $demandes->montant_global)*100);
                $pourcent_num++;
            }

            for($i = $pourcent_num ; $i< 11; $i++ )
            {
                $templateProcessor->setValue('PT_'.$i,'');
            }


            $montant_num = 1;
            foreach($partenaires as $partenaire){
                $templateProcessor->setValue('MONTANT_'.$montant_num,$partenaire->pivot->montant );
                $montant_num++;
            }

            for($i = $montant_num ; $i< 11; $i++ )
            {
                $templateProcessor->setValue('MONTANT_'.$i,'');
            }

            $templateProcessor->saveAs('fiches/demandes/fiche.docx');
            $file = public_path()."/fiches/demandes/fiche.docx";
            $headers = array('Content-Type: application/docx');
            return FacadeResponse::download($file, 'fiche.docx',$headers)->deleteFileAfterSend(true);
        }

    }
}
