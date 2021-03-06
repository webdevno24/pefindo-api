# Pefindo API

#

### #SmartSearchCompany
**Method:** `POST`

**URL:** `http://pefindo.kapitalboost.co.id/api/search/company`

**Request :**

- **npwp** 
`[ text | required ] `
- **company_name** 
`[ text | required | min: 4 ]`,
- **inquiry_reason** 
  ```
  [ options | required ]

    options:
    * ProvidingFacilities
    * MonitoringDebtorOrCustomer
    * OperationalRiskManagement
    * FulfilRegulationRequirements
    * AnotherReason
  ```
- **inquiry_reason_text** 
`[ text | required_if:inquiry_reason,AnotherReason ]`

**Response :**
```JSON
{
  "status": true,
  "data": [
    {
        "address": "Jalan kenangan",
        "company_name": "Shinra Enterprise",
        "npwp": "032006752814011",
        "pefindo_id": "46153855"
    },
    {},
    {}
  ],
  "message": "SubjectFound"
}
```
#
#
### #CustomReportCompany
**Method:** `POST`

**URL:** `http://pefindo.kapitalboost.co.id/api/report/company`

**URL ( PDF ):** `http://pefindo.kapitalboost.co.id/api/report/company/pdf` **[ <span style="color:red; font-weight: bolder;">WIP</span> ]**

**Request :**
- **pefindo_id**
`[ text | required ] `
- **inquiry_reason** 
  ```
  [ options | required ]

    options:
    * ProvidingFacilities
    * MonitoringDebtorOrCustomer
    * OperationalRiskManagement
    * FulfilRegulationRequirements
    * AnotherReason
  ```
- **inquiry_reason_text** 
`[ text | required_if:inquiry_reason,AnotherReason ]`
- **report_date** 
`[ date | optional | default: now() { data.pefindo_score.date } ]`

**Response :**
```JSON
{
    "status": true,
    "data": {
        "company": {
            "name": "PT Pertambangan Indonesia",
            "npwp": "032006752814012",
            "pefindo_id": "8408235",
            "address": "jl Wika No. 23 Jaksel"
        },
        "pefindo_score": {
            "date": "2021-03-18T00:00:00.000000Z",
            "score": "574",
            "grade": "D3",
            "grade_desc": "",
            "failpay_prob": "26.57",
            "trend": "Down"
        },
        "desc_about_risk": [
            {
                "code": "HMP2",
                "description": "The last available snapshot shows bad payment behaviour"
            }
        ],
        "pefindo_score_histories": [
            {
                "date": "2020-04-30T00:00:00.000000Z",
                "score": "674",
                "grade": "C1",
                "grade_desc": "",
                "failpay_prob": "3.47",
                "trend": "NoChange"
            },
            {},
        ]
    },
    "message": ""
}
```

