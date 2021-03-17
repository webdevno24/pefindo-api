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
}