<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class PefindoController extends Controller
{
    public function xmlToArray(string $xml)
    {
        $search_pattern = [
            'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q',
            'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z'
        ];
        $search = [];
        $replace = [];
        foreach ($search_pattern as $pattern) {
            $search[] = '<'.$pattern.':';
            $replace[] = '<';

            $search[] = '</'.$pattern.':';
            $replace[] = '</';

            $search[] = 'xmlns:'.$pattern;
            $replace[] = 'xmlns-'.$pattern;

            $search[] = $pattern.':nil';
            $replace[] = $pattern.'-nil';
        }
        $xml = str_replace(
            $search,
            $replace,
            $xml
        );
        // return $xml;
        // dd($xml);
        return $this->recursiveToArray(json_decode(json_encode(new \SimpleXMLElement(<<<XML
        <?xml version='1.0' standalone='yes'?>$xml
        XML)), true));
    }

    public function recursiveToArray($data)
    {
        $result = [];
        if (count($data) == 1 && array_keys($data)[0] == '@attributes') {
            return null;
        }
        foreach ($data as $key => $value) {
            if ($key !== '@attributes') {
                if (is_iterable($value) && count($value)) {
                    $result[$key] = $this->recursiveToArray($value);
                    // dd("asdsdsad");
                } else{
                    $result[$key] = $value;
                }
            }
        }
        return $result;
    }

    public function smartSearchCompany(Request $request)
    {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => 'https://cbs5bodemo2.pefindobirokredit.com/WsReport/v5.53/Service.svc',
            CURLOPT_USERPWD => 'demofin_3:Testing@1',
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
            ),
        ]);

        $response = curl_exec($curl);
        curl_close($curl);

        $data = $this->getSearchResult($response);
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

    public function getSearchResult(string $xml)
    {
        $result = [
            'status' => false,
            'data' => [],
            'message' => ''
        ];
        if (!$xml) {
            $result['message'] = 'Error';
        }else{
            $data = $this->xmlToArray($xml)['Body']['SmartSearchCompanyResponse']['SmartSearchCompanyResult'];
            $result['message'] = $data['Status'];
            if ($result['message'] === 'SubjectFound') {
                $result['status'] = true;
                if (is_array($data['CompanyRecords']['SearchCompanyRecord'])) {
                    $result['data'] = $data['CompanyRecords']['SearchCompanyRecord'];
                }else{
                    $result['data'][] = $data['CompanyRecords']['SearchCompanyRecord'];
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

    public function customReport(Request $request)
    {
        $curl = curl_init();
        // return Response::make($this->getReportPostBody($request->except('_token')), 200, ['Content-Type' => 'text/xml']);;
        curl_setopt_array($curl, [
            CURLOPT_URL => 'https://cbs5bodemo2.pefindobirokredit.com/WsReport/v5.53/Service.svc',
            CURLOPT_USERPWD => 'demofin_3:Testing@1',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>$this->getReportPostBody($request->except('_token')),
            CURLOPT_HTTPHEADER => array(
                'Content-Type: text/xml',
                'SoapAction: http://creditinfo.com/CB5/IReportPublicServiceBase/GetCustomReport',
            ),
        ]);

        $response = curl_exec($curl);
        curl_close($curl);

        $data = $this->getReportResult($response);
        // dd($data);
        // return Response::make($this->xmlToArray($response), 200, ['Content-Type' => 'text/xml']);
        return view('report', $data);
    }

    public function getReportPostBody($data = [])
    {
        $xml = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
        xmlns:cb5="http://creditinfo.com/CB5"
        xmlns:cus="http://creditinfo.com/CB5/v5.53/CustomReport"
        xmlns:arr="http://schemas.microsoft.com/2003/10/Serialization/Arrays">
            <soapenv:Header/>
            <soapenv:Body>
                <cb5:GetCustomReport>
                    <cb5:parameters>
                        <cus:Consent>true</cus:Consent>
                        <cus:IDNumber>{{PefindoId}}</cus:IDNumber>
                        <cus:IDNumberType>PefindoId</cus:IDNumberType>
                        <cus:InquiryReason>{{InquiryReason}}</cus:InquiryReason>
                        <cus:InquiryReasonText>{{InquiryReasonText}}</cus:InquiryReasonText>
                        <cus:ReportDate>'.date('Y-m-d').'</cus:ReportDate>
                        <cus:LanguageCode>id-ID</cus:LanguageCode>
                        <cus:Sections>
                            <arr:string>CIP</arr:string>
                            <!-- <arr:string>SubjectInfoHistory</arr:string> [Section SubjectInfoHistory does not exist or access denied] -->
                            <arr:string>ContractList</arr:string>
                            <arr:string>ContractSummary</arr:string>
                            <arr:string>SubjectInfo</arr:string>
                        </cus:Sections>
                        <cus:SubjectType>Company</cus:SubjectType>
                    </cb5:parameters>
                </cb5:GetCustomReport>
            </soapenv:Body>
        </soapenv:Envelope>';
        if (count($data)) {
            $xml = str_replace([
                '{{PefindoId}}', '{{InquiryReason}}', '{{InquiryReasonText}}'
            ], [
                $data['PefindoId'], $data['InquiryReason'], $data['InquiryReasonText']
            ], $xml);
        }
        return $xml;
    }

    public function getReportResult(string $xml)
    {
        $result = [
            'status' => false,
            'data' => [],
            'message' => ''
        ];

        try {
            $data = $this->xmlToArray($xml)['Body']['GetCustomReportResponse']['GetCustomReportResult'];
            $result['status'] = true;
            $result['data'] = [
                'company' => [
                    'name' => $data['Company']['General']['CompanyName'],
                    'npwp' => $data['Company']['Identifications']['NPWP'],
                    'pefindo_id' => $data['Company']['Identifications']['PefindoId'],
                    'address' => $data['Company']['MainAddress']['AddressLine'],
                ],
                'pefindo_score' => [
                    'score' => $data['CIP']['RecordList']['Record'][0]['Score'],
                    'grade' => $data['CIP']['RecordList']['Record'][0]['Grade'],
                    'grade_desc' => '',
                    'failpay_prob' => $data['CIP']['RecordList']['Record'][0]['ProbabilityOfDefault'],
                    'trend' => $data['CIP']['RecordList']['Record'][0]['Trend'],
                ],
                'desc_about_risk' => array_key_exists('Code', $data['CIP']['RecordList']['Record'][0]['ReasonsList']['Reason'])
                ? [[
                    'code' => $data['CIP']['RecordList']['Record'][0]['ReasonsList']['Reason']['Code'],
                    'description' => $data['CIP']['RecordList']['Record'][0]['ReasonsList']['Reason']['Description'],
                ]]
                : collect($data['CIP']['RecordList']['Record'][0]['ReasonsList']['Reason'])
                ->map(function($item) {
                    return [ 'code' => $item['Code'], 'description' => $item['Description'] ];
                })->toArray(),
                'pefindo_score_histories' => collect($data['CIP']['RecordList']['Record'])->take(12)
                ->map(function($item) {
                    return [
                        'date' => Carbon::parse($item['Date']),
                        'score' => $item['Score'],
                        'grade' => $item['Grade'],
                        'grade_desc' => '',
                        'failpay_prob' => $item['ProbabilityOfDefault'],
                        'trend' => $item['Trend'],
                    ];
                })->toArray(),
            ];
        } catch (\Throwable $th) {
            $result['status'] = false;
            $result['message'] = 'Error';
        }
        return $result;
    }
}
