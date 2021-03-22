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
            $xml = $this->sendPost($this->getSearchCompanyPostBody($request->all()), 'SmartSearchCompany');
            $data = $this->getSearchCompanyResult($xml);
        }else{
            $data['errors'] = $validator->errors();
        }

        return response()->json($data, $data['status'] ? 200 : 500);
    }

    public function searchIndividu(Request $request)
    {
        $data = [
            'status' => false,
            'data' => [],
            'message' => '',
        ];

        $validator = Validator::make($request->all(), [
            'id_number' => 'required',
            'full_name' => 'required|min:4',
            'date_of_birth' => 'required|date',
            'inquiry_reason' => 'required|in:ProvidingFacilities,MonitoringDebtorOrCustomer,OperationalRiskManagement,FulfilRegulationRequirements,AnotherReason',
            'inquiry_reason_text' => 'required_if:inquiry_reason,AnotherReason',
        ]);

        if (!$validator->fails()) {
            $xml = $this->sendPost($this->getSearchIndividuPostBody($request->all()), 'SmartSearchIndividual');
            $data = $this->getSearchIndividuResult($xml);
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
            $response = $this->sendPost($this->getCompanyReportPostBody($request->except('_token')), 'GetCustomReport');
            $data = $this->getCompanyReportResult($response);
        }else{
            $data['errors'] = $validator->errors();
        }

        if ($download) {
            return $data;
        }
        return response()->json($data, $data['status'] ? 200 : 500);
    }

    public function individuReport(Request $request, $download = false)
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
            $response = $this->sendPost($this->getIndividuReportPostBody($request->except('_token')), 'GetCustomReport');
            $data = $this->getIndividuReportResult($response);
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
