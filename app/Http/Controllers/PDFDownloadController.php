<?php

namespace App\Http\Controllers;

use App\Models\SuretyBond;
use App\Models\Template;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class PDFDownloadController extends Controller
{
    public function pdf($id, $text)
    {
        $template = Template::find($id);
        $data = ['content' => $template->text,];
        $pdf = Pdf::loadView('pdf', $data);
        $pdf->getDomPDF()->setBasePath(public_path('pdf/'));
        $fileName =  $template->title . '.' . 'pdf';

        return $pdf->download($fileName);
    }

    public function pdfTemplate(Request $request)
    {
        $data = ['content' => $request->preview];
        $pdf = Pdf::loadView('pdf', $data);
        $pdf->getDomPDF()->setBasePath(public_path('pdf/'));
        $fileName =  date("Ymd").time() . '.' . 'pdf';

        return $pdf->download($fileName);
    }

    public function pdfSB(Request $request)
    {
        $params = [
            'startDate' => $request->startDate,
            'endDate' => $request->endDate,
        ];
        // for($i=1;$i<count($request->columns)+1;$i++){
        //     array_push($params,[
        //         "columns[".$i."][name]" => $request->columns[$i]['name'],
        //         "columns[".$i."][operator]" => $request->columns[$i]['operator'],
        //         "columns[".$i."][value]" => $request->columns[$i]['value']
        //     ]);
        // }

        $query = SuretyBond::table('product',$params)->get()->toArray();
        $insurance_net_total = 0;
        $insurance_polish_cost_total = 0;
        $insurance_stamp_cost_total = 0;
        $insurance_net_total_all = 0;
        $admin_charge_total = 0;
        $service_charge_total = 0;
        $total_charge_total = 0;
        $insurance_value_total = 0;
        $laba_total = 0;
        for($i=0;$i<count($query);$i++){
            $temp = SuretyBond::find($query[$i]->id);
            if($temp->last_status->status->name == 'terbit'){
                $insurance_net_total += $temp->insurance_net;
                $service_charge_total += $temp->service_charge;
            }
            if($temp->last_status->status->name == 'terbit' || $temp->last_status->status->name == 'batal' || $temp->last_status->status->name == 'revisi'){
                $admin_charge_total += $temp->admin_charge;
                $total_charge_total += $temp->total_charge;
            }
            $insurance_value_total += $temp->insurance_value;
            $insurance_polish_cost_total += $temp->insurance_polish_cost;
            $insurance_stamp_cost_total += $temp->insurance_stamp_cost;
            $insurance_net_total_all += $temp->insurance_net_total;

            $query[$i]->status = $temp->last_status->status->name;
            $query[$i]->laba = $temp->total_charge - $temp->insurance_net_total;
            if($temp->last_status->status->name == 'terbit' || $temp->last_status->status->name == 'batal' || $temp->last_status->status->name == 'revisi'){
                $laba_total += $query[$i]->laba;
            }else{
                $laba_total += $temp->insurance_net_total;
            }
        }
        // dd($query);
        $data = [
            'content' => $query,
            'nett_premi' => $insurance_net_total,
            'biaya_polis' => $insurance_polish_cost_total,
            'materai' => $insurance_stamp_cost_total,
            'total_nett_premi' => $insurance_net_total_all,
            'total_nett_kantor' => $service_charge_total,
            'admin' => $admin_charge_total,
            'total_kantor' => $total_charge_total,
            'laba' => $laba_total,
            'nilai_bond' => $insurance_value_total,
        ];

        $pdf = Pdf::loadView('pdf_produksi', $data);
        $customPaper = array(0,0,1300,1300);
        $pdf->getDomPDF()->setBasePath(public_path('pdf/'))->setPaper($customPaper, 'landscape');
        $fileName =  date("Ymd").time() . '.' . 'pdf';

        return $pdf->download($fileName);
    }
}
