<?php

namespace App\Traits;

use Carbon\Carbon;

trait PefindoTrait
{
    public function sendPost($postField, $soapAction)
    {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => env('PEFINDO_URL', '#'),
            CURLOPT_USERPWD => env('PEFINDO_USER', 'apa').':'.env('PEFINDO_PASS', 'ya?'),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $postField,
            CURLOPT_HTTPHEADER => array(
                'Content-Type: text/xml',
                'SoapAction: http://creditinfo.com/CB5/IReportPublicServiceBase/'.$soapAction,
            ),
        ]);

        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }

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

        try {
            $data = $this->xmlToArray($xml)['Body']['SmartSearchCompanyResponse']['SmartSearchCompanyResult'];
            // dd($data);
            $result['message'] = $data['Status'];
            if ($result['message'] === 'SubjectFound') {
                $result['status'] = true;
                if (array_key_exists('NPWP', $data['CompanyRecords']['SearchCompanyRecord'])) {
                    $result['data'][] = [
                        'address' => $data['CompanyRecords']['SearchCompanyRecord']['Address'],
                        'company_name' => $data['CompanyRecords']['SearchCompanyRecord']['CompanyName'],
                        'npwp' => $data['CompanyRecords']['SearchCompanyRecord']['NPWP'],
                        'pefindo_id' => $data['CompanyRecords']['SearchCompanyRecord']['PefindoId'],
                    ];
                }else{
                    // $result['data'] = $data['CompanyRecords']['SearchCompanyRecord'];
                    /* Change index to lowercase */
                    $result['data'] = collect($data['CompanyRecords']['SearchCompanyRecord'])->map(function($item) {
                        return [
                            'address' => $item['Address'],
                            'company_name' => $item['CompanyName'],
                            'npwp' => $item['NPWP'],
                            'pefindo_id' => $item['PefindoId'],
                        ];
                    });
                }

            }
        } catch (\Throwable $th) {
            $result['status'] = false;
            $result['message'] = $th->getMessage();
        }
        return $result;
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
                        <cus:ReportDate>{{ReportDate}}</cus:ReportDate>
                        <cus:LanguageCode>id-ID</cus:LanguageCode>
                        <cus:Sections>
                            <arr:string>CIP</arr:string>
                            <!-- <arr:string>SubjectInfoHistory</arr:string> -->
                            <arr:string>ContractList</arr:string>
                            <!-- <arr:string>ContractSummary</arr:string> -->
                            <arr:string>SubjectInfo</arr:string>
                        </cus:Sections>
                        <cus:SubjectType>Company</cus:SubjectType>
                    </cb5:parameters>
                </cb5:GetCustomReport>
            </soapenv:Body>
        </soapenv:Envelope>';
        if (count($data)) {
            $xml = str_replace([
                '{{PefindoId}}', '{{InquiryReason}}', '{{InquiryReasonText}}', '{{ReportDate}}'
            ], [
                $data['pefindo_id'], $data['inquiry_reason'], $data['inquiry_reason_text'], $data['report_date'] ?? date('Y-m-d'),
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
            dd($data);
            $result['status'] = true;
            $result['data'] = [
                'company' => [
                    'name' => $data['Company']['General']['CompanyName'],
                    'npwp' => $data['Company']['Identifications']['NPWP'],
                    'pefindo_id' => $data['Company']['Identifications']['PefindoId'],
                    'address' => $data['Company']['MainAddress']['AddressLine'],
                ],
                'pefindo_score' => [
                    'date' => Carbon::parse($data['CIP']['RecordList']['Record'][0]['Date']),
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
                })->reverse()->values()->toArray(),
            ];
        } catch (\Throwable $th) {
            $result['status'] = false;
            $result['message'] = "<pre>".$th."</pre>";
        }
        // dd($result);
        return $result;
    }
}
