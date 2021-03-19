<?php

namespace App\Http\Controllers\Api;

use App\Traits\PefindoTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class PefindoController extends Controller
{
    use PefindoTrait;

    public function searchCompany(Request $request)
    {
        $data = [
            'status' => false,
            'data' => [],
            'message' => '',
        ];

        $validator = Validator::make($request->all(), [
            'npwp' => 'required',
            'company_name' => 'required|min:4',
            'inquiry_reason' => 'required|in:ProvidingFacilities,MonitoringDebtorOrCustomer,OperationalRiskManagement,FulfilRegulationRequirements,AnotherReason',
            'inquiry_reason_text' => 'required_if:inquiry_reason,AnotherReason',
        ]);

        if (!$validator->fails()) {
            $xml = $this->sendPost($this->getSearchPostBody($request->all()), 'SmartSearchCompany');
            $data = $this->getSearchResult($xml);
        }else{
            $data['errors'] = $validator->errors();
        }

        return response()->json($data, $data['status'] ? 200 : 500);
    }

    public function companyReport(Request $request, $download = false)
    {
        $data = [
            'status' => false,
            'data' => [],
            'message' => '',
        ];

        $validator = Validator::make($request->all(), [
            'pefindo_id' => 'required',
            'inquiry_reason' => 'required|in:ProvidingFacilities,MonitoringDebtorOrCustomer,OperationalRiskManagement,FulfilRegulationRequirements,AnotherReason',
            'inquiry_reason_text' => 'required_if:inquiry_reason,AnotherReason',
        ]);

        if (!$validator->fails()) {
            $response = $this->sendPost($this->getReportPostBody($request->except('_token')), 'GetCustomReport');
            $data = $this->getReportResult($response);
        }else{
            $data['errors'] = $validator->errors();
        }

        if ($download) {
            return $data;
        }
        return response()->json($data, $data['status'] ? 200 : 500);
    }

    public function companyReportPdf(Request $request)
    {
        $data = $this->companyReport($request, true);
        // return view('report', $data);
        $dompdf = \PDF::loadView('report', $data);
        $dompdf->setPaper('Letter', 'landscape');
        return $dompdf->download('report.pdf');
    }
}
