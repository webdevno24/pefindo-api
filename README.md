# Pefindo API

#### SmartSearchCompany
`https://...`

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
        "Address": "Jalan kenangan",
        "CompanyName": "Shinra Enterprise",
        "NPWP": "032006752814011",
        "PefindoId": "46153855"
    },
    {},
    {}
  ],
  "message": "SubjectFound"
}
```
