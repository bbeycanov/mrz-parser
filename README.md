# mrz-parser

# Run parser


```return (new MRZParser)->parse('{MRZ-TEXT-HERE}');```


#example

```return (new MRZParser)->parse('IAAZEAA197294805V77GY2<<<<<<<<9606195M3010068AZE<<<<<<<<<<<8BAYJANOV<<BAYJAN<<<<<<<<<<<<<<');```

```
{
  "documentCode": "I",
  "documentType": "ID-1",
  "issuerOrg": {
    "abbr": "AZE",
    "full": "Azerbaijan"
  },
  "names": {
    "lastName": "BAYJANOV",
    "firstName": "BAYJAN"
  },
  "documentNumber": "AA1972948",
  "optionalData": "5V77GY2",
  "optionalData2": "",
  "nationality": {
    "abbr": "AZE",
    "full": "Azerbaijan"
  },
  "dob": "19/06/1996",
  "sex": {
    "abbr": "M",
    "full": "Male"
  },
  "expiry": "06/10/2030",
  "checkDigit": {
    "documentNumber": {
      "checkDigit1": "0",
      "checkDigitVerify1": false
    },
    "dob": {
      "checkDigit2": "5",
      "checkDigitVerify2": false
    },
    "expiry": {
      "checkDigit3": "8",
      "checkDigitVerify3": false
    },
    "finalCheck": {
      "checkDigit4": "8",
      "checkDigitVerify4": false
    }
  },
  "mrzisvalid": false
}
```
