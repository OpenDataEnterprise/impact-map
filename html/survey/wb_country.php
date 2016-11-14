<?php
// This function is to return the WB country code when the input argument is ISO code.
function getWBcode($src_country) {
	$wbcode = ''; 
	switch ($src_country) {
		case "AF":
			$wbcode = "AFG";
			break;
		case "AX":
			$wbcode = "AX";
			break;
		case "AL":
			$wbcode = "ALB";
			break;
		case "DZ":
			$wbcode = "DZA";
			break;
		case "AS":
			$wbcode = "ASM";
			break;
		case "AD":
			$wbcode = "ADO";
			break;
		case "AO":
			$wbcode = "AGO";
			break;
		case "AI":
			$wbcode = "AI";
			break;
		case "AQ":
			$wbcode = "AQ";
			break;
		case "AG":
			$wbcode = "ATG";
			break;
		case "AR":
			$wbcode = "ARG";
			break;
		case "AM":
			$wbcode = "ARM";
			break;
		case "AW":
			$wbcode = "ABW";
			break;
		case "AU":
			$wbcode = "AUS";
			break;
		case "AT":
			$wbcode = "AUT";
			break;
		case "AZ":
			$wbcode = "AZE";
			break;
		case "BS":
			$wbcode = "BHS";
			break;
		case "BH":
			$wbcode = "BHR";
			break;
		case "BD":
			$wbcode = "BGD";
			break;
		case "BB":
			$wbcode = "BRB";
			break;
		case "BY":
			$wbcode = "BRL";
			break;
		case "BE":
			$wbcode = "BEL";
			break;
		case "BZ":
			$wbcode = "BLZ";
			break;
		case "BJ":
			$wbcode = "BEN";
			break;
		case "BM":
			$wbcode = "BMU";
			break;
		case "BT":
			$wbcode = "BTN";
			break;
		case "BO":
			$wbcode = "BOL";
			break;
		case "BQ":
			$wbcode = "BQ";
			break;
		case "BA":
			$wbcode = "BIH";
			break;
		case "BW":
			$wbcode = "BWA";
			break;
		case "BR":
			$wbcode = "BRA";
			break;
		case "IO":
			$wbcode = "IO";
			break;
		case "BN":
			$wbcode = "BRN";
			break;
		case "BG":
			$wbcode = "BGR";
			break;
		case "BF":
			$wbcode = "BFA";
			break;
		case "BI":
			$wbcode = "BDI";
			break;
		case "KH":
			$wbcode = "KHM";
			break;
		case "CM":
			$wbcode = "CMR";
			break;
		case "CA":
			$wbcode = "CAN";
			break;
		case "CV":
			$wbcode = "CPV";
			break;
		case "KY":
			$wbcode = "CYM";
			break;
		case "CF":
			$wbcode = "CAF";
			break;
		case "TD":
			$wbcode = "TCD";
			break;
		case "CL":
			$wbcode = "CHL";
			break;
		case "CN":
			$wbcode = "CHN";
			break;
		case "CX":
			$wbcode = "CX";
			break;
		case "CC":
			$wbcode = "CC";
			break;
		case "CO":
			$wbcode = "COL";
			break;
		case "KM":
			$wbcode = "COM";
			break;
		case "CG":
			$wbcode = "COG";
			break;
		case "CD":
			$wbcode = "ZAR";
			break;
		case "CK":
			$wbcode = "CK";
			break;
		case "CR":
			$wbcode = "CRI";
			break;
		case "CI":
			$wbcode = "CIV";
			break;
		case "HR":
			$wbcode = "HRV";
			break;
		case "CU":
			$wbcode = "CUB";
			break;
		case "CW":
			$wbcode = "CUW";
			break;
		case "CY":
			$wbcode = "CYP";
			break;
		case "CZ":
			$wbcode = "CZE";
			break;
		case "DK":
			$wbcode = "DNK";
			break;
		case "DJ":
			$wbcode = "DJI";
			break;
		case "DM":
			$wbcode = "DMA";
			break;
		case "DO":
			$wbcode = "DOM";
			break;
		case "EC":
			$wbcode = "ECU";
			break;
		case "EG":
			$wbcode = "EGY";
			break;
		case "SV":
			$wbcode = "SLV";
			break;
		case "GQ":
			$wbcode = "GNQ";
			break;
		case "ER":
			$wbcode = "ERI";
			break;
		case "EE":
			$wbcode = "EST";
			break;
		case "ET":
			$wbcode = "ETH";
			break;
		case "FK":
			$wbcode = "FK";
			break;
		case "FO":
			$wbcode = "FRO";
			break;
		case "FJ":
			$wbcode = "FJI";
			break;
		case "FI":
			$wbcode = "FIN";
			break;
		case "FR":
			$wbcode = "FRA";
			break;
		case "GF":
			$wbcode = "GF";
			break;
		case "PF":
			$wbcode = "PYF";
			break;
		case "TF":
			$wbcode = "TF";
			break;
		case "GA":
			$wbcode = "GAB";
			break;
		case "GM":
			$wbcode = "GMB";
			break;
		case "GE":
			$wbcode = "GEO";
			break;
		case "DE":
			$wbcode = "DEU";
			break;
		case "GH":
			$wbcode = "GHA";
			break;
		case "GI":
			$wbcode = "GI";
			break;
		case "GR":
			$wbcode = "GRC";
			break;
		case "GL":
			$wbcode = "GRL";
			break;
		case "GD":
			$wbcode = "GRD";
			break;
		case "GP":
			$wbcode = "GP";
			break;
		case "GU":
			$wbcode = "GUM";
			break;
		case "GT":
			$wbcode = "GTM";
			break;
		case "GG":
			$wbcode = "GG";
			break;
		case "GN":
			$wbcode = "GIN";
			break;
		case "GW":
			$wbcode = "GNB";
			break;
		case "GY":
			$wbcode = "GUY";
			break;
		case "HT":
			$wbcode = "HTI";
			break;
		case "HM":
			$wbcode = "HM";
			break;
		case "VA":
			$wbcode = "VA";
			break;
		case "HN":
			$wbcode = "HND";
			break;
		case "HK":
			$wbcode = "HKG";
			break;
		case "HU":
			$wbcode = "HUN";
			break;
		case "IS":
			$wbcode = "ISL";
			break;
		case "IN":
			$wbcode = "IND";
			break;
		case "ID":
			$wbcode = "IDN";
			break;
		case "XZ":
			$wbcode = "XZ";
			break;
		case "IR":
			$wbcode = "IRN";
			break;
		case "IQ":
			$wbcode = "IRQ";
			break;
		case "IE":
			$wbcode = "IRL";
			break;
		case "IM":
			$wbcode = "IMY";
			break;
		case "IL":
			$wbcode = "ISR";
			break;
		case "IT":
			$wbcode = "ITA";
			break;
		case "JM":
			$wbcode = "JAM";
			break;
		case "JP":
			$wbcode = "JPN";
			break;
		case "JE":
			$wbcode = "JE";
			break;
		case "JO":
			$wbcode = "JOR";
			break;
		case "KZ":
			$wbcode = "KAZ";
			break;
		case "KE":
			$wbcode = "KEN";
			break;
		case "KI":
			$wbcode = "KIR";
			break;
		case "KP":
			$wbcode = "PRK";
			break;
		case "KR":
			$wbcode = "KOR";
			break;
		case "KW":
			$wbcode = "KWT";
			break;
		case "KG":
			$wbcode = "KGZ";
			break;
		case "LA":
			$wbcode = "LAO";
			break;
		case "LV":
			$wbcode = "LVA";
			break;
		case "LB":
			$wbcode = "LBN";
			break;
		case "LS":
			$wbcode = "LSO";
			break;
		case "LR":
			$wbcode = "LBR";
			break;
		case "LY":
			$wbcode = "LBY";
			break;
		case "LI":
			$wbcode = "LIE";
			break;
		case "LT":
			$wbcode = "LTU";
			break;
		case "LU":
			$wbcode = "LUX";
			break;
		case "MO":
			$wbcode = "MAC";
			break;
		case "MK":
			$wbcode = "MKD";
			break;
		case "MG":
			$wbcode = "MDG";
			break;
		case "MW":
			$wbcode = "MWI";
			break;
		case "MY":
			$wbcode = "MYS";
			break;
		case "MV":
			$wbcode = "MDV";
			break;
		case "ML":
			$wbcode = "MLI";
			break;
		case "MT":
			$wbcode = "MLT";
			break;
		case "MH":
			$wbcode = "MHL";
			break;
		case "MQ":
			$wbcode = "MQ";
			break;
		case "MR":
			$wbcode = "MRT";
			break;
		case "MU":
			$wbcode = "MUS";
			break;
		case "YT":
			$wbcode = "YT";
			break;
		case "MX":
			$wbcode = "MEX";
			break;
		case "FM":
			$wbcode = "FSM";
			break;
		case "MD":
			$wbcode = "MDA";
			break;
		case "MC":
			$wbcode = "MCO";
			break;
		case "MN":
			$wbcode = "MNG";
			break;
		case "ME":
			$wbcode = "MNE";
			break;
		case "MS":
			$wbcode = "MS";
			break;
		case "MA":
			$wbcode = "MAR";
			break;
		case "MZ":
			$wbcode = "MOZ";
			break;
		case "MM":
			$wbcode = "MMR";
			break;
		case "NA":
			$wbcode = "NAM";
			break;
		case "NR":
			$wbcode = "NR";
			break;
		case "NP":
			$wbcode = "NPL";
			break;
		case "NL":
			$wbcode = "NLD";
			break;
		case "NC":
			$wbcode = "NCL";
			break;
		case "NZ":
			$wbcode = "NZL";
			break;
		case "NI":
			$wbcode = "NIC";
			break;
		case "NE":
			$wbcode = "NER";
			break;
		case "NG":
			$wbcode = "NGA";
			break;
		case "NU":
			$wbcode = "NU";
			break;
		case "NF":
			$wbcode = "NF";
			break;
		case "MP":
			$wbcode = "MNP";
			break;
		case "NO":
			$wbcode = "NOR";
			break;
		case "OM":
			$wbcode = "OMN";
			break;
		case "PK":
			$wbcode = "PAK";
			break;
		case "PW":
			$wbcode = "PLW";
			break;
		case "PS":
			$wbcode = "PS";
			break;
		case "PA":
			$wbcode = "PAN";
			break;
		case "PG":
			$wbcode = "PNG";
			break;
		case "PY":
			$wbcode = "PRY";
			break;
		case "PE":
			$wbcode = "PER";
			break;
		case "PH":
			$wbcode = "PHL";
			break;
		case "PN":
			$wbcode = "PN";
			break;
		case "PL":
			$wbcode = "POL";
			break;
		case "PT":
			$wbcode = "PRT";
			break;
		case "PR":
			$wbcode = "PRI";
			break;
		case "QA":
			$wbcode = "QAT";
			break;
		case "RE":
			$wbcode = "RE";
			break;
		case "RO":
			$wbcode = "ROM";
			break;
		case "RU":
			$wbcode = "RUS";
			break;
		case "RW":
			$wbcode = "RWA";
			break;
		case "BL":
			$wbcode = "BL";
			break;
		case "SH":
			$wbcode = "SH";
			break;
		case "KN":
			$wbcode = "KN";
			break;
		case "LC":
			$wbcode = "LC";
			break;
		case "MF":
			$wbcode = "MF";
			break;
		case "PM":
			$wbcode = "PM";
			break;
		case "VC":
			$wbcode = "VC";
			break;
		case "WS":
			$wbcode = "WSM";
			break;
		case "SM":
			$wbcode = "SMR";
			break;
		case "ST":
			$wbcode = "STP";
			break;
		case "SA":
			$wbcode = "SAU";
			break;
		case "SN":
			$wbcode = "SEN";
			break;
		case "RS":
			$wbcode = "SRB";
			break;
		case "SC":
			$wbcode = "SYC";
			break;
		case "SL":
			$wbcode = "SLE";
			break;
		case "SG":
			$wbcode = "SGP";
			break;
		case "SX":
			$wbcode = "SXM";
			break;
		case "SK":
			$wbcode = "SVK";
			break;
		case "SI":
			$wbcode = "SVN";
			break;
		case "SB":
			$wbcode = "SLB";
			break;
		case "SO":
			$wbcode = "SOM";
			break;
		case "ZA":
			$wbcode = "ZAF";
			break;
		case "GS":
			$wbcode = "GS";
			break;
		case "SS":
			$wbcode = "SSD";
			break;
		case "ES":
			$wbcode = "ESP";
			break;
		case "LK":
			$wbcode = "LKA";
			break;
		case "SD":
			$wbcode = "SDN";
			break;
		case "SR":
			$wbcode = "SUR";
			break;
		case "SJ":
			$wbcode = "SJ";
			break;
		case "SZ":
			$wbcode = "SWZ";
			break;
		case "SE":
			$wbcode = "SWE";
			break;
		case "CH":
			$wbcode = "CHE";
			break;
		case "SY":
			$wbcode = "SYR";
			break;
		case "TW":
			$wbcode = "TW";
			break;
		case "TJ":
			$wbcode = "TJK";
			break;
		case "TZ":
			$wbcode = "TZA";
			break;
		case "TH":
			$wbcode = "THA";
			break;
		case "TL":
			$wbcode = "TMP";
			break;
		case "TG":
			$wbcode = "TGO";
			break;
		case "TK":
			$wbcode = "TK";
			break;
		case "TO":
			$wbcode = "TON";
			break;
		case "TT":
			$wbcode = "TTO";
			break;
		case "TN":
			$wbcode = "TUN";
			break;
		case "TR":
			$wbcode = "TUR";
			break;
		case "TM":
			$wbcode = "TKM";
			break;
		case "TC":
			$wbcode = "TCA";
			break;
		case "TV":
			$wbcode = "TUV";
			break;
		case "UG":
			$wbcode = "UGA";
			break;
		case "UA":
			$wbcode = "UKR";
			break;
		case "AE":
			$wbcode = "ARE";
			break;
		case "GB":
			$wbcode = "GBR";
			break;
		case "US":
			$wbcode = "USA";
			break;
		case "UM":
			$wbcode = "UM";
			break;
		case "UY":
			$wbcode = "URY";
			break;
		case "UZ":
			$wbcode = "UZB";
			break;
		case "VU":
			$wbcode = "VUT";
			break;
		case "VE":
			$wbcode = "VEN";
			break;
		case "VN":
			$wbcode = "VNM";
			break;
		case "VG":
			$wbcode = "VIR";
			break;
		case "VI":
			$wbcode = "VI";
			break;
		case "WF":
			$wbcode = "WF";
			break;
		case "EH":
			$wbcode = "EH";
			break;
		case "YE":
			$wbcode = "YEM";
			break;
		case "ZM":
			$wbcode = "ZMB";
			break;
		case "ZW":
			$wbcode = "ZWE";
			break;
		default:
			$wbcode = '';	
	}
	
	return $wbcode;
}
?>
