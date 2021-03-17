<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Traits\PefindoTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class PefindoController extends Controller
{
    use PefindoTrait;

    public function smartSearchCompany(Request $request)
    {
        $response = $this->sendPost($this->getSearchPostBody($request->except('_token')), 'SmartSearchCompany');
        $data = $this->getSearchResult($response);
        // return [$data];
        return view('welcome', [
            'search_data' => $data,
        ])->withInput($request->except('_token'));
    }

    public function customReport(Request $request)
    {
        $response = $this->sendPost($this->getReportPostBody($request->except('_token')), 'GetCustomReport');
        $data = $this->getReportResult($response);
        // dd($data);
        // return Response::make($this->xmlToArray($response), 200, ['Content-Type' => 'text/xml']);
        return view('report', $data);
    }
}
