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
            CURLOPT_POSTFIELDS =>$this->getSingleHitPostBody($request->except('_token')),
            CURLOPT_HTTPHEADER => array(
                'Content-Type: text/xml',
                'SoapAction: http://creditinfo.com/CB5/IReportPublicServiceBase/SmartSearchCompany',
                'Authorization: Basic ZGVtb2Zpbl8zOlRlc3RpbmdAMQ=='
            ),
        ]);

        $response = curl_exec($curl);
        $response = str_replace(['s:', 'a:', 'i:'], '', $response);
        curl_close($curl);
        $temp = <<<XML
        <?xml version='1.0' standalone='yes'?>$response
        XML;
        $temp = new \SimpleXMLElement($temp);
        dd($temp);
        // ======
        // $temp = simplexml_load_string($response);
        // $temp = json_encode($temp);
        // $temp = json_decode($temp, true);
        // dd($temp);
        return \Response::make($response, 200, ['Content-type' => 'text/xml']);

        // return \Response::make($this->getSingleHitPostBody($request->except('_token')), 200, ['Content-type' => 'text/xml']);
        // return $request;
    }

    public function getSingleHitPostBody($data = [])
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
}
