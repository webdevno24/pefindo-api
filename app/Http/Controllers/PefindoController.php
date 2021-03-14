<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PefindoController extends Controller
{
    public function smartSearchCompany(Request $request)
    {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => 'https://cbs5bodemo2.pefindobirokredit.com/WsReport/v5.53/Service.svc',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>$this->getSearchPostBody($request->except('_token')),
            CURLOPT_HTTPHEADER => array(
                'Content-Type: text/xml',
                'SoapAction: http://creditinfo.com/CB5/IReportPublicServiceBase/SmartSearchCompany',
                'Authorization: Basic ZGVtb2Zpbl8zOlRlc3RpbmdAMQ=='
            ),
        ]);

        $response = curl_exec($curl);
        $response = str_replace(['s:', 'a:', 'i:'], '', $response);
        curl_close($curl);

        $data = $this->getSearchResultJson($response);
        // return [$data];
        return view('welcome', [
            'search_data' => $data,
        ])->withInput($request->except('_token'));
    }

    public function getSearchPostBody($data = [])
    {
        $xml = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
        xmlns:cb5="http://creditinfo.com/CB5"
        xmlns:smar="http://creditinfo.com/CB5/v5.53/SmartSearch">
            <soapenv:Header/>
            <soapenv:Body>
                <cb5:SmartSearchCompany>
                    <cb5:query>
                        <smar:InquiryReason>{{inquiry_reason}}</smar:InquiryReason>
                        <smar:InquiryReasonText>{{inquiry_reason_text}}</smar:InquiryReasonText>
                        <smar:Parameters>
                            <smar:CompanyName>{{company_name}}</smar:CompanyName>
                            <smar:IdNumbers>
                                <smar:IdNumberPairCompany>
                                    <smar:IdNumber>{{npwp}}</smar:IdNumber>
                                    <smar:IdNumberType>NPWP</smar:IdNumberType>
                                </smar:IdNumberPairCompany>
                            </smar:IdNumbers>
                        </smar:Parameters>
                    </cb5:query>
                </cb5:SmartSearchCompany>
            </soapenv:Body>
        </soapenv:Envelope>';
        if (count($data)) {
            $xml = str_replace([
                '{{inquiry_reason}}', '{{inquiry_reason_text}}',
                '{{company_name}}', '{{npwp}}'
            ], [
                $data['inquiry_reason'], $data['inquiry_reason_text'],
                $data['company_name'], $data['npwp']
            ], $xml);
        }
        return $xml;
    }

    public function getSearchResultJson(string $xml)
    {
        $result = [
            'status' => false,
            'data' => [],
            'message' => ''
        ];
        if (!$xml) {
            $result['message'] = 'Error';
        }else{
            $data = json_decode(json_encode(new \SimpleXMLElement(<<<XML
            <?xml version='1.0' standalone='yes'?>$xml
            XML)))->Body->SmartSearchCompanyResponse->SmartSearchCompanyResult;
            $result['message'] = $data->Status;
            if ($result['message'] === 'SubjectFound') {
                $result['status'] = true;
                if (is_array($data->CompanyRecords->SearchCompanyRecord)) {
                    $result['data'] = $data->CompanyRecords->SearchCompanyRecord;
                }else{
                    $result['data'][] = $data->CompanyRecords->SearchCompanyRecord;
                }

                /* Change index to lowercase */
                // $result['data'] = collect($result['data'])->map(function($item) {
                //     $temp = [];
                //     collect($item)->map(function($value, $index) use(&$temp) {
                //         $temp[strtolower($index)] = $value;
                //     });
                //     return $temp;
                // });
            }
        }
        return $result;
    }

    public function customReport(Type $var = null)
    {
        # code...
    }
}
