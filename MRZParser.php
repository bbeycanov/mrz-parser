<?php

namespace App\Library;

use Exception;

/**
 * @property string[] $non_ISO_3166
 * @property string[] $united_nations
 * @property string[] $british_nationals
 */
class MRZParser
{

    /**
     * @var array $countries
     */
    private array $countries;

    /**
     * @var string[] $checkDigitValues
     */
    private array $checkDigitValues;

    /**
     * Solidus MRZ constructor
     */
    public function __construct()
    {

        $this->countries = [
            "AFG" => "Afghanistan",
            "ALB" => "Albania",
            "DZA" => "Algeria",
            "ASM" => "American Samoa",
            "AND" => "Andorra",
            "AGO" => "Angola",
            "AIA" => "Anguilla",
            "ATA" => "Antarctica",
            "ATG" => "Antigua and Barbuda",
            "ARG" => "Argentina",
            "ARM" => "Armenia",
            "ABW" => "Aruba",
            "AUS" => "Australia",
            "AUT" => "Austria",
            "AZE" => "Azerbaijan",
            "BHS" => "Bahamas (the)",
            "BHR" => "Bahrain",
            "BGD" => "Bangladesh",
            "BRB" => "Barbados",
            "BLR" => "Belarus",
            "BEL" => "Belgium",
            "BLZ" => "Belize",
            "BEN" => "Benin",
            "BMU" => "Bermuda",
            "BTN" => "Bhutan",
            "BOL" => "Bolivia (Plurinational State of)",
            "BES" => "Bonaire, Sint Eustatius and Saba",
            "BIH" => "Bosnia and Herzegovina",
            "BWA" => "Botswana",
            "BVT" => "Bouvet Island",
            "BRA" => "Brazil",
            "IOT" => "British Indian Ocean Territory (the)",
            "BRN" => "Brunei Darussalam",
            "BGR" => "Bulgaria",
            "BFA" => "Burkina Faso",
            "BDI" => "Burundi",
            "CPV" => "Cabo Verde",
            "KHM" => "Cambodia",
            "CMR" => "Cameroon",
            "CAN" => "Canada",
            "CYM" => "Cayman Islands (the)",
            "CAF" => "Central African Republic (the)",
            "TCD" => "Chad",
            "CHL" => "Chile",
            "CHN" => "China",
            "CXR" => "Christmas Island",
            "CCK" => "Cocos (Keeling) Islands (the)",
            "COL" => "Colombia",
            "COM" => "Comoros (the)",
            "COD" => "Congo (the Democratic Republic of the)",
            "COG" => "Congo (the)",
            "COK" => "Cook Islands (the)",
            "CRI" => "Costa Rica",
            "HRV" => "Croatia",
            "CUB" => "Cuba",
            "CUW" => "Curaçao",
            "CYP" => "Cyprus",
            "CZE" => "Czechia",
            "CIV" => "Côte d'Ivoire",
            "DNK" => "Denmark",
            "DJI" => "Djibouti",
            "DMA" => "Dominica",
            "DOM" => "Dominican Republic (the)",
            "ECU" => "Ecuador",
            "EGY" => "Egypt",
            "SLV" => "El Salvador",
            "GNQ" => "Equatorial Guinea",
            "ERI" => "Eritrea",
            "EST" => "Estonia",
            "SWZ" => "Eswatini",
            "ETH" => "Ethiopia",
            "FLK" => "Falkland Islands (the) [Malvinas]",
            "FRO" => "Faroe Islands (the)",
            "FJI" => "Fiji",
            "FIN" => "Finland",
            "FRA" => "France",
            "GUF" => "French Guiana",
            "PYF" => "French Polynesia",
            "ATF" => "French Southern Territories (the)",
            "GAB" => "Gabon",
            "GMB" => "Gambia (the)",
            "GEO" => "Georgia",
            "DEU" => "Germany",
            "GHA" => "Ghana",
            "GIB" => "Gibraltar",
            "GRC" => "Greece",
            "GRL" => "Greenland",
            "GRD" => "Grenada",
            "GLP" => "Guadeloupe",
            "GUM" => "Guam",
            "GTM" => "Guatemala",
            "GGY" => "Guernsey",
            "GIN" => "Guinea",
            "GNB" => "Guinea-Bissau",
            "GUY" => "Guyana",
            "HTI" => "Haiti",
            "HMD" => "Heard Island and McDonald Islands",
            "VAT" => "Holy See (the)",
            "HND" => "Honduras",
            "HKG" => "Hong Kong",
            "HUN" => "Hungary",
            "ISL" => "Iceland",
            "IND" => "India",
            "IDN" => "Indonesia",
            "IRN" => "Iran (Islamic Republic of)",
            "IRQ" => "Iraq",
            "IRL" => "Ireland",
            "IMN" => "Isle of Man",
            "ISR" => "Israel",
            "ITA" => "Italy",
            "JAM" => "Jamaica",
            "JPN" => "Japan",
            "JEY" => "Jersey",
            "JOR" => "Jordan",
            "KAZ" => "Kazakhstan",
            "KEN" => "Kenya",
            "KIR" => "Kiribati",
            "PRK" => "Korea (the Democratic People's Republic of)",
            "KOR" => "Korea (the Republic of)",
            "KWT" => "Kuwait",
            "KGZ" => "Kyrgyzstan",
            "LAO" => "Lao People's Democratic Republic (the)",
            "LVA" => "Latvia",
            "LBN" => "Lebanon",
            "LSO" => "Lesotho",
            "LBR" => "Liberia",
            "LBY" => "Libya",
            "LIE" => "Liechtenstein",
            "LTU" => "Lithuania",
            "LUX" => "Luxembourg",
            "MAC" => "Macao",
            "MDG" => "Madagascar",
            "MWI" => "Malawi",
            "MYS" => "Malaysia",
            "MDV" => "Maldives",
            "MLI" => "Mali",
            "MLT" => "Malta",
            "MHL" => "Marshall Islands (the)",
            "MTQ" => "Martinique",
            "MRT" => "Mauritania",
            "MUS" => "Mauritius",
            "MYT" => "Mayotte",
            "MEX" => "Mexico",
            "FSM" => "Micronesia (Federated States of)",
            "MDA" => "Moldova (the Republic of)",
            "MCO" => "Monaco",
            "MNG" => "Mongolia",
            "MNE" => "Montenegro",
            "MSR" => "Montserrat",
            "MAR" => "Morocco",
            "MOZ" => "Mozambique",
            "MMR" => "Myanmar",
            "NAM" => "Namibia",
            "NRU" => "Nauru",
            "NPL" => "Nepal",
            "NLD" => "Netherlands (the)",
            "NCL" => "New Caledonia",
            "NZL" => "New Zealand",
            "NIC" => "Nicaragua",
            "NER" => "Niger (the)",
            "NGA" => "Nigeria",
            "NIU" => "Niue",
            "NFK" => "Norfolk Island",
            "MKD" => "North Macedonia",
            "MNP" => "Northern Mariana Islands (the)",
            "NOR" => "Norway",
            "OMN" => "Oman",
            "PAK" => "Pakistan",
            "PLW" => "Palau",
            "PSE" => "Palestine, State of",
            "PAN" => "Panama",
            "PNG" => "Papua New Guinea",
            "PRY" => "Paraguay",
            "PER" => "Peru",
            "PHL" => "Philippines (the)",
            "PCN" => "Pitcairn",
            "POL" => "Poland",
            "PRT" => "Portugal",
            "PRI" => "Puerto Rico",
            "QAT" => "Qatar",
            "ROU" => "Romania",
            "RUS" => "Russian Federation (the)",
            "RWA" => "Rwanda",
            "REU" => "Réunion",
            "BLM" => "Saint Barthélemy",
            "SHN" => "Saint Helena, Ascension and Tristan da Cunha",
            "KNA" => "Saint Kitts and Nevis",
            "LCA" => "Saint Lucia",
            "MAF" => "Saint Martin (French part)",
            "SPM" => "Saint Pierre and Miquelon",
            "VCT" => "Saint Vincent and the Grenadines",
            "WSM" => "Samoa",
            "SMR" => "San Marino",
            "STP" => "Sao Tome and Principe",
            "SAU" => "Saudi Arabia",
            "SEN" => "Senegal",
            "SRB" => "Serbia",
            "SYC" => "Seychelles",
            "SLE" => "Sierra Leone",
            "SGP" => "Singapore",
            "SXM" => "Sint Maarten (Dutch part)",
            "SVK" => "Slovakia",
            "SVN" => "Slovenia",
            "SLB" => "Solomon Islands",
            "SOM" => "Somalia",
            "ZAF" => "South Africa",
            "SGS" => "South Georgia and the South Sandwich Islands",
            "SSD" => "South Sudan",
            "ESP" => "Spain",
            "LKA" => "Sri Lanka",
            "SDN" => "Sudan (the)",
            "SUR" => "Suriname",
            "SJM" => "Svalbard and Jan Mayen",
            "SWE" => "Sweden",
            "CHE" => "Switzerland",
            "SYR" => "Syrian Arab Republic (the)",
            "TWN" => "Taiwan (Province of China)",
            "TJK" => "Tajikistan",
            "TZA" => "Tanzania, the United Republic of",
            "THA" => "Thailand",
            "TLS" => "Timor-Leste",
            "TGO" => "Togo",
            "TKL" => "Tokelau",
            "TON" => "Tonga",
            "TTO" => "Trinidad and Tobago",
            "TUN" => "Tunisia",
            "TUR" => "Turkey",
            "TKM" => "Turkmenistan",
            "TCA" => "Turks and Caicos Islands (the)",
            "TUV" => "Tuvalu",
            "UGA" => "Uganda",
            "UKR" => "Ukraine",
            "ARE" => "United Arab Emirates (the)",
            "GBR" => "United Kingdom of Great Britain and Northern Ireland (the)",
            "UMI" => "United States Minor Outlying Islands (the)",
            "USA" => "United States of America (the)",
            "URY" => "Uruguay",
            "UZB" => "Uzbekistan",
            "VUT" => "Vanuatu",
            "VEN" => "Venezuela (Bolivarian Republic of)",
            "VNM" => "Viet Nam",
            "VGB" => "Virgin Islands (British)",
            "VIR" => "Virgin Islands (U.S.)",
            "WLF" => "Wallis and Futuna",
            "ESH" => "Western Sahara*",
            "YEM" => "Yemen",
            "ZMB" => "Zambia",
            "ZWE" => "Zimbabwe",
            "ALA" => "Åland Islands"
        ];

        $this->non_ISO_3166 = [
            "XBA" => "African Development Bank",
            "XIM" => "African Export–Import Bank",
            "XCC" => "Caribbean Community",
            "XCO" => "Common Market for Eastern and Southern Africa",
            "XEC" => "Economic Community of West African States",
            "EUE" => "European Union",
            "D" => "Germany",
            "XPO" => "International Criminal Police Organization (Interpol)",
            "IMO" => "International Maritime Organisation",
            "RKS" => "Kosovo",
            "XOM" => "Sovereign Military Order of Malta",
            "WSA" => "World Service Authority World Passport"
        ];

        $this->united_nations = [
            "UNK" => "United Nations Interim Administration Mission in Kosovo (UNMIK)",
            "UNO" => "United Nations Organization Official",
            "UNA" => "United Nations Organization Specialized Agency Official",
            "XAA" => "Stateless (per Article 1 of 1954 convention)",
            "XXB" => "Refugee (per Article 1 of 1951 convention, amended by 1967 protocol)",
            "XXC" => "Refugee (non-convention)",
            "XXX" => "Unspecified Nationality / Unknown",
            "UTO" => "Utopian"
        ];

        $this->british_nationals = [
            "GBR" => "United Kingdom of Great Britain and Northern Ireland Citizen",
            "GBD" => "United Kingdom of Great Britain and Northern Ireland Dependent Territories Citizen",
            "GBN" => "United Kingdom of Great Britain and Northern Ireland National (Overseas)",
            "GBO" => "United Kingdom of Great Britain and Northern Ireland Oversees Citizen",
            "GBP" => "United Kingdom of Great Britain and Northern Ireland Protected Person",
            "GBS" => "United Kingdom of Great Britain and Northern Ireland Subject"
        ];

        $this->countries = array_merge(
            $this->countries,
            $this->non_ISO_3166,
            $this->united_nations,
            $this->british_nationals
        );

        $this->checkDigitValues = [
            "<" => "0",
            "A" => "10", "B" => "11", "C" => "12", "D" => "13", "E" => "14",
            "F" => "15", "G" => "16", "H" => "17", "I" => "18", "J" => "19",
            "K" => "20", "L" => "21", "M" => "22", "N" => "23", "O" => "24",
            "P" => "25", "Q" => "26", "R" => "27", "S" => "28", "T" => "29",
            "U" => "30", "V" => "31", "W" => "32", "X" => "33", "Y" => "34",
            "Z" => "35"
        ];
    }

    /**
     * @param $str
     * @return mixed|string
     */
    private function returnCountryName($str)
    {
        return (array_key_exists($str, $this->countries)) ? $this->countries[$str] : "Unknown Country";
    }

    /**
     * @param $str
     * @return string
     */
    private function returnCheckDigitValues($str): string
    {
        return $this->checkDigitValues[$str];
    }

    /**
     * @param $str
     * @return array|string|string[]|null
     */
    private function stripPadding($str)
    {

        if (!$str) {
            return null;
        }

        $return = trim(preg_replace('/</', ' ', $str));

        return preg_replace('/\s+/', ' ', $return);
    }

    /**
     * @param $str
     * @return array
     */
    private function getNames($str): array
    {
        $names = explode('<<', $str);

        $name['lastName'] = $this->stripPadding($names[0]);

        $name['firstName'] = $this->stripPadding($names[1]);

        return $name;
    }

    /**
     * @param $str
     * @param $t
     * @return string
     */
    private function getFullDate($str, $t): string
    {
        $d = date('YY') + 11;

        $centennial = substr($d, 2, 2);

        $s = substr($str, 0, 2);

        $conditionFull1 = ($s > $centennial) ? '19' . $s : '20' . $s;

        $conditionFull2 = ($s < $centennial) ? '19' . $s : '20' . $s;

        $day = substr($str, 4, 2);

        $month = substr($str, 2, 2);

        $year = ($t === 1) ? $conditionFull1 : $conditionFull2;

        return $day . '/' . $month . '/' . $year;
    }


    /**
     * @param $str
     * @return array
     */
    private function getSex($str): array
    {
        if ($str === 'M') {
            $sex['abbr'] = 'M';
            $sex['full'] = 'Male';
        } else if ($str === 'F') {
            $sex['abbr'] = 'F';
            $sex['full'] = 'Female';
        } else {
            $sex['abbr'] = 'X';
            $sex['full'] = 'Unspecified';
        }

        return $sex;
    }

    /**
     * @param $str
     * @return array|string
     */
    private function getCountry($str)
    {
        try {
            $region['abbr'] = $str;
            $region['full'] = $this->returnCountryName($str);
            return $region;
        } catch (Exception $err) {
            return $err->getMessage();
        }
    }


    /**
     * @param $str
     * @param $digit
     * @return bool
     */
    private function checkDigitVerify($str, $digit): bool
    {
        $numbers = array();
        $weighting = array(7, 3, 1);

        for ($i = 0, $iMax = strlen($str); $i < $iMax; $i++) {
            if (preg_match('/[A-Za-z<]/', $str[$i], $match)) {
                $numbers[] = $this->returnCheckDigitValues($str[$i]);
            } else {
                $numbers[] = (int)$str[$i];
            }

        }

        $curWeight = 0;
        $total = 0;

        foreach ($numbers as $jValue) {
            $total += $jValue * $weighting[$curWeight];
            $curWeight++;
            if ($curWeight === 3) {
                $curWeight = 0;
            }
        }

        return $total % 10 === $digit;
    }

    /**
     * @param $mrz
     * @return array
     */
    private function parseMRZPassport($mrz): ?array
    {
        try {

            $documentCode = substr($mrz, 0, 1);
            $issuerOrg = $this->getCountry($this->stripPadding(substr($mrz, 2, 3)));
            $names = $this->getNames(substr($mrz, 5, 39));
            $documentNumberRaw = substr($mrz, 44, 9);
            $documentNumber = $this->stripPadding($documentNumberRaw);
            $checkDigit1 = substr($mrz, 53, 1);
            $checkDigitVerify1 = $this->checkDigitVerify($documentNumberRaw, $checkDigit1);
            $nationality = $this->getCountry($this->stripPadding(substr($mrz, 54, 3)));
            $dobRaw = substr($mrz, 57, 6);
            $dob = $this->getFullDate($this->stripPadding($dobRaw), 1);
            $checkDigit2 = substr($mrz, 63, 1);
            $checkDigitVerify2 = $this->checkDigitVerify($dobRaw, $checkDigit2);
            $sex = $this->getSex($this->stripPadding(substr($mrz, 64, 1)));
            $expiryRaw = substr($mrz, 65, 6);
            $expiry = $this->getFullDate($this->stripPadding($expiryRaw), 2);
            $checkDigit3 = $this->stripPadding(substr($mrz, 71, 1));
            $checkDigitVerify3 = $this->checkDigitVerify($expiryRaw, $checkDigit3);
            $personalNumberRaw = substr($mrz, 72, 14);
            $personalNumber = $this->stripPadding($personalNumberRaw);
            $checkDigit4 = substr($mrz, 86, 1);
            $checkDigitVerify4 = $this->checkDigitVerify($personalNumberRaw, $checkDigit4);

            $finalCheckDigitRaw = $documentNumberRaw . $checkDigit1 .
                $dobRaw . $checkDigit2 .
                $expiryRaw . $checkDigit3 .
                $personalNumberRaw . $checkDigit4;
            $checkDigit5 = substr($mrz, 87, 1);
            $checkDigitVerify5 = $this->checkDigitVerify($finalCheckDigitRaw, $checkDigit5);

            $passport['documentCode'] = substr($mrz, 0, 1);
            $passport['documentType'] = ($documentCode === 'P') ? 'PASSPORT' : 'UNKNOWN';
            $passport['issuerOrg'] = $issuerOrg;
            $passport['names'] = $names;
            $passport['documentNumber'] = $documentNumber;
            $passport['nationality'] = $nationality;
            $passport['dob'] = $dob;
            $passport['sex'] = $sex;
            $passport['expiry'] = $expiry;
            $passport['personalNumber'] = $personalNumber;
            $passport['checkDigit']['documentNumber']['checkDigit1'] = $checkDigit1;
            $passport['checkDigit']['documentNumber']['checkDigitVerify1'] = $checkDigitVerify1;
            $passport['checkDigit']['dob']['checkDigit2'] = $checkDigit2;
            $passport['checkDigit']['dob']['checkDigitVerify2'] = $checkDigitVerify2;
            $passport['checkDigit']['expiry']['checkDigit3'] = $checkDigit3;
            $passport['checkDigit']['expiry']['checkDigitVerify3'] = $checkDigitVerify3;
            $passport['checkDigit']['personalNumber']['checkDigit4'] = $checkDigit4;
            $passport['checkDigit']['personalNumber']['checkDigitVerify4'] = $checkDigitVerify4;
            $passport['checkDigit']['finalCheck']['checkDigit5'] = $checkDigit5;
            $passport['checkDigit']['finalCheck']['checkDigitVerify5'] = $checkDigitVerify5;
            $passport['mrzisvalid'] = $checkDigitVerify1 && $checkDigitVerify2 && $checkDigitVerify3 && $checkDigitVerify4 && $checkDigitVerify5;

            return $passport;

        } catch (Exception $e) {
            $error['error'] = 'Details parsing failed. ' . $e;
            return $error;
        }
    }

    /**
     * @param $mrz
     * @return array
     */
    private function parseMRZID1($mrz): ?array
    {
        try {

            $documentCode1 = substr($mrz, 0, 1);
            $documentCode2 = substr($mrz, 1, 1);

            $issuerOrg = $this->getCountry($this->stripPadding(substr($mrz, 2, 3)));

            $documentNumberRaw = substr($mrz, 5, 9);
            $documentNumber = $this->stripPadding($documentNumberRaw);
            $checkDigit1 = substr($mrz, 14, 1);
            $checkDigitVerify1 = $this->checkDigitVerify($documentNumberRaw, $checkDigit1);

            $optionalData = $this->stripPadding(substr($mrz, 15, 15));

            $dobRaw = substr($mrz, 30, 6);
            $dob = $this->getFullDate($this->stripPadding($dobRaw), 1);
            $checkDigit2 = substr($mrz, 36, 1);
            $checkDigitVerify2 = $this->checkDigitVerify($dobRaw, $checkDigit2);

            $sex = $this->getSex($this->stripPadding(substr($mrz, 37, 1)));

            $expiryRaw = substr($mrz, 38, 6);
            $expiry = $this->getFullDate($this->stripPadding($expiryRaw), 2);

            $checkDigit3 = $this->stripPadding(substr($mrz, 44, 1));
            $checkDigitVerify3 = $this->checkDigitVerify($expiryRaw, $checkDigit3);

            $nationality = $this->getCountry($this->stripPadding(substr($mrz, 45, 3)));

            $optionalData2 = $this->stripPadding(substr($mrz, 48, 11));

            $finalCheckDigitRaw = $documentNumberRaw . $checkDigit1 . $dobRaw . $checkDigit2 . $expiryRaw . $checkDigit3 . $optionalData2;
            $checkDigit4 = substr($mrz, 59, 1);
            $checkDigitVerify4 = $this->checkDigitVerify($finalCheckDigitRaw, $checkDigit4);

            $names = $this->getNames(substr($mrz, 60, 30));

            $id['documentCode'] = substr($mrz, 0, 1);
            $id['documentType'] = ($documentCode1 === 'I') ? 'ID-1' : 'UNKNOWN';
            $id['documentType'] .= ($documentCode2 === 'R') ? ' Residence Card' : '';
            $id['issuerOrg'] = $issuerOrg;
            $id['names'] = $names;
            $id['documentNumber'] = $documentNumber;
            $id['optionalData'] = $optionalData;
            $id['optionalData2'] = $optionalData2;
            $id['nationality'] = $nationality;
            $id['dob'] = $dob;
            $id['sex'] = $sex;
            $id['expiry'] = $expiry;

            $id['checkDigit']['documentNumber']['checkDigit1'] = $checkDigit1;
            $id['checkDigit']['documentNumber']['checkDigitVerify1'] = $checkDigitVerify1;

            $id['checkDigit']['dob']['checkDigit2'] = $checkDigit2;
            $id['checkDigit']['dob']['checkDigitVerify2'] = $checkDigitVerify2;

            $id['checkDigit']['expiry']['checkDigit3'] = $checkDigit3;
            $id['checkDigit']['expiry']['checkDigitVerify3'] = $checkDigitVerify3;

            $id['checkDigit']['finalCheck']['checkDigit4'] = $checkDigit4;
            $id['checkDigit']['finalCheck']['checkDigitVerify4'] = $checkDigitVerify4;

            $id['mrzisvalid'] = $checkDigitVerify1 && $checkDigitVerify2 && $checkDigitVerify3 && $checkDigitVerify4;

            return $id;
        } catch (Exception $e) {
            $error['error'] = 'Details parsing failed. ' . $e;
            return $error;
        }

    }

    /**
     * @param $mrz
     * @return array|null
     */
    private function parseMRZID2($mrz): ?array
    {

        try {

            $documentCode1 = substr($mrz, 0, 1);
            $documentCode2 = substr($mrz, 1, 1);

            $issuerOrg = $this->getCountry($this->stripPadding(substr($mrz, 2, 3)));

            $names = $this->getNames(substr($mrz, 5, 31));

            $documentNumberRaw = substr($mrz, 36, 9);
            $documentNumber = $this->stripPadding($documentNumberRaw);
            $checkDigit1 = substr($mrz, 45, 1);
            $checkDigitVerify1 = $this->checkDigitVerify($documentNumberRaw, $checkDigit1);

            $nationalityRaw = substr($mrz, 46, 3);
            $nationality = $this->getCountry($this->stripPadding($nationalityRaw));

            $dobRaw = substr($mrz, 49, 6);
            $dob = $this->getFullDate($this->stripPadding($dobRaw), 1);
            $checkDigit2 = substr($mrz, 55, 1);
            $checkDigitVerify2 = $this->checkDigitVerify($dobRaw, $checkDigit2);

            $sex = $this->getSex($this->stripPadding(substr($mrz, 56, 1)));

            $expiryRaw = substr($mrz, 57, 6);
            $expiry = $this->getFullDate($this->stripPadding($expiryRaw), 2);

            $checkDigit3 = $this->stripPadding(substr($mrz, 63, 1));
            $checkDigitVerify3 = $this->checkDigitVerify($expiryRaw, $checkDigit3);

            $optionalData = $this->stripPadding(substr($mrz, 64, 7));

            $finalCheckDigitRaw = $documentNumberRaw . $checkDigit1 . $dobRaw . $checkDigit2 . $expiryRaw . $checkDigit3 . $optionalData;
            $checkDigit4 = substr($mrz, 71, 1);
            $checkDigitVerify4 = $this->checkDigitVerify($finalCheckDigitRaw, $checkDigit4);

            $id['documentCode'] = substr($mrz, 0, 1);
            $id['documentType'] = ($documentCode1 === 'I') ? 'ID-2' : 'UNKNOWN';
            $id['documentType'] .= ($documentCode2 === 'R') ? ' Residence Card' : '';
            $id['issuerOrg'] = $issuerOrg;
            $id['names'] = $names;

            $id['documentNumber'] = $documentNumber;
            $id['checkDigit']['documentNumber']['checkDigit1'] = $checkDigit1;
            $id['checkDigit']['documentNumber']['checkDigitVerify1'] = $checkDigitVerify1;

            $id['nationality'] = $nationality;

            $id['dob'] = $dob;
            $id['checkDigit']['passport']['checkDigit2'] = $checkDigit2;
            $id['checkDigit']['passport']['checkDigitVerify2'] = $checkDigitVerify2;

            $id['sex'] = $sex;

            $id['expiry'] = $expiry;
            $id['checkDigit']['expiry']['checkDigit3'] = $checkDigit3;
            $id['checkDigit']['expiry']['checkDigitVerify3'] = $checkDigitVerify3;

            $id['optionalData'] = $optionalData;

            $id['checkDigit']['finalCheck']['checkDigit4'] = $checkDigit4;
            $id['checkDigit']['finalCheck']['checkDigitVerify4'] = $checkDigitVerify4;

            $id['mrzisvalid'] = $checkDigitVerify1 && $checkDigitVerify2 && $checkDigitVerify3 && $checkDigitVerify4;

            return $id;
        } catch (Exception $e) {
            $error['error'] = 'Details parsing failed. ' . $e;
            return $error;
        }

    }

    /**
     * @param $mrz
     * @return array|null
     */
    private function parseMRZFrenchID($mrz): ?array
    {
        try {
            $documentCode1 = substr($mrz, 0, 1);
            $documentCode2 = substr($mrz, 1, 1);

            $issuerOrg = $this->getCountry($this->stripPadding(substr($mrz, 2, 3)));

            $documentNumberRaw = substr($mrz, 36, 12);
            $documentNumber = $this->stripPadding($documentNumberRaw);
            $checkDigit1 = substr($mrz, 48, 1);
            $checkDigitVerify1 = $this->checkDigitVerify($documentNumberRaw, $checkDigit1);

            $optionalData = $this->stripPadding(substr($mrz, 30, 6));

            $dobRaw = substr($mrz, 63, 6);
            $dob = $this->getFullDate($this->stripPadding($dobRaw), 1);
            $checkDigit2 = substr($mrz, 69, 1);
            $checkDigitVerify2 = $this->checkDigitVerify($dobRaw, $checkDigit2);

            $sex = $this->getSex($this->stripPadding(substr($mrz, 70, 1)));

            $checkDigit3 = null;
            $checkDigitVerify3 = 1;

            $nationality = $this->getCountry($this->stripPadding(substr($mrz, 2, 3)));

            $finalCheckDigitRaw = substr($mrz, 0, 71);
            $checkDigit4 = $this->stripPadding(substr($mrz, 71, 1));
            $checkDigitVerify4 = $this->checkDigitVerify($finalCheckDigitRaw, $checkDigit4);

            $id['documentCode'] = substr($mrz, 0, 1);
            $id['documentType'] = ($documentCode1 === 'I') ? 'ID-1' : 'UNKNOWN';
            $id['documentType'] .= ($documentCode2 === 'R') ? ' Residence Card' : '';
            $id['issuerOrg'] = $issuerOrg;
            $id['names']['lastName'] = $this->stripPadding(substr($mrz, 5, 25));
            $id['names']['firstName'] = $this->stripPadding(substr($mrz, 49, 14));
            $id['documentNumber'] = $documentNumber;
            $id['optionalData'] = $optionalData;
            $id['nationality'] = $nationality;
            $id['dob'] = $dob;
            $id['sex'] = $sex;

            $id['checkDigit']['documentNumber']['checkDigit1'] = $checkDigit1;
            $id['checkDigit']['documentNumber']['checkDigitVerify1'] = $checkDigitVerify1;

            $id['checkDigit']['dob']['checkDigit2'] = $checkDigit2;
            $id['checkDigit']['dob']['checkDigitVerify2'] = $checkDigitVerify2;

            $id['checkDigit']['expiry']['checkDigit3'] = $checkDigit3;
            $id['checkDigit']['expiry']['checkDigitVerify3'] = $checkDigitVerify3;

            $id['checkDigit']['finalCheck']['checkDigit4'] = $checkDigit4;
            $id['checkDigit']['finalCheck']['checkDigitVerify4'] = $checkDigitVerify4;

            $id['mrzisvalid'] = $checkDigitVerify1 && $checkDigitVerify2 && $checkDigitVerify4;

            return $id;
        } catch (Exception $e) {
            $error['error'] = 'Details parsing failed. ' . $e;
            return $error;
        }
    }

    /**
     * @param $mrz
     * @return array|null
     */
    private function parseMRZVisa($mrz): ?array
    {
        try {

            $documentCode1 = substr($mrz, 0, 1);
            $documentCode2 = substr($mrz, 1, 1);

            $issuerOrg = $this->getCountry($this->stripPadding(substr($mrz, 2, 3)));

            $names = $this->getNames(substr($mrz, 5, 31));

            $documentNumberRaw = substr($mrz, 36, 9);
            $documentNumber = $this->stripPadding($documentNumberRaw);
            $checkDigit1 = substr($mrz, 45, 1);
            $checkDigitVerify1 = $this->checkDigitVerify($documentNumberRaw, $checkDigit1);

            $nationality = $this->getCountry($this->stripPadding(substr($mrz, 46, 3)));

            $dobRaw = substr($mrz, 49, 6);
            $dob = $this->getFullDate($this->stripPadding($dobRaw), 1);
            $checkDigit2 = substr($mrz, 55, 1);
            $checkDigitVerify2 = $this->checkDigitVerify($dobRaw, $checkDigit2);

            $sex = $this->getSex($this->stripPadding(substr($mrz, 56, 1)));

            $expiryRaw = substr($mrz, 57, 6);
            $expiry = $this->getFullDate($this->stripPadding($expiryRaw), 2);

            $checkDigit3 = $this->stripPadding(substr($mrz, 63, 1));
            $checkDigitVerify3 = $this->checkDigitVerify($expiryRaw, $checkDigit3);

            $optionalData = $this->stripPadding(substr($mrz, 64, 8));

            $id['documentCode'] = substr($mrz, 0, 1);
            $id['documentType'] = ($documentCode1 === 'V') ? 'ID-2 Visa' : 'UNKNOWN';
            $id['VisaType'] = $documentCode2;
            $id['issuerOrg'] = $issuerOrg;
            $id['names'] = $names;

            $id['documentNumber'] = $documentNumber;
            $id['checkDigit']['documentNumber']['checkDigit1'] = $checkDigit1;
            $id['checkDigit']['documentNumber']['checkDigitVerify1'] = $checkDigitVerify1;

            $id['nationality'] = $nationality;

            $id['dob'] = $dob;
            $id['checkDigit']['passport']['checkDigit2'] = $checkDigit2;
            $id['checkDigit']['passport']['checkDigitVerify2'] = $checkDigitVerify2;

            $id['sex'] = $sex;

            $id['expiry'] = $expiry;
            $id['checkDigit']['expiry']['checkDigit3'] = $checkDigit3;
            $id['checkDigit']['expiry']['checkDigitVerify3'] = $checkDigitVerify3;

            $id['optionalData'] = $optionalData;

            $id['mrzisvalid'] = $checkDigitVerify1 && $checkDigitVerify2 && $checkDigitVerify3;

            return $id;
        } catch (Exception $e) {
            $error['error'] = 'Details parsing failed. ' . $e;
            return $error;
        }

    }

    /**
     * @param $mrz
     * @return array|null
     */
    public function parse($mrz): ?array
    {
        $mrz = str_replace(array("\n\r", "\n", "\r"), "", $mrz);

        $len = strlen($mrz);

        if ($mrz === null || ($len !== 88 && $len !== 90 && $len !== 72)) {
            $error['error'] = 'Invalid MRZ length for ICAO document.';
            return $error;
        }

        $documentCode = $this->stripPadding($mrz[0]);

        switch ($documentCode) {

            case 'P' :
                return $this->parseMRZPassport($mrz);
            case 'A' :
            case 'C' :
            case 'I' :

                if ($len === 90) {
                    return $this->parseMRZID1($mrz);
                }

                if ($len === 72) {
                    if (substr($mrz, 2, 3) === 'FRA') {
                        return $this->parseMRZFrenchID($mrz);
                    }

                    return $this->parseMRZID2($mrz);
                }
                break;

            case 'V' :
                return $this->parseMRZVisa($mrz);
        }

        $error['error'] = 'Unknown document.';

        return $error;
    }
}
