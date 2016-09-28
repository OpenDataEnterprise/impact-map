<?php
/*
 * file: functions.inc.php
 * version: 0.2.0
 */

/*
 * addWbRegions
 * Returns region dictionary for UN Location Code or region dictionary with null values if UN Location Code not found 
 *
 */
function addWbRegions($un_loc_code) {

	// Create region from json object (so we can get from server/api one day) 
	// Incomes updated to 2015 World Bank classifications. Note that Taiwan was attributed to a Region. 
	$regions_json = <<<JSON
{
"AF": {"ISO3166-1-UNLOC": "AF", "COUNTRY-NAME": "Afghanistan", "COUNTRY": "Afghanistan", "COUNTRY CODE": "AFG", "REGION": "South Asia", "REGION CODE": "SAS", "INCOME": "Low income", "INCOME CODE": "LIC"},
"AX": {"ISO3166-1-UNLOC": "AX", "COUNTRY-NAME": "Åland Islands", "COUNTRY": "null", "COUNTRY CODE": "null", "REGION": "null", "REGION CODE": "null", "INCOME": "null", "INCOME CODE": "null"},
"AL": {"ISO3166-1-UNLOC": "AL", "COUNTRY-NAME": "Albania", "COUNTRY": "Albania", "COUNTRY CODE": "ALB", "REGION": "Europe & Central Asia", "REGION CODE": "ECA", "INCOME": "Upper middle income", "INCOME CODE": "UMC"},
"DZ": {"ISO3166-1-UNLOC": "DZ", "COUNTRY-NAME": "Algeria", "COUNTRY": "Algeria", "COUNTRY CODE": "DZA", "REGION": "Middle East & North Africa", "REGION CODE": "MNA", "INCOME": "Upper middle income", "INCOME CODE": "UMC"},
"AS": {"ISO3166-1-UNLOC": "AS", "COUNTRY-NAME": "American Samoa", "COUNTRY": "American Samoa", "COUNTRY CODE": "ASM", "REGION": "East Asia & Pacific", "REGION CODE": "EAP", "INCOME": "Upper middle income", "INCOME CODE": "UMC"},
"AD": {"ISO3166-1-UNLOC": "AD", "COUNTRY-NAME": "Andorra", "COUNTRY": "Andorra", "COUNTRY CODE": "ADO", "REGION": "Europe & Central Asia", "REGION CODE": "ECA", "INCOME": "High income", "INCOME CODE": "HIC"},
"AO": {"ISO3166-1-UNLOC": "AO", "COUNTRY-NAME": "Angola", "COUNTRY": "Angola", "COUNTRY CODE": "AGO", "REGION": "Sub-Saharan Africa", "REGION CODE": "SSA", "INCOME": "Upper middle income", "INCOME CODE": "UMC"},
"AI": {"ISO3166-1-UNLOC": "AI", "COUNTRY-NAME": "Anguilla", "COUNTRY": "null", "COUNTRY CODE": "null", "REGION": "null", "REGION CODE": "null", "INCOME": "null", "INCOME CODE": "null"},
"AQ": {"ISO3166-1-UNLOC": "AQ", "COUNTRY-NAME": "Antarctica", "COUNTRY": "null", "COUNTRY CODE": "null", "REGION": "null", "REGION CODE": "null", "INCOME": "null", "INCOME CODE": "null"},
"AG": {"ISO3166-1-UNLOC": "AG", "COUNTRY-NAME": "Antigua and Barbuda", "COUNTRY": "Antigua and Barbuda", "COUNTRY CODE": "ATG", "REGION": "Latin America & Caribbean", "REGION CODE": "LAC", "INCOME": "High income", "INCOME CODE": "HIC"},
"AR": {"ISO3166-1-UNLOC": "AR", "COUNTRY-NAME": "Argentina", "COUNTRY": "Argentina", "COUNTRY CODE": "ARG", "REGION": "Latin America & Caribbean", "REGION CODE": "LAC", "INCOME": "High income", "INCOME CODE": "HIC"},
"AM": {"ISO3166-1-UNLOC": "AM", "COUNTRY-NAME": "Armenia", "COUNTRY": "Armenia", "COUNTRY CODE": "ARM", "REGION": "Europe & Central Asia", "REGION CODE": "ECA", "INCOME": "Lower middle income", "INCOME CODE": "LMC"},
"AW": {"ISO3166-1-UNLOC": "AW", "COUNTRY-NAME": "Aruba", "COUNTRY": "Aruba", "COUNTRY CODE": "ABW", "REGION": "Latin America & Caribbean", "REGION CODE": "LAC", "INCOME": "High income", "INCOME CODE": "HIC"},
"AU": {"ISO3166-1-UNLOC": "AU", "COUNTRY-NAME": "Australia", "COUNTRY": "Australia", "COUNTRY CODE": "AUS", "REGION": "East Asia & Pacific", "REGION CODE": "EAP", "INCOME": "High income", "INCOME CODE": "HIC"},
"AT": {"ISO3166-1-UNLOC": "AT", "COUNTRY-NAME": "Austria", "COUNTRY": "Austria", "COUNTRY CODE": "AUT", "REGION": "Europe & Central Asia", "REGION CODE": "ECA", "INCOME": "High income", "INCOME CODE": "HIC"},
"AZ": {"ISO3166-1-UNLOC": "AZ", "COUNTRY-NAME": "Azerbaijan", "COUNTRY": "Azerbaijan", "COUNTRY CODE": "AZE", "REGION": "Europe & Central Asia", "REGION CODE": "ECA", "INCOME": "Upper middle income", "INCOME CODE": "UMC"},
"BS": {"ISO3166-1-UNLOC": "BS", "COUNTRY-NAME": "Bahamas", "COUNTRY": "Bahamas, The", "COUNTRY CODE": "BHS", "REGION": "Latin America & Caribbean", "REGION CODE": "LAC", "INCOME": "High income", "INCOME CODE": "HIC"},
"BH": {"ISO3166-1-UNLOC": "BH", "COUNTRY-NAME": "Bahrain", "COUNTRY": "Bahrain", "COUNTRY CODE": "BHR", "REGION": "Middle East & North Africa", "REGION CODE": "MNA", "INCOME": "High income", "INCOME CODE": "HIC"},
"BD": {"ISO3166-1-UNLOC": "BD", "COUNTRY-NAME": "Bangladesh", "COUNTRY": "Bangladesh", "COUNTRY CODE": "BGD", "REGION": "South Asia", "REGION CODE": "SAS", "INCOME": "Low middle income", "INCOME CODE": "LMC"},
"BB": {"ISO3166-1-UNLOC": "BB", "COUNTRY-NAME": "Barbados", "COUNTRY": "Barbados", "COUNTRY CODE": "BRB", "REGION": "Latin America & Caribbean", "REGION CODE": "LAC", "INCOME": "High income", "INCOME CODE": "HIC"},
"BY": {"ISO3166-1-UNLOC": "BY", "COUNTRY-NAME": "Belarus", "COUNTRY": "Belarus", "COUNTRY CODE": "BLR", "REGION": "Europe & Central Asia", "REGION CODE": "ECA", "INCOME": "Upper middle income", "INCOME CODE": "UMC"},
"BE": {"ISO3166-1-UNLOC": "BE", "COUNTRY-NAME": "Belgium", "COUNTRY": "Belgium", "COUNTRY CODE": "BEL", "REGION": "Europe & Central Asia", "REGION CODE": "ECA", "INCOME": "High income", "INCOME CODE": "HIC"},
"BZ": {"ISO3166-1-UNLOC": "BZ", "COUNTRY-NAME": "Belize", "COUNTRY": "Belize", "COUNTRY CODE": "BLZ", "REGION": "Latin America & Caribbean", "REGION CODE": "LAC", "INCOME": "Upper middle income", "INCOME CODE": "UMC"},
"BJ": {"ISO3166-1-UNLOC": "BJ", "COUNTRY-NAME": "Benin", "COUNTRY": "Benin", "COUNTRY CODE": "BEN", "REGION": "Sub-Saharan Africa", "REGION CODE": "SSA", "INCOME": "Low income", "INCOME CODE": "LIC"},
"BM": {"ISO3166-1-UNLOC": "BM", "COUNTRY-NAME": "Bermuda", "COUNTRY": "Bermuda", "COUNTRY CODE": "BMU", "REGION": "Latin America & Caribbean", "REGION CODE": "LAC", "INCOME": "High income", "INCOME CODE": "HIC"},
"BT": {"ISO3166-1-UNLOC": "BT", "COUNTRY-NAME": "Bhutan", "COUNTRY": "Bhutan", "COUNTRY CODE": "BTN", "REGION": "South Asia", "REGION CODE": "SAS", "INCOME": "Lower middle income", "INCOME CODE": "LMC"},
"BO": {"ISO3166-1-UNLOC": "BO", "COUNTRY-NAME": "Bolivia", "COUNTRY": "Bolivia", "COUNTRY CODE": "BOL", "REGION": "Latin America & Caribbean", "REGION CODE": "LAC", "INCOME": "Lower middle income", "INCOME CODE": "LMC"},
"BQ": {"ISO3166-1-UNLOC": "BQ", "COUNTRY-NAME": "Bonaire, Sint Eustatius and Saba", "COUNTRY": "null", "COUNTRY CODE": "null", "REGION": "null", "REGION CODE": "null", "INCOME": "null", "INCOME CODE": "null"},
"BA": {"ISO3166-1-UNLOC": "BA", "COUNTRY-NAME": "Bosnia and Herzegovina", "COUNTRY": "Bosnia and Herzegovina", "COUNTRY CODE": "BIH", "REGION": "Europe & Central Asia", "REGION CODE": "ECA", "INCOME": "Upper middle income", "INCOME CODE": "UMC"},
"BW": {"ISO3166-1-UNLOC": "BW", "COUNTRY-NAME": "Botswana", "COUNTRY": "Botswana", "COUNTRY CODE": "BWA", "REGION": "Sub-Saharan Africa", "REGION CODE": "SSA", "INCOME": "Upper middle income", "INCOME CODE": "UMC"},
"BR": {"ISO3166-1-UNLOC": "BR", "COUNTRY-NAME": "Brazil", "COUNTRY": "Brazil", "COUNTRY CODE": "BRA", "REGION": "Latin America & Caribbean", "REGION CODE": "LAC", "INCOME": "Upper middle income", "INCOME CODE": "UMC"},
"IO": {"ISO3166-1-UNLOC": "IO", "COUNTRY-NAME": "British Indian Ocean Territory", "COUNTRY": "null", "COUNTRY CODE": "null", "REGION": "null", "REGION CODE": "null", "INCOME": "null", "INCOME CODE": "null"},
"BN": {"ISO3166-1-UNLOC": "BN", "COUNTRY-NAME": "Brunei Darussalam", "COUNTRY": "Brunei Darussalam", "COUNTRY CODE": "BRN", "REGION": "East Asia & Pacific", "REGION CODE": "EAP", "INCOME": "High income", "INCOME CODE": "HIC"},
"BG": {"ISO3166-1-UNLOC": "BG", "COUNTRY-NAME": "Bulgaria", "COUNTRY": "Bulgaria", "COUNTRY CODE": "BGR", "REGION": "Europe & Central Asia", "REGION CODE": "ECA", "INCOME": "Upper middle income", "INCOME CODE": "UMC"},
"BF": {"ISO3166-1-UNLOC": "BF", "COUNTRY-NAME": "Burkina Faso", "COUNTRY": "Burkina Faso", "COUNTRY CODE": "BFA", "REGION": "Sub-Saharan Africa", "REGION CODE": "SSA", "INCOME": "Low income", "INCOME CODE": "LIC"},
"BI": {"ISO3166-1-UNLOC": "BI", "COUNTRY-NAME": "Burundi", "COUNTRY": "Burundi", "COUNTRY CODE": "BDI", "REGION": "Sub-Saharan Africa", "REGION CODE": "SSA", "INCOME": "Low income", "INCOME CODE": "LIC"},
"KH": {"ISO3166-1-UNLOC": "KH", "COUNTRY-NAME": "Cambodia", "COUNTRY": "Cambodia", "COUNTRY CODE": "KHM", "REGION": "East Asia & Pacific", "REGION CODE": "EAP", "INCOME": "Low income", "INCOME CODE": "LIC"},
"CM": {"ISO3166-1-UNLOC": "CM", "COUNTRY-NAME": "Cameroon", "COUNTRY": "Cameroon", "COUNTRY CODE": "CMR", "REGION": "Sub-Saharan Africa", "REGION CODE": "SSA", "INCOME": "Lower middle income", "INCOME CODE": "LMC"},
"CA": {"ISO3166-1-UNLOC": "CA", "COUNTRY-NAME": "Canada", "COUNTRY": "Canada", "COUNTRY CODE": "CAN", "REGION": "North America", "REGION CODE": "NAM", "INCOME": "High income", "INCOME CODE": "HIC"},
"CV": {"ISO3166-1-UNLOC": "CV", "COUNTRY-NAME": "Cape Verde", "COUNTRY": "Cabo Verde", "COUNTRY CODE": "CPV", "REGION": "Sub-Saharan Africa", "REGION CODE": "SSA", "INCOME": "Lower middle income", "INCOME CODE": "LMC"},
"KY": {"ISO3166-1-UNLOC": "KY", "COUNTRY-NAME": "Cayman Islands", "COUNTRY": "Cayman Islands", "COUNTRY CODE": "CYM", "REGION": "Latin America & Caribbean", "REGION CODE": "LAC", "INCOME": "High income", "INCOME CODE": "HIC"},
"CF": {"ISO3166-1-UNLOC": "CF", "COUNTRY-NAME": "Central African Republic", "COUNTRY": "Central African Republic", "COUNTRY CODE": "CAF", "REGION": "Sub-Saharan Africa", "REGION CODE": "SSA", "INCOME": "Low income", "INCOME CODE": "LIC"},
"TD": {"ISO3166-1-UNLOC": "TD", "COUNTRY-NAME": "Chad", "COUNTRY": "Chad", "COUNTRY CODE": "TCD", "REGION": "Sub-Saharan Africa", "REGION CODE": "SSA", "INCOME": "Low income", "INCOME CODE": "LIC"},
"CL": {"ISO3166-1-UNLOC": "CL", "COUNTRY-NAME": "Chile", "COUNTRY": "Chile", "COUNTRY CODE": "CHL", "REGION": "Latin America & Caribbean", "REGION CODE": "LAC", "INCOME": "High income", "INCOME CODE": "HIC"},
"CN": {"ISO3166-1-UNLOC": "CN", "COUNTRY-NAME": "China", "COUNTRY": "China", "COUNTRY CODE": "CHN", "REGION": "East Asia & Pacific", "REGION CODE": "EAP", "INCOME": "Upper middle income", "INCOME CODE": "UMC"},
"CX": {"ISO3166-1-UNLOC": "CX", "COUNTRY-NAME": "Christmas Island", "COUNTRY": "null", "COUNTRY CODE": "null", "REGION": "null", "REGION CODE": "null", "INCOME": "null", "INCOME CODE": "null"},
"U1": {"ISO3166-1-UNLOC": "U1", "COUNTRY-NAME": "null", "COUNTRY": "Channel Islands", "COUNTRY CODE": "CHI", "REGION": "Europe & Central Asia", "REGION CODE": "ECA", "INCOME": "High income", "INCOME CODE": "HIC"},
"CC": {"ISO3166-1-UNLOC": "CC", "COUNTRY-NAME": "Cocos (Keeling) Islands", "COUNTRY": "", "COUNTRY CODE": "", "REGION": "", "REGION CODE": "", "INCOME": "", "INCOME CODE": ""},
"CO": {"ISO3166-1-UNLOC": "CO", "COUNTRY-NAME": "Colombia", "COUNTRY": "Colombia", "COUNTRY CODE": "COL", "REGION": "Latin America & Caribbean", "REGION CODE": "LAC", "INCOME": "Upper middle income", "INCOME CODE": "UMC"},
"KM": {"ISO3166-1-UNLOC": "KM", "COUNTRY-NAME": "Comoros", "COUNTRY": "Comoros", "COUNTRY CODE": "COM", "REGION": "Sub-Saharan Africa", "REGION CODE": "SSA", "INCOME": "Low income", "INCOME CODE": "LIC"},
"CG": {"ISO3166-1-UNLOC": "CG", "COUNTRY-NAME": "Congo", "COUNTRY": "Congo, Rep.", "COUNTRY CODE": "COG", "REGION": "Sub-Saharan Africa", "REGION CODE": "SSA", "INCOME": "Lower middle income", "INCOME CODE": "LMC"},
"CD": {"ISO3166-1-UNLOC": "CD", "COUNTRY-NAME": "Congo, The Democratic Republic of the", "COUNTRY": "Congo, Dem. Rep.", "COUNTRY CODE": "ZAR", "REGION": "Sub-Saharan Africa", "REGION CODE": "SSA", "INCOME": "Low income", "INCOME CODE": "LIC"},
"CK": {"ISO3166-1-UNLOC": "CK", "COUNTRY-NAME": "Cook Islands", "COUNTRY": "null", "COUNTRY CODE": "null", "REGION": "null", "REGION CODE": "null", "INCOME": "null", "INCOME CODE": "null"},
"CR": {"ISO3166-1-UNLOC": "CR", "COUNTRY-NAME": "Costa Rica", "COUNTRY": "Costa Rica", "COUNTRY CODE": "CRI", "REGION": "Latin America & Caribbean", "REGION CODE": "LAC", "INCOME": "Upper middle income", "INCOME CODE": "UMC"},
"CI": {"ISO3166-1-UNLOC": "CI", "COUNTRY-NAME": "Côte d'Ivoire", "COUNTRY": "Côte d'Ivoire", "COUNTRY CODE": "CIV", "REGION": "Sub-Saharan Africa", "REGION CODE": "SSA", "INCOME": "Lower middle income", "INCOME CODE": "LMC"},
"HR": {"ISO3166-1-UNLOC": "HR", "COUNTRY-NAME": "Croatia", "COUNTRY": "Croatia", "COUNTRY CODE": "HRV", "REGION": "Europe & Central Asia", "REGION CODE": "ECA", "INCOME": "High income", "INCOME CODE": "HIC"},
"CU": {"ISO3166-1-UNLOC": "CU", "COUNTRY-NAME": "Cuba", "COUNTRY": "Cuba", "COUNTRY CODE": "CUB", "REGION": "Latin America & Caribbean", "REGION CODE": "LAC", "INCOME": "Upper middle income", "INCOME CODE": "UMC"},
"CW": {"ISO3166-1-UNLOC": "CW", "COUNTRY-NAME": "Curaçao", "COUNTRY": "Curaçao", "COUNTRY CODE": "CUW", "REGION": "Latin America & Caribbean", "REGION CODE": "LAC", "INCOME": "High income", "INCOME CODE": "HIC"},
"CY": {"ISO3166-1-UNLOC": "CY", "COUNTRY-NAME": "Cyprus", "COUNTRY": "Cyprus", "COUNTRY CODE": "CYP", "REGION": "Europe & Central Asia", "REGION CODE": "ECA", "INCOME": "High income", "INCOME CODE": "HIC"},
"CZ": {"ISO3166-1-UNLOC": "CZ", "COUNTRY-NAME": "Czech Republic", "COUNTRY": "Czech Republic", "COUNTRY CODE": "CZE", "REGION": "Europe & Central Asia", "REGION CODE": "ECA", "INCOME": "High income", "INCOME CODE": "HIC"},
"DK": {"ISO3166-1-UNLOC": "DK", "COUNTRY-NAME": "Denmark", "COUNTRY": "Denmark", "COUNTRY CODE": "DNK", "REGION": "Europe & Central Asia", "REGION CODE": "ECA", "INCOME": "High income", "INCOME CODE": "HIC"},
"DJ": {"ISO3166-1-UNLOC": "DJ", "COUNTRY-NAME": "Djibouti", "COUNTRY": "Djibouti", "COUNTRY CODE": "DJI", "REGION": "Middle East & North Africa", "REGION CODE": "MNA", "INCOME": "Lower middle income", "INCOME CODE": "LMC"},
"DM": {"ISO3166-1-UNLOC": "DM", "COUNTRY-NAME": "Dominica", "COUNTRY": "Dominica", "COUNTRY CODE": "DMA", "REGION": "Latin America & Caribbean", "REGION CODE": "LAC", "INCOME": "Upper middle income", "INCOME CODE": "UMC"},
"DO": {"ISO3166-1-UNLOC": "DO", "COUNTRY-NAME": "Dominican Republic", "COUNTRY": "Dominican Republic", "COUNTRY CODE": "DOM", "REGION": "Latin America & Caribbean", "REGION CODE": "LAC", "INCOME": "Upper middle income", "INCOME CODE": "UMC"},
"EC": {"ISO3166-1-UNLOC": "EC", "COUNTRY-NAME": "Ecuador", "COUNTRY": "Ecuador", "COUNTRY CODE": "ECU", "REGION": "Latin America & Caribbean", "REGION CODE": "LAC", "INCOME": "Upper middle income", "INCOME CODE": "UMC"},
"EG": {"ISO3166-1-UNLOC": "EG", "COUNTRY-NAME": "Egypt", "COUNTRY": "Egypt, Arab Rep.", "COUNTRY CODE": "EGY", "REGION": "Middle East & North Africa", "REGION CODE": "MNA", "INCOME": "Lower middle income", "INCOME CODE": "LMC"},
"SV": {"ISO3166-1-UNLOC": "SV", "COUNTRY-NAME": "El Salvador", "COUNTRY": "El Salvador", "COUNTRY CODE": "SLV", "REGION": "Latin America & Caribbean", "REGION CODE": "LAC", "INCOME": "Lower middle income", "INCOME CODE": "LMC"},
"GQ": {"ISO3166-1-UNLOC": "GQ", "COUNTRY-NAME": "Equatorial Guinea", "COUNTRY": "Equatorial Guinea", "COUNTRY CODE": "GNQ", "REGION": "Sub-Saharan Africa", "REGION CODE": "SSA", "INCOME": "High income", "INCOME CODE": "HIC"},
"ER": {"ISO3166-1-UNLOC": "ER", "COUNTRY-NAME": "Eritrea", "COUNTRY": "Eritrea", "COUNTRY CODE": "ERI", "REGION": "Sub-Saharan Africa", "REGION CODE": "SSA", "INCOME": "Low income", "INCOME CODE": "LIC"},
"EE": {"ISO3166-1-UNLOC": "EE", "COUNTRY-NAME": "Estonia", "COUNTRY": "Estonia", "COUNTRY CODE": "EST", "REGION": "Europe & Central Asia", "REGION CODE": "ECA", "INCOME": "High income", "INCOME CODE": "HIC"},
"ET": {"ISO3166-1-UNLOC": "ET", "COUNTRY-NAME": "Ethiopia", "COUNTRY": "Ethiopia", "COUNTRY CODE": "ETH", "REGION": "Sub-Saharan Africa", "REGION CODE": "SSA", "INCOME": "Low income", "INCOME CODE": "LIC"},
"FK": {"ISO3166-1-UNLOC": "FK", "COUNTRY-NAME": "Falkland Islands (Malvinas)", "COUNTRY": "", "COUNTRY CODE": "", "REGION": "", "REGION CODE": "", "INCOME": "", "INCOME CODE": ""},
"FO": {"ISO3166-1-UNLOC": "FO", "COUNTRY-NAME": "Faroe Islands", "COUNTRY": "Faeroe Islands", "COUNTRY CODE": "FRO", "REGION": "Europe & Central Asia", "REGION CODE": "ECA", "INCOME": "High income", "INCOME CODE": "HIC"},
"FJ": {"ISO3166-1-UNLOC": "FJ", "COUNTRY-NAME": "Fiji", "COUNTRY": "Fiji", "COUNTRY CODE": "FJI", "REGION": "East Asia & Pacific", "REGION CODE": "EAP", "INCOME": "Upper middle income", "INCOME CODE": "UMC"},
"FI": {"ISO3166-1-UNLOC": "FI", "COUNTRY-NAME": "Finland", "COUNTRY": "Finland", "COUNTRY CODE": "FIN", "REGION": "Europe & Central Asia", "REGION CODE": "ECA", "INCOME": "High income", "INCOME CODE": "HIC"},
"FR": {"ISO3166-1-UNLOC": "FR", "COUNTRY-NAME": "France", "COUNTRY": "France", "COUNTRY CODE": "FRA", "REGION": "Europe & Central Asia", "REGION CODE": "ECA", "INCOME": "High income", "INCOME CODE": "HIC"},
"GF": {"ISO3166-1-UNLOC": "GF", "COUNTRY-NAME": "French Guiana", "COUNTRY": "null", "COUNTRY CODE": "null", "REGION": "null", "REGION CODE": "null", "INCOME": "null", "INCOME CODE": "null"},
"PF": {"ISO3166-1-UNLOC": "PF", "COUNTRY-NAME": "French Polynesia", "COUNTRY": "French Polynesia", "COUNTRY CODE": "PYF", "REGION": "East Asia & Pacific", "REGION CODE": "EAP", "INCOME": "High income", "INCOME CODE": "HIC"},
"TF": {"ISO3166-1-UNLOC": "TF", "COUNTRY-NAME": "French Southern Territories", "COUNTRY": "null", "COUNTRY CODE": "null", "REGION": "null", "REGION CODE": "null", "INCOME": "null", "INCOME CODE": "null"},
"GA": {"ISO3166-1-UNLOC": "GA", "COUNTRY-NAME": "Gabon", "COUNTRY": "Gabon", "COUNTRY CODE": "GAB", "REGION": "Sub-Saharan Africa", "REGION CODE": "SSA", "INCOME": "Upper middle income", "INCOME CODE": "UMC"},
"GM": {"ISO3166-1-UNLOC": "GM", "COUNTRY-NAME": "Gambia", "COUNTRY": "Gambia, The", "COUNTRY CODE": "GMB", "REGION": "Sub-Saharan Africa", "REGION CODE": "SSA", "INCOME": "Low income", "INCOME CODE": "LIC"},
"GE": {"ISO3166-1-UNLOC": "GE", "COUNTRY-NAME": "Georgia", "COUNTRY": "Georgia", "COUNTRY CODE": "GEO", "REGION": "Europe & Central Asia", "REGION CODE": "ECA", "INCOME": "Lower middle income", "INCOME CODE": "LMC"},
"DE": {"ISO3166-1-UNLOC": "DE", "COUNTRY-NAME": "Germany", "COUNTRY": "Germany", "COUNTRY CODE": "DEU", "REGION": "Europe & Central Asia", "REGION CODE": "ECA", "INCOME": "High income", "INCOME CODE": "HIC"},
"GH": {"ISO3166-1-UNLOC": "GH", "COUNTRY-NAME": "Ghana", "COUNTRY": "Ghana", "COUNTRY CODE": "GHA", "REGION": "Sub-Saharan Africa", "REGION CODE": "SSA", "INCOME": "Lower middle income", "INCOME CODE": "LMC"},
"GI": {"ISO3166-1-UNLOC": "GI", "COUNTRY-NAME": "Gibraltar", "COUNTRY": "null", "COUNTRY CODE": "null", "REGION": "null", "REGION CODE": "null", "INCOME": "null", "INCOME CODE": "null"},
"GR": {"ISO3166-1-UNLOC": "GR", "COUNTRY-NAME": "Greece", "COUNTRY": "Greece", "COUNTRY CODE": "GRC", "REGION": "Europe & Central Asia", "REGION CODE": "ECA", "INCOME": "High income", "INCOME CODE": "HIC"},
"GL": {"ISO3166-1-UNLOC": "GL", "COUNTRY-NAME": "Greenland", "COUNTRY": "Greenland", "COUNTRY CODE": "GRL", "REGION": "Europe & Central Asia", "REGION CODE": "ECA", "INCOME": "High income", "INCOME CODE": "HIC"},
"GD": {"ISO3166-1-UNLOC": "GD", "COUNTRY-NAME": "Grenada", "COUNTRY": "Grenada", "COUNTRY CODE": "GRD", "REGION": "Latin America & Caribbean", "REGION CODE": "LAC", "INCOME": "Upper middle income", "INCOME CODE": "UMC"},
"GP": {"ISO3166-1-UNLOC": "GP", "COUNTRY-NAME": "Guadeloupe", "COUNTRY": "null", "COUNTRY CODE": "null", "REGION": "null", "REGION CODE": "null", "INCOME": "null", "INCOME CODE": "null"},
"GU": {"ISO3166-1-UNLOC": "GU", "COUNTRY-NAME": "Guam", "COUNTRY": "Guam", "COUNTRY CODE": "GUM", "REGION": "East Asia & Pacific", "REGION CODE": "EAP", "INCOME": "High income", "INCOME CODE": "HIC"},
"GT": {"ISO3166-1-UNLOC": "GT", "COUNTRY-NAME": "Guatemala", "COUNTRY": "Guatemala", "COUNTRY CODE": "GTM", "REGION": "Latin America & Caribbean", "REGION CODE": "LAC", "INCOME": "Lower middle income", "INCOME CODE": "LMC"},
"GG": {"ISO3166-1-UNLOC": "GG", "COUNTRY-NAME": "Guernsey", "COUNTRY": "null", "COUNTRY CODE": "null", "REGION": "null", "REGION CODE": "null", "INCOME": "null", "INCOME CODE": "null"},
"GN": {"ISO3166-1-UNLOC": "GN", "COUNTRY-NAME": "Guinea", "COUNTRY": "Guinea", "COUNTRY CODE": "GIN", "REGION": "Sub-Saharan Africa", "REGION CODE": "SSA", "INCOME": "Low income", "INCOME CODE": "LIC"},
"GW": {"ISO3166-1-UNLOC": "GW", "COUNTRY-NAME": "Guinea-Bissau", "COUNTRY": "Guinea-Bissau", "COUNTRY CODE": "GNB", "REGION": "Sub-Saharan Africa", "REGION CODE": "SSA", "INCOME": "Low income", "INCOME CODE": "LIC"},
"GY": {"ISO3166-1-UNLOC": "GY", "COUNTRY-NAME": "Guyana", "COUNTRY": "Guyana", "COUNTRY CODE": "GUY", "REGION": "Latin America & Caribbean", "REGION CODE": "LAC", "INCOME": "Lower middle income", "INCOME CODE": "LMC"},
"HT": {"ISO3166-1-UNLOC": "HT", "COUNTRY-NAME": "Haiti", "COUNTRY": "Haiti", "COUNTRY CODE": "HTI", "REGION": "Latin America & Caribbean", "REGION CODE": "LAC", "INCOME": "Low income", "INCOME CODE": "LIC"},
"HM": {"ISO3166-1-UNLOC": "HM", "COUNTRY-NAME": "Heard Island and McDonald Islands", "COUNTRY": "null", "COUNTRY CODE": "null", "REGION": "null", "REGION CODE": "null", "INCOME": "null", "INCOME CODE": "null"},
"VA": {"ISO3166-1-UNLOC": "VA", "COUNTRY-NAME": "Holy See (Vatican City State)", "COUNTRY": "null", "COUNTRY CODE": "null", "REGION": "null", "REGION CODE": "null", "INCOME": "null", "INCOME CODE": "null"},
"HN": {"ISO3166-1-UNLOC": "HN", "COUNTRY-NAME": "Honduras", "COUNTRY": "Honduras", "COUNTRY CODE": "HND", "REGION": "Latin America & Caribbean", "REGION CODE": "LAC", "INCOME": "Lower middle income", "INCOME CODE": "LMC"},
"HK": {"ISO3166-1-UNLOC": "HK", "COUNTRY-NAME": "Hong Kong", "COUNTRY": "Hong Kong SAR, China", "COUNTRY CODE": "HKG", "REGION": "East Asia & Pacific", "REGION CODE": "EAP", "INCOME": "High income", "INCOME CODE": "HIC"},
"HU": {"ISO3166-1-UNLOC": "HU", "COUNTRY-NAME": "Hungary", "COUNTRY": "Hungary", "COUNTRY CODE": "HUN", "REGION": "Europe & Central Asia", "REGION CODE": "ECA", "INCOME": "High income", "INCOME CODE": "HIC"},
"IS": {"ISO3166-1-UNLOC": "IS", "COUNTRY-NAME": "Iceland", "COUNTRY": "Iceland", "COUNTRY CODE": "ISL", "REGION": "Europe & Central Asia", "REGION CODE": "ECA", "INCOME": "High income", "INCOME CODE": "HIC"},
"IN": {"ISO3166-1-UNLOC": "IN", "COUNTRY-NAME": "India", "COUNTRY": "India", "COUNTRY CODE": "IND", "REGION": "South Asia", "REGION CODE": "SAS", "INCOME": "Lower middle income", "INCOME CODE": "LMC"},
"ID": {"ISO3166-1-UNLOC": "ID", "COUNTRY-NAME": "Indonesia", "COUNTRY": "Indonesia", "COUNTRY CODE": "IDN", "REGION": "East Asia & Pacific", "REGION CODE": "EAP", "INCOME": "Lower middle income", "INCOME CODE": "LMC"},
"XZ": {"ISO3166-1-UNLOC": "XZ", "COUNTRY-NAME": "Installations in International Waters", "COUNTRY": "null", "COUNTRY CODE": "null", "REGION": "null", "REGION CODE": "null", "INCOME": "null", "INCOME CODE": "null"},
"IR": {"ISO3166-1-UNLOC": "IR", "COUNTRY-NAME": "Iran, Islamic Republic of", "COUNTRY": "Iran, Islamic Rep.", "COUNTRY CODE": "IRN", "REGION": "Middle East & North Africa", "REGION CODE": "MNA", "INCOME": "Upper middle income", "INCOME CODE": "UMC"},
"IQ": {"ISO3166-1-UNLOC": "IQ", "COUNTRY-NAME": "Iraq", "COUNTRY": "Iraq", "COUNTRY CODE": "IRQ", "REGION": "Middle East & North Africa", "REGION CODE": "MNA", "INCOME": "Upper middle income", "INCOME CODE": "UMC"},
"IE": {"ISO3166-1-UNLOC": "IE", "COUNTRY-NAME": "Ireland", "COUNTRY": "Ireland", "COUNTRY CODE": "IRL", "REGION": "Europe & Central Asia", "REGION CODE": "ECA", "INCOME": "High income", "INCOME CODE": "HIC"},
"IM": {"ISO3166-1-UNLOC": "IM", "COUNTRY-NAME": "Isle of Man", "COUNTRY": "Isle of Man", "COUNTRY CODE": "IMY", "REGION": "Europe & Central Asia", "REGION CODE": "ECA", "INCOME": "High income", "INCOME CODE": "HIC"},
"IL": {"ISO3166-1-UNLOC": "IL", "COUNTRY-NAME": "Israel", "COUNTRY": "Israel", "COUNTRY CODE": "ISR", "REGION": "Middle East & North Africa", "REGION CODE": "MNA", "INCOME": "High income", "INCOME CODE": "HIC"},
"IT": {"ISO3166-1-UNLOC": "IT", "COUNTRY-NAME": "Italy", "COUNTRY": "Italy", "COUNTRY CODE": "ITA", "REGION": "Europe & Central Asia", "REGION CODE": "ECA", "INCOME": "High income", "INCOME CODE": "HIC"},
"JM": {"ISO3166-1-UNLOC": "JM", "COUNTRY-NAME": "Jamaica", "COUNTRY": "Jamaica", "COUNTRY CODE": "JAM", "REGION": "Latin America & Caribbean", "REGION CODE": "LAC", "INCOME": "Upper middle income", "INCOME CODE": "UMC"},
"JP": {"ISO3166-1-UNLOC": "JP", "COUNTRY-NAME": "Japan", "COUNTRY": "Japan", "COUNTRY CODE": "JPN", "REGION": "East Asia & Pacific", "REGION CODE": "EAP", "INCOME": "High income", "INCOME CODE": "HIC"},
"JE": {"ISO3166-1-UNLOC": "JE", "COUNTRY-NAME": "Jersey", "COUNTRY": "null", "COUNTRY CODE": "null", "REGION": "null", "REGION CODE": "null", "INCOME": "null", "INCOME CODE": "null"},
"JO": {"ISO3166-1-UNLOC": "JO", "COUNTRY-NAME": "Jordan", "COUNTRY": "Jordan", "COUNTRY CODE": "JOR", "REGION": "Middle East & North Africa", "REGION CODE": "MNA", "INCOME": "Upper middle income", "INCOME CODE": "UMC"},
"KZ": {"ISO3166-1-UNLOC": "KZ", "COUNTRY-NAME": "Kazakhstan", "COUNTRY": "Kazakhstan", "COUNTRY CODE": "KAZ", "REGION": "Europe & Central Asia", "REGION CODE": "ECA", "INCOME": "Upper middle income", "INCOME CODE": "UMC"},
"KE": {"ISO3166-1-UNLOC": "KE", "COUNTRY-NAME": "Kenya", "COUNTRY": "Kenya", "COUNTRY CODE": "KEN", "REGION": "Sub-Saharan Africa", "REGION CODE": "SSA", "INCOME": "Lower middle income", "INCOME CODE": "LMC"},
"KI": {"ISO3166-1-UNLOC": "KI", "COUNTRY-NAME": "Kiribati", "COUNTRY": "Kiribati", "COUNTRY CODE": "KIR", "REGION": "East Asia & Pacific", "REGION CODE": "EAP", "INCOME": "Lower middle income", "INCOME CODE": "LMC"},
"KP": {"ISO3166-1-UNLOC": "KP", "COUNTRY-NAME": "Korea, Democratic People's Republic of", "COUNTRY": "Korea, Dem. Rep.", "COUNTRY CODE": "PRK", "REGION": "East Asia & Pacific", "REGION CODE": "EAP", "INCOME": "Low income", "INCOME CODE": "LIC"},
"KR": {"ISO3166-1-UNLOC": "KR", "COUNTRY-NAME": "Korea, Republic of", "COUNTRY": "Korea, Rep.", "COUNTRY CODE": "KOR", "REGION": "East Asia & Pacific", "REGION CODE": "EAP", "INCOME": "High income", "INCOME CODE": "HIC"},
"U2": {"ISO3166-1-UNLOC": "U2", "COUNTRY-NAME": "null", "COUNTRY": "Kosovo", "COUNTRY CODE": "KSV", "REGION": "Europe & Central Asia", "REGION CODE": "ECA", "INCOME": "Lower middle income", "INCOME CODE": "LMC"},
"KW": {"ISO3166-1-UNLOC": "KW", "COUNTRY-NAME": "Kuwait", "COUNTRY": "Kuwait", "COUNTRY CODE": "KWT", "REGION": "Middle East & North Africa", "REGION CODE": "MNA", "INCOME": "High income", "INCOME CODE": "HIC"},
"KG": {"ISO3166-1-UNLOC": "KG", "COUNTRY-NAME": "Kyrgyzstan", "COUNTRY": "Kyrgyz Republic", "COUNTRY CODE": "KGZ", "REGION": "Europe & Central Asia", "REGION CODE": "ECA", "INCOME": "Lower middle income", "INCOME CODE": "LMC"},
"LA": {"ISO3166-1-UNLOC": "LA", "COUNTRY-NAME": "Lao People's Democratic Republic", "COUNTRY": "Lao PDR", "COUNTRY CODE": "LAO", "REGION": "East Asia & Pacific", "REGION CODE": "EAP", "INCOME": "Lower middle income", "INCOME CODE": "LMC"},
"LV": {"ISO3166-1-UNLOC": "LV", "COUNTRY-NAME": "Latvia", "COUNTRY": "Latvia", "COUNTRY CODE": "LVA", "REGION": "Europe & Central Asia", "REGION CODE": "ECA", "INCOME": "High income", "INCOME CODE": "HIC"},
"LB": {"ISO3166-1-UNLOC": "LB", "COUNTRY-NAME": "Lebanon", "COUNTRY": "Lebanon", "COUNTRY CODE": "LBN", "REGION": "Middle East & North Africa", "REGION CODE": "MNA", "INCOME": "Upper middle income", "INCOME CODE": "UMC"},
"LS": {"ISO3166-1-UNLOC": "LS", "COUNTRY-NAME": "Lesotho", "COUNTRY": "Lesotho", "COUNTRY CODE": "LSO", "REGION": "Sub-Saharan Africa", "REGION CODE": "SSA", "INCOME": "Lower middle income", "INCOME CODE": "LMC"},
"LR": {"ISO3166-1-UNLOC": "LR", "COUNTRY-NAME": "Liberia", "COUNTRY": "Liberia", "COUNTRY CODE": "LBR", "REGION": "Sub-Saharan Africa", "REGION CODE": "SSA", "INCOME": "Low income", "INCOME CODE": "LIC"},
"LY": {"ISO3166-1-UNLOC": "LY", "COUNTRY-NAME": "Libya", "COUNTRY": "Libya", "COUNTRY CODE": "LBY", "REGION": "Middle East & North Africa", "REGION CODE": "MNA", "INCOME": "Upper middle income", "INCOME CODE": "UMC"},
"LI": {"ISO3166-1-UNLOC": "LI", "COUNTRY-NAME": "Liechtenstein", "COUNTRY": "Liechtenstein", "COUNTRY CODE": "LIE", "REGION": "Europe & Central Asia", "REGION CODE": "ECA", "INCOME": "High income", "INCOME CODE": "HIC"},
"LT": {"ISO3166-1-UNLOC": "LT", "COUNTRY-NAME": "Lithuania", "COUNTRY": "Lithuania", "COUNTRY CODE": "LTU", "REGION": "Europe & Central Asia", "REGION CODE": "ECA", "INCOME": "High income", "INCOME CODE": "HIC"},
"LU": {"ISO3166-1-UNLOC": "LU", "COUNTRY-NAME": "Luxembourg", "COUNTRY": "Luxembourg", "COUNTRY CODE": "LUX", "REGION": "Europe & Central Asia", "REGION CODE": "ECA", "INCOME": "High income", "INCOME CODE": "HIC"},
"MO": {"ISO3166-1-UNLOC": "MO", "COUNTRY-NAME": "Macao", "COUNTRY": "Macao SAR, China", "COUNTRY CODE": "MAC", "REGION": "East Asia & Pacific", "REGION CODE": "EAP", "INCOME": "High income", "INCOME CODE": "HIC"},
"MK": {"ISO3166-1-UNLOC": "MK", "COUNTRY-NAME": "Macedonia, The former Yugoslav Republic of", "COUNTRY": "Macedonia, FYR", "COUNTRY CODE": "MKD", "REGION": "Europe & Central Asia", "REGION CODE": "ECA", "INCOME": "Upper middle income", "INCOME CODE": "UMC"},
"MG": {"ISO3166-1-UNLOC": "MG", "COUNTRY-NAME": "Madagascar", "COUNTRY": "Madagascar", "COUNTRY CODE": "MDG", "REGION": "Sub-Saharan Africa", "REGION CODE": "SSA", "INCOME": "Low income", "INCOME CODE": "LIC"},
"MW": {"ISO3166-1-UNLOC": "MW", "COUNTRY-NAME": "Malawi", "COUNTRY": "Malawi", "COUNTRY CODE": "MWI", "REGION": "Sub-Saharan Africa", "REGION CODE": "SSA", "INCOME": "Low income", "INCOME CODE": "LIC"},
"MY": {"ISO3166-1-UNLOC": "MY", "COUNTRY-NAME": "Malaysia", "COUNTRY": "Malaysia", "COUNTRY CODE": "MYS", "REGION": "East Asia & Pacific", "REGION CODE": "EAP", "INCOME": "Upper middle income", "INCOME CODE": "UMC"},
"MV": {"ISO3166-1-UNLOC": "MV", "COUNTRY-NAME": "Maldives", "COUNTRY": "Maldives", "COUNTRY CODE": "MDV", "REGION": "South Asia", "REGION CODE": "SAS", "INCOME": "Upper middle income", "INCOME CODE": "UMC"},
"ML": {"ISO3166-1-UNLOC": "ML", "COUNTRY-NAME": "Mali", "COUNTRY": "Mali", "COUNTRY CODE": "MLI", "REGION": "Sub-Saharan Africa", "REGION CODE": "SSA", "INCOME": "Low income", "INCOME CODE": "LIC"},
"MT": {"ISO3166-1-UNLOC": "MT", "COUNTRY-NAME": "Malta", "COUNTRY": "Malta", "COUNTRY CODE": "MLT", "REGION": "Europe & Central Asia", "REGION CODE": "ECA", "INCOME": "High income", "INCOME CODE": "HIC"},
"MH": {"ISO3166-1-UNLOC": "MH", "COUNTRY-NAME": "Marshall Islands", "COUNTRY": "Marshall Islands", "COUNTRY CODE": "MHL", "REGION": "East Asia & Pacific", "REGION CODE": "EAP", "INCOME": "Upper middle income", "INCOME CODE": "UMC"},
"MQ": {"ISO3166-1-UNLOC": "MQ", "COUNTRY-NAME": "Martinique", "COUNTRY": "null", "COUNTRY CODE": "null", "REGION": "null", "REGION CODE": "null", "INCOME": "null", "INCOME CODE": "null"},
"MR": {"ISO3166-1-UNLOC": "MR", "COUNTRY-NAME": "Mauritania", "COUNTRY": "Mauritania", "COUNTRY CODE": "MRT", "REGION": "Sub-Saharan Africa", "REGION CODE": "SSA", "INCOME": "Lower middle income", "INCOME CODE": "LMC"},
"MU": {"ISO3166-1-UNLOC": "MU", "COUNTRY-NAME": "Mauritius", "COUNTRY": "Mauritius", "COUNTRY CODE": "MUS", "REGION": "Sub-Saharan Africa", "REGION CODE": "SSA", "INCOME": "Upper middle income", "INCOME CODE": "UMC"},
"YT": {"ISO3166-1-UNLOC": "YT", "COUNTRY-NAME": "Mayotte", "COUNTRY": "null", "COUNTRY CODE": "null", "REGION": "null", "REGION CODE": "null", "INCOME": "null", "INCOME CODE": "null"},
"MX": {"ISO3166-1-UNLOC": "MX", "COUNTRY-NAME": "Mexico", "COUNTRY": "Mexico", "COUNTRY CODE": "MEX", "REGION": "Latin America & Caribbean", "REGION CODE": "LAC", "INCOME": "Upper middle income", "INCOME CODE": "UMC"},
"FM": {"ISO3166-1-UNLOC": "FM", "COUNTRY-NAME": "Micronesia, Federated States of", "COUNTRY": "Micronesia, Fed. Sts.", "COUNTRY CODE": "FSM", "REGION": "East Asia & Pacific", "REGION CODE": "EAP", "INCOME": "Lower middle income", "INCOME CODE": "LMC"},
"MD": {"ISO3166-1-UNLOC": "MD", "COUNTRY-NAME": "Moldova, Republic of", "COUNTRY": "Moldova", "COUNTRY CODE": "MDA", "REGION": "Europe & Central Asia", "REGION CODE": "ECA", "INCOME": "Lower middle income", "INCOME CODE": "LMC"},
"MC": {"ISO3166-1-UNLOC": "MC", "COUNTRY-NAME": "Monaco", "COUNTRY": "Monaco", "COUNTRY CODE": "MCO", "REGION": "Europe & Central Asia", "REGION CODE": "ECA", "INCOME": "High income", "INCOME CODE": "HIC"},
"MN": {"ISO3166-1-UNLOC": "MN", "COUNTRY-NAME": "Mongolia", "COUNTRY": "Mongolia", "COUNTRY CODE": "MNG", "REGION": "East Asia & Pacific", "REGION CODE": "EAP", "INCOME": "Upper middle income", "INCOME CODE": "UMC"},
"ME": {"ISO3166-1-UNLOC": "ME", "COUNTRY-NAME": "Montenegro", "COUNTRY": "Montenegro", "COUNTRY CODE": "MNE", "REGION": "Europe & Central Asia", "REGION CODE": "ECA", "INCOME": "Upper middle income", "INCOME CODE": "UMC"},
"MS": {"ISO3166-1-UNLOC": "MS", "COUNTRY-NAME": "Montserrat", "COUNTRY": "null", "COUNTRY CODE": "null", "REGION": "null", "REGION CODE": "null", "INCOME": "null", "INCOME CODE": "null"},
"MA": {"ISO3166-1-UNLOC": "MA", "COUNTRY-NAME": "Morocco", "COUNTRY": "Morocco", "COUNTRY CODE": "MAR", "REGION": "Middle East & North Africa", "REGION CODE": "MNA", "INCOME": "Lower middle income", "INCOME CODE": "LMC"},
"MZ": {"ISO3166-1-UNLOC": "MZ", "COUNTRY-NAME": "Mozambique", "COUNTRY": "Mozambique", "COUNTRY CODE": "MOZ", "REGION": "Sub-Saharan Africa", "REGION CODE": "SSA", "INCOME": "Low income", "INCOME CODE": "LIC"},
"MM": {"ISO3166-1-UNLOC": "MM", "COUNTRY-NAME": "Myanmar", "COUNTRY": "Myanmar", "COUNTRY CODE": "MMR", "REGION": "East Asia & Pacific", "REGION CODE": "EAP", "INCOME": "Lower middle income", "INCOME CODE": "LMC"},
"NA": {"ISO3166-1-UNLOC": "NA", "COUNTRY-NAME": "Namibia", "COUNTRY": "Namibia", "COUNTRY CODE": "NAM", "REGION": "Sub-Saharan Africa", "REGION CODE": "SSA", "INCOME": "Upper middle income", "INCOME CODE": "UMC"},
"NR": {"ISO3166-1-UNLOC": "NR", "COUNTRY-NAME": "Nauru", "COUNTRY": "null", "COUNTRY CODE": "null", "REGION": "null", "REGION CODE": "null", "INCOME": "null", "INCOME CODE": "null"},
"NP": {"ISO3166-1-UNLOC": "NP", "COUNTRY-NAME": "Nepal", "COUNTRY": "Nepal", "COUNTRY CODE": "NPL", "REGION": "South Asia", "REGION CODE": "SAS", "INCOME": "Low income", "INCOME CODE": "LIC"},
"NL": {"ISO3166-1-UNLOC": "NL", "COUNTRY-NAME": "Netherlands", "COUNTRY": "Netherlands", "COUNTRY CODE": "NLD", "REGION": "Europe & Central Asia", "REGION CODE": "ECA", "INCOME": "High income", "INCOME CODE": "HIC"},
"NC": {"ISO3166-1-UNLOC": "NC", "COUNTRY-NAME": "New Caledonia", "COUNTRY": "New Caledonia", "COUNTRY CODE": "NCL", "REGION": "East Asia & Pacific", "REGION CODE": "EAP", "INCOME": "High income", "INCOME CODE": "HIC"},
"NZ": {"ISO3166-1-UNLOC": "NZ", "COUNTRY-NAME": "New Zealand", "COUNTRY": "New Zealand", "COUNTRY CODE": "NZL", "REGION": "East Asia & Pacific", "REGION CODE": "EAP", "INCOME": "High income", "INCOME CODE": "HIC"},
"NI": {"ISO3166-1-UNLOC": "NI", "COUNTRY-NAME": "Nicaragua", "COUNTRY": "Nicaragua", "COUNTRY CODE": "NIC", "REGION": "Latin America & Caribbean", "REGION CODE": "LAC", "INCOME": "Lower middle income", "INCOME CODE": "LMC"},
"NE": {"ISO3166-1-UNLOC": "NE", "COUNTRY-NAME": "Niger", "COUNTRY": "Niger", "COUNTRY CODE": "NER", "REGION": "Sub-Saharan Africa", "REGION CODE": "SSA", "INCOME": "Low income", "INCOME CODE": "LIC"},
"NG": {"ISO3166-1-UNLOC": "NG", "COUNTRY-NAME": "Nigeria", "COUNTRY": "Nigeria", "COUNTRY CODE": "NGA", "REGION": "Sub-Saharan Africa", "REGION CODE": "SSA", "INCOME": "Lower middle income", "INCOME CODE": "LMC"},
"NU": {"ISO3166-1-UNLOC": "NU", "COUNTRY-NAME": "Niue", "COUNTRY": "null", "COUNTRY CODE": "null", "REGION": "null", "REGION CODE": "null", "INCOME": "null", "INCOME CODE": "null"},
"NF": {"ISO3166-1-UNLOC": "NF", "COUNTRY-NAME": "Norfolk Island", "COUNTRY": "null", "COUNTRY CODE": "null", "REGION": "null", "REGION CODE": "null", "INCOME": "null", "INCOME CODE": "null"},
"MP": {"ISO3166-1-UNLOC": "MP", "COUNTRY-NAME": "Northern Mariana Islands", "COUNTRY": "Northern Mariana Islands", "COUNTRY CODE": "MNP", "REGION": "East Asia & Pacific", "REGION CODE": "EAP", "INCOME": "High income", "INCOME CODE": "HIC"},
"NO": {"ISO3166-1-UNLOC": "NO", "COUNTRY-NAME": "Norway", "COUNTRY": "Norway", "COUNTRY CODE": "NOR", "REGION": "Europe & Central Asia", "REGION CODE": "ECA", "INCOME": "High income", "INCOME CODE": "HIC"},
"OM": {"ISO3166-1-UNLOC": "OM", "COUNTRY-NAME": "Oman", "COUNTRY": "Oman", "COUNTRY CODE": "OMN", "REGION": "Middle East & North Africa", "REGION CODE": "MNA", "INCOME": "High income", "INCOME CODE": "HIC"},
"PK": {"ISO3166-1-UNLOC": "PK", "COUNTRY-NAME": "Pakistan", "COUNTRY": "Pakistan", "COUNTRY CODE": "PAK", "REGION": "South Asia", "REGION CODE": "SAS", "INCOME": "Lower middle income", "INCOME CODE": "LMC"},
"PW": {"ISO3166-1-UNLOC": "PW", "COUNTRY-NAME": "Palau", "COUNTRY": "Palau", "COUNTRY CODE": "PLW", "REGION": "East Asia & Pacific", "REGION CODE": "EAP", "INCOME": "Upper middle income", "INCOME CODE": "UMC"},
"PS": {"ISO3166-1-UNLOC": "PS", "COUNTRY-NAME": "Palestine, State of", "COUNTRY": "null", "COUNTRY CODE": "null", "REGION": "null", "REGION CODE": "null", "INCOME": "null", "INCOME CODE": "null"},
"PA": {"ISO3166-1-UNLOC": "PA", "COUNTRY-NAME": "Panama", "COUNTRY": "Panama", "COUNTRY CODE": "PAN", "REGION": "Latin America & Caribbean", "REGION CODE": "LAC", "INCOME": "Upper middle income", "INCOME CODE": "UMC"},
"PG": {"ISO3166-1-UNLOC": "PG", "COUNTRY-NAME": "Papua New Guinea", "COUNTRY": "Papua New Guinea", "COUNTRY CODE": "PNG", "REGION": "East Asia & Pacific", "REGION CODE": "EAP", "INCOME": "Lower middle income", "INCOME CODE": "LMC"},
"PY": {"ISO3166-1-UNLOC": "PY", "COUNTRY-NAME": "Paraguay", "COUNTRY": "Paraguay", "COUNTRY CODE": "PRY", "REGION": "Latin America & Caribbean", "REGION CODE": "LAC", "INCOME": "Upper middle income", "INCOME CODE": "UMC"},
"PE": {"ISO3166-1-UNLOC": "PE", "COUNTRY-NAME": "Peru", "COUNTRY": "Peru", "COUNTRY CODE": "PER", "REGION": "Latin America & Caribbean", "REGION CODE": "LAC", "INCOME": "Upper middle income", "INCOME CODE": "UMC"},
"PH": {"ISO3166-1-UNLOC": "PH", "COUNTRY-NAME": "Philippines", "COUNTRY": "Philippines", "COUNTRY CODE": "PHL", "REGION": "East Asia & Pacific", "REGION CODE": "EAP", "INCOME": "Lower middle income", "INCOME CODE": "LMC"},
"PN": {"ISO3166-1-UNLOC": "PN", "COUNTRY-NAME": "Pitcairn", "COUNTRY": "null", "COUNTRY CODE": "null", "REGION": "null", "REGION CODE": "null", "INCOME": "null", "INCOME CODE": "null"},
"PL": {"ISO3166-1-UNLOC": "PL", "COUNTRY-NAME": "Poland", "COUNTRY": "Poland", "COUNTRY CODE": "POL", "REGION": "Europe & Central Asia", "REGION CODE": "ECA", "INCOME": "High income", "INCOME CODE": "HIC"},
"PT": {"ISO3166-1-UNLOC": "PT", "COUNTRY-NAME": "Portugal", "COUNTRY": "Portugal", "COUNTRY CODE": "PRT", "REGION": "Europe & Central Asia", "REGION CODE": "ECA", "INCOME": "High income", "INCOME CODE": "HIC"},
"PR": {"ISO3166-1-UNLOC": "PR", "COUNTRY-NAME": "Puerto Rico", "COUNTRY": "Puerto Rico", "COUNTRY CODE": "PRI", "REGION": "Latin America & Caribbean", "REGION CODE": "LAC", "INCOME": "High income", "INCOME CODE": "HIC"},
"QA": {"ISO3166-1-UNLOC": "QA", "COUNTRY-NAME": "Qatar", "COUNTRY": "Qatar", "COUNTRY CODE": "QAT", "REGION": "Middle East & North Africa", "REGION CODE": "MNA", "INCOME": "High income", "INCOME CODE": "HIC"},
"RE": {"ISO3166-1-UNLOC": "RE", "COUNTRY-NAME": "Reunion", "COUNTRY": "null", "COUNTRY CODE": "null", "REGION": "null", "REGION CODE": "null", "INCOME": "null", "INCOME CODE": "null"},
"RO": {"ISO3166-1-UNLOC": "RO", "COUNTRY-NAME": "Romania", "COUNTRY": "Romania", "COUNTRY CODE": "ROM", "REGION": "Europe & Central Asia", "REGION CODE": "ECA", "INCOME": "Upper middle income", "INCOME CODE": "UMC"},
"RU": {"ISO3166-1-UNLOC": "RU", "COUNTRY-NAME": "Russian Federation", "COUNTRY": "Russian Federation", "COUNTRY CODE": "RUS", "REGION": "Europe & Central Asia", "REGION CODE": "ECA", "INCOME": "High income", "INCOME CODE": "HIC"},
"RW": {"ISO3166-1-UNLOC": "RW", "COUNTRY-NAME": "Rwanda", "COUNTRY": "Rwanda", "COUNTRY CODE": "RWA", "REGION": "Sub-Saharan Africa", "REGION CODE": "SSA", "INCOME": "Low income", "INCOME CODE": "LIC"},
"BL": {"ISO3166-1-UNLOC": "BL", "COUNTRY-NAME": "Saint Barthélemy", "COUNTRY": "null", "COUNTRY CODE": "null", "REGION": "null", "REGION CODE": "null", "INCOME": "null", "INCOME CODE": "null"},
"SH": {"ISO3166-1-UNLOC": "SH", "COUNTRY-NAME": "Saint Helena, Ascension and Tristan Da Cunha", "COUNTRY": "null", "COUNTRY CODE": "null", "REGION": "null", "REGION CODE": "null", "INCOME": "null", "INCOME CODE": "null"},
"KN": {"ISO3166-1-UNLOC": "KN", "COUNTRY-NAME": "Saint Kitts and Nevis", "COUNTRY": "null", "COUNTRY CODE": "null", "REGION": "null", "REGION CODE": "null", "INCOME": "null", "INCOME CODE": "null"},
"LC": {"ISO3166-1-UNLOC": "LC", "COUNTRY-NAME": "Saint Lucia", "COUNTRY": "null", "COUNTRY CODE": "null", "REGION": "null", "REGION CODE": "null", "INCOME": "null", "INCOME CODE": "null"},
"MF": {"ISO3166-1-UNLOC": "MF", "COUNTRY-NAME": "Saint Martin (French Part)", "COUNTRY": "null", "COUNTRY CODE": "null", "REGION": "null", "REGION CODE": "null", "INCOME": "null", "INCOME CODE": "null"},
"PM": {"ISO3166-1-UNLOC": "PM", "COUNTRY-NAME": "Saint Pierre and Miquelon", "COUNTRY": "null", "COUNTRY CODE": "null", "REGION": "null", "REGION CODE": "null", "INCOME": "null", "INCOME CODE": "null"},
"VC": {"ISO3166-1-UNLOC": "VC", "COUNTRY-NAME": "Saint Vincent and the Grenadines", "COUNTRY": "null", "COUNTRY CODE": "null", "REGION": "null", "REGION CODE": "null", "INCOME": "null", "INCOME CODE": "null"},
"WS": {"ISO3166-1-UNLOC": "WS", "COUNTRY-NAME": "Samoa", "COUNTRY": "Samoa", "COUNTRY CODE": "WSM", "REGION": "East Asia & Pacific", "REGION CODE": "EAP", "INCOME": "Lower middle income", "INCOME CODE": "LMC"},
"SM": {"ISO3166-1-UNLOC": "SM", "COUNTRY-NAME": "San Marino", "COUNTRY": "San Marino", "COUNTRY CODE": "SMR", "REGION": "Europe & Central Asia", "REGION CODE": "ECA", "INCOME": "High income", "INCOME CODE": "HIC"},
"ST": {"ISO3166-1-UNLOC": "ST", "COUNTRY-NAME": "Sao Tome and Principe", "COUNTRY": "São Tomé and Principe", "COUNTRY CODE": "STP", "REGION": "Sub-Saharan Africa", "REGION CODE": "SSA", "INCOME": "Lower middle income", "INCOME CODE": "LMC"},
"SA": {"ISO3166-1-UNLOC": "SA", "COUNTRY-NAME": "Saudi Arabia", "COUNTRY": "Saudi Arabia", "COUNTRY CODE": "SAU", "REGION": "Middle East & North Africa", "REGION CODE": "MNA", "INCOME": "High income", "INCOME CODE": "HIC"},
"SN": {"ISO3166-1-UNLOC": "SN", "COUNTRY-NAME": "Senegal", "COUNTRY": "Senegal", "COUNTRY CODE": "SEN", "REGION": "Sub-Saharan Africa", "REGION CODE": "SSA", "INCOME": "Lower middle income", "INCOME CODE": "LMC"},
"RS": {"ISO3166-1-UNLOC": "RS", "COUNTRY-NAME": "Serbia", "COUNTRY": "Serbia", "COUNTRY CODE": "SRB", "REGION": "Europe & Central Asia", "REGION CODE": "ECA", "INCOME": "Upper middle income", "INCOME CODE": "UMC"},
"SC": {"ISO3166-1-UNLOC": "SC", "COUNTRY-NAME": "Seychelles", "COUNTRY": "Seychelles", "COUNTRY CODE": "SYC", "REGION": "Sub-Saharan Africa", "REGION CODE": "SSA", "INCOME": "High income", "INCOME CODE": "HIC"},
"SL": {"ISO3166-1-UNLOC": "SL", "COUNTRY-NAME": "Sierra Leone", "COUNTRY": "Sierra Leone", "COUNTRY CODE": "SLE", "REGION": "Sub-Saharan Africa", "REGION CODE": "SSA", "INCOME": "Low income", "INCOME CODE": "LIC"},
"SG": {"ISO3166-1-UNLOC": "SG", "COUNTRY-NAME": "Singapore", "COUNTRY": "Singapore", "COUNTRY CODE": "SGP", "REGION": "East Asia & Pacific", "REGION CODE": "EAP", "INCOME": "High income", "INCOME CODE": "HIC"},
"SX": {"ISO3166-1-UNLOC": "SX", "COUNTRY-NAME": "Sint Maarten (Dutch Part)", "COUNTRY": "Sint Maarten (Dutch part)", "COUNTRY CODE": "SXM", "REGION": "Latin America & Caribbean", "REGION CODE": "LAC", "INCOME": "High income", "INCOME CODE": "HIC"},
"SK": {"ISO3166-1-UNLOC": "SK", "COUNTRY-NAME": "Slovakia", "COUNTRY": "Slovak Republic", "COUNTRY CODE": "SVK", "REGION": "Europe & Central Asia", "REGION CODE": "ECA", "INCOME": "High income", "INCOME CODE": "HIC"},
"SI": {"ISO3166-1-UNLOC": "SI", "COUNTRY-NAME": "Slovenia", "COUNTRY": "Slovenia", "COUNTRY CODE": "SVN", "REGION": "Europe & Central Asia", "REGION CODE": "ECA", "INCOME": "High income", "INCOME CODE": "HIC"},
"SB": {"ISO3166-1-UNLOC": "SB", "COUNTRY-NAME": "Solomon Islands", "COUNTRY": "Solomon Islands", "COUNTRY CODE": "SLB", "REGION": "East Asia & Pacific", "REGION CODE": "EAP", "INCOME": "Lower middle income", "INCOME CODE": "LMC"},
"SO": {"ISO3166-1-UNLOC": "SO", "COUNTRY-NAME": "Somalia", "COUNTRY": "Somalia", "COUNTRY CODE": "SOM", "REGION": "Sub-Saharan Africa", "REGION CODE": "SSA", "INCOME": "Low income", "INCOME CODE": "LIC"},
"ZA": {"ISO3166-1-UNLOC": "ZA", "COUNTRY-NAME": "South Africa", "COUNTRY": "South Africa", "COUNTRY CODE": "ZAF", "REGION": "Sub-Saharan Africa", "REGION CODE": "SSA", "INCOME": "Upper middle income", "INCOME CODE": "UMC"},
"GS": {"ISO3166-1-UNLOC": "GS", "COUNTRY-NAME": "South Georgia and the South Sandwich Islands", "COUNTRY": "null", "COUNTRY CODE": "null", "REGION": "null", "REGION CODE": "null", "INCOME": "null", "INCOME CODE": "null"},
"SS": {"ISO3166-1-UNLOC": "SS", "COUNTRY-NAME": "South Sudan", "COUNTRY": "South Sudan", "COUNTRY CODE": "SSD", "REGION": "Sub-Saharan Africa", "REGION CODE": "SSA", "INCOME": "Low income", "INCOME CODE": "LIC"},
"ES": {"ISO3166-1-UNLOC": "ES", "COUNTRY-NAME": "Spain", "COUNTRY": "Spain", "COUNTRY CODE": "ESP", "REGION": "Europe & Central Asia", "REGION CODE": "ECA", "INCOME": "High income", "INCOME CODE": "HIC"},
"LK": {"ISO3166-1-UNLOC": "LK", "COUNTRY-NAME": "Sri Lanka", "COUNTRY": "Sri Lanka", "COUNTRY CODE": "LKA", "REGION": "South Asia", "REGION CODE": "SAS", "INCOME": "Lower middle income", "INCOME CODE": "LMC"},
"U2": {"ISO3166-1-UNLOC": "U2", "COUNTRY-NAME": "null", "COUNTRY": "St. Kitts and Nevis", "COUNTRY CODE": "KNA", "REGION": "Latin America & Caribbean", "REGION CODE": "LAC", "INCOME": "High income", "INCOME CODE": "HIC"},
"U4": {"ISO3166-1-UNLOC": "U4", "COUNTRY-NAME": "null", "COUNTRY": "St. Lucia", "COUNTRY CODE": "LCA", "REGION": "Latin America & Caribbean", "REGION CODE": "LAC", "INCOME": "Upper middle income", "INCOME CODE": "UMC"},
"U5": {"ISO3166-1-UNLOC": "U5", "COUNTRY-NAME": "null", "COUNTRY": "St. Martin (French part)", "COUNTRY CODE": "MAF", "REGION": "Latin America & Caribbean", "REGION CODE": "LAC", "INCOME": "High income", "INCOME CODE": "HIC"},
"U6": {"ISO3166-1-UNLOC": "U6", "COUNTRY-NAME": "null", "COUNTRY": "St. Vincent and the Grenadines", "COUNTRY CODE": "VCT", "REGION": "Latin America & Caribbean", "REGION CODE": "LAC", "INCOME": "Upper middle income", "INCOME CODE": "UMC"},
"SD": {"ISO3166-1-UNLOC": "SD", "COUNTRY-NAME": "Sudan", "COUNTRY": "Sudan", "COUNTRY CODE": "SDN", "REGION": "Sub-Saharan Africa", "REGION CODE": "SSA", "INCOME": "Lower middle income", "INCOME CODE": "LMC"},
"SR": {"ISO3166-1-UNLOC": "SR", "COUNTRY-NAME": "Suriname", "COUNTRY": "Suriname", "COUNTRY CODE": "SUR", "REGION": "Latin America & Caribbean", "REGION CODE": "LAC", "INCOME": "Upper middle income", "INCOME CODE": "UMC"},
"SJ": {"ISO3166-1-UNLOC": "SJ", "COUNTRY-NAME": "Svalbard and Jan Mayen", "COUNTRY": "null", "COUNTRY CODE": "null", "REGION": "null", "REGION CODE": "null", "INCOME": "null", "INCOME CODE": "null"},
"SZ": {"ISO3166-1-UNLOC": "SZ", "COUNTRY-NAME": "Swaziland", "COUNTRY": "Swaziland", "COUNTRY CODE": "SWZ", "REGION": "Sub-Saharan Africa", "REGION CODE": "SSA", "INCOME": "Lower middle income", "INCOME CODE": "LMC"},
"SE": {"ISO3166-1-UNLOC": "SE", "COUNTRY-NAME": "Sweden", "COUNTRY": "Sweden", "COUNTRY CODE": "SWE", "REGION": "Europe & Central Asia", "REGION CODE": "ECA", "INCOME": "High income", "INCOME CODE": "HIC"},
"CH": {"ISO3166-1-UNLOC": "CH", "COUNTRY-NAME": "Switzerland", "COUNTRY": "Switzerland", "COUNTRY CODE": "CHE", "REGION": "Europe & Central Asia", "REGION CODE": "ECA", "INCOME": "High income", "INCOME CODE": "HIC"},
"SY": {"ISO3166-1-UNLOC": "SY", "COUNTRY-NAME": "Syrian Arab Republic", "COUNTRY": "Syrian Arab Republic", "COUNTRY CODE": "SYR", "REGION": "Middle East & North Africa", "REGION CODE": "MNA", "INCOME": "Lower middle income", "INCOME CODE": "LMC"},
"TW": {"ISO3166-1-UNLOC": "TW", "COUNTRY-NAME": "Taiwan", "COUNTRY": "Taiwan", "COUNTRY CODE": "null", "REGION": "East Asia & Pacific", "REGION CODE": "EAP", "INCOME": "null", "INCOME CODE": "null"},
"TJ": {"ISO3166-1-UNLOC": "TJ", "COUNTRY-NAME": "Tajikistan", "COUNTRY": "Tajikistan", "COUNTRY CODE": "TJK", "REGION": "Europe & Central Asia", "REGION CODE": "ECA", "INCOME": "Lower middle income", "INCOME CODE": "LMC"},
"TZ": {"ISO3166-1-UNLOC": "TZ", "COUNTRY-NAME": "Tanzania, United Republic of", "COUNTRY": "Tanzania", "COUNTRY CODE": "TZA", "REGION": "Sub-Saharan Africa", "REGION CODE": "SSA", "INCOME": "Low income", "INCOME CODE": "LIC"},
"TH": {"ISO3166-1-UNLOC": "TH", "COUNTRY-NAME": "Thailand", "COUNTRY": "Thailand", "COUNTRY CODE": "THA", "REGION": "East Asia & Pacific", "REGION CODE": "EAP", "INCOME": "Upper middle income", "INCOME CODE": "UMC"},
"TL": {"ISO3166-1-UNLOC": "TL", "COUNTRY-NAME": "Timor-Leste", "COUNTRY": "Timor-Leste", "COUNTRY CODE": "TMP", "REGION": "East Asia & Pacific", "REGION CODE": "EAP", "INCOME": "Lower middle income", "INCOME CODE": "LMC"},
"TG": {"ISO3166-1-UNLOC": "TG", "COUNTRY-NAME": "Togo", "COUNTRY": "Togo", "COUNTRY CODE": "TGO", "REGION": "Sub-Saharan Africa", "REGION CODE": "SSA", "INCOME": "Low income", "INCOME CODE": "LIC"},
"TK": {"ISO3166-1-UNLOC": "TK", "COUNTRY-NAME": "Tokelau", "COUNTRY": "null", "COUNTRY CODE": "null", "REGION": "null", "REGION CODE": "null", "INCOME": "null", "INCOME CODE": "null"},
"TO": {"ISO3166-1-UNLOC": "TO", "COUNTRY-NAME": "Tonga", "COUNTRY": "Tonga", "COUNTRY CODE": "TON", "REGION": "East Asia & Pacific", "REGION CODE": "EAP", "INCOME": "Upper middle income", "INCOME CODE": "UMC"},
"TT": {"ISO3166-1-UNLOC": "TT", "COUNTRY-NAME": "Trinidad and Tobago", "COUNTRY": "Trinidad and Tobago", "COUNTRY CODE": "TTO", "REGION": "Latin America & Caribbean", "REGION CODE": "LAC", "INCOME": "High income", "INCOME CODE": "HIC"},
"TN": {"ISO3166-1-UNLOC": "TN", "COUNTRY-NAME": "Tunisia", "COUNTRY": "Tunisia", "COUNTRY CODE": "TUN", "REGION": "Middle East & North Africa", "REGION CODE": "MNA", "INCOME": "Upper middle income", "INCOME CODE": "UMC"},
"TR": {"ISO3166-1-UNLOC": "TR", "COUNTRY-NAME": "Turkey", "COUNTRY": "Turkey", "COUNTRY CODE": "TUR", "REGION": "Europe & Central Asia", "REGION CODE": "ECA", "INCOME": "Upper middle income", "INCOME CODE": "UMC"},
"TM": {"ISO3166-1-UNLOC": "TM", "COUNTRY-NAME": "Turkmenistan", "COUNTRY": "Turkmenistan", "COUNTRY CODE": "TKM", "REGION": "Europe & Central Asia", "REGION CODE": "ECA", "INCOME": "Upper middle income", "INCOME CODE": "UMC"},
"TC": {"ISO3166-1-UNLOC": "TC", "COUNTRY-NAME": "Turks and Caicos Islands", "COUNTRY": "Turks and Caicos Islands", "COUNTRY CODE": "TCA", "REGION": "Latin America & Caribbean", "REGION CODE": "LAC", "INCOME": "High income", "INCOME CODE": "HIC"},
"TV": {"ISO3166-1-UNLOC": "TV", "COUNTRY-NAME": "Tuvalu", "COUNTRY": "Tuvalu", "COUNTRY CODE": "TUV", "REGION": "East Asia & Pacific", "REGION CODE": "EAP", "INCOME": "Upper middle income", "INCOME CODE": "UMC"},
"UG": {"ISO3166-1-UNLOC": "UG", "COUNTRY-NAME": "Uganda", "COUNTRY": "Uganda", "COUNTRY CODE": "UGA", "REGION": "Sub-Saharan Africa", "REGION CODE": "SSA", "INCOME": "Low income", "INCOME CODE": "LIC"},
"UA": {"ISO3166-1-UNLOC": "UA", "COUNTRY-NAME": "Ukraine", "COUNTRY": "Ukraine", "COUNTRY CODE": "UKR", "REGION": "Europe & Central Asia", "REGION CODE": "ECA", "INCOME": "Lower middle income", "INCOME CODE": "LMC"},
"AE": {"ISO3166-1-UNLOC": "AE", "COUNTRY-NAME": "United Arab Emirates", "COUNTRY": "United Arab Emirates", "COUNTRY CODE": "ARE", "REGION": "Middle East & North Africa", "REGION CODE": "MNA", "INCOME": "High income", "INCOME CODE": "HIC"},
"GB": {"ISO3166-1-UNLOC": "GB", "COUNTRY-NAME": "United Kingdom", "COUNTRY": "United Kingdom", "COUNTRY CODE": "GBR", "REGION": "Europe & Central Asia", "REGION CODE": "ECA", "INCOME": "High income", "INCOME CODE": "HIC"},
"US": {"ISO3166-1-UNLOC": "US", "COUNTRY-NAME": "United States [A to E] [F to J] [K to O] [P to T] [U to Z]", "COUNTRY": "United States", "COUNTRY CODE": "USA", "REGION": "North America", "REGION CODE": "NAM", "INCOME": "High income", "INCOME CODE": "HIC"},
"UM": {"ISO3166-1-UNLOC": "UM", "COUNTRY-NAME": "United States Minor Outlying Islands", "COUNTRY": "null", "COUNTRY CODE": "null", "REGION": "null", "REGION CODE": "null", "INCOME": "null", "INCOME CODE": "null"},
"UY": {"ISO3166-1-UNLOC": "UY", "COUNTRY-NAME": "Uruguay", "COUNTRY": "Uruguay", "COUNTRY CODE": "URY", "REGION": "Latin America & Caribbean", "REGION CODE": "LAC", "INCOME": "High income", "INCOME CODE": "HIC"},
"UZ": {"ISO3166-1-UNLOC": "UZ", "COUNTRY-NAME": "Uzbekistan", "COUNTRY": "Uzbekistan", "COUNTRY CODE": "UZB", "REGION": "Europe & Central Asia", "REGION CODE": "ECA", "INCOME": "Lower middle income", "INCOME CODE": "LMC"},
"VU": {"ISO3166-1-UNLOC": "VU", "COUNTRY-NAME": "Vanuatu", "COUNTRY": "Vanuatu", "COUNTRY CODE": "VUT", "REGION": "East Asia & Pacific", "REGION CODE": "EAP", "INCOME": "Lower middle income", "INCOME CODE": "LMC"},
"VE": {"ISO3166-1-UNLOC": "VE", "COUNTRY-NAME": "Venezuela", "COUNTRY": "Venezuela, RB", "COUNTRY CODE": "VEN", "REGION": "Latin America & Caribbean", "REGION CODE": "LAC", "INCOME": "High income", "INCOME CODE": "HIC"},
"VN": {"ISO3166-1-UNLOC": "VN", "COUNTRY-NAME": "Viet Nam", "COUNTRY": "Vietnam", "COUNTRY CODE": "VNM", "REGION": "East Asia & Pacific", "REGION CODE": "EAP", "INCOME": "Lower middle income", "INCOME CODE": "LMC"},
"VG": {"ISO3166-1-UNLOC": "VG", "COUNTRY-NAME": "Virgin Islands, British", "COUNTRY": "Virgin Islands (U.S.)", "COUNTRY CODE": "VIR", "REGION": "Latin America & Caribbean", "REGION CODE": "LAC", "INCOME": "High income", "INCOME CODE": "HIC"},
"U7": {"ISO3166-1-UNLOC": "U7", "COUNTRY-NAME": "null", "COUNTRY": "West Bank and Gaza", "COUNTRY CODE": "WBG", "REGION": "Middle East & North Africa", "REGION CODE": "MNA", "INCOME": "Lower middle income", "INCOME CODE": "LMC"},
"VI": {"ISO3166-1-UNLOC": "VI", "COUNTRY-NAME": "Virgin Islands, U.S.", "COUNTRY": "null", "COUNTRY CODE": "null", "REGION": "null", "REGION CODE": "null", "INCOME": "null", "INCOME CODE": "null"},
"WF": {"ISO3166-1-UNLOC": "WF", "COUNTRY-NAME": "Wallis and Futuna", "COUNTRY": "null", "COUNTRY CODE": "null", "REGION": "null", "REGION CODE": "null", "INCOME": "null", "INCOME CODE": "null"},
"EH": {"ISO3166-1-UNLOC": "EH", "COUNTRY-NAME": "Western Sahara", "COUNTRY": "null", "COUNTRY CODE": "null", "REGION": "null", "REGION CODE": "null", "INCOME": "null", "INCOME CODE": "null"},
"YE": {"ISO3166-1-UNLOC": "YE", "COUNTRY-NAME": "Yemen", "COUNTRY": "Yemen, Rep.", "COUNTRY CODE": "YEM", "REGION": "Middle East & North Africa", "REGION CODE": "MNA", "INCOME": "Lower middle income", "INCOME CODE": "LMC"},
"ZM": {"ISO3166-1-UNLOC": "ZM", "COUNTRY-NAME": "Zambia", "COUNTRY": "Zambia", "COUNTRY CODE": "ZMB", "REGION": "Sub-Saharan Africa", "REGION CODE": "SSA", "INCOME": "Lower middle income", "INCOME CODE": "LMC"},
"ZW": {"ISO3166-1-UNLOC": "ZW", "COUNTRY-NAME": "Zimbabwe", "COUNTRY": "Zimbabwe", "COUNTRY CODE": "ZWE", "REGION": "Sub-Saharan Africa", "REGION CODE": "SSA", "INCOME": "Low income", "INCOME CODE": "LIC"}
}
JSON;

	// Decode json into PHP
	$regions_php = new stdClass();
	$regions_php = json_decode($regions_json);
	// print_r($regions_php->{'AF'}->{'REGION'});

	if (property_exists($regions_php, $un_loc_code)) {
		$region['org_hq_country_region'] = $regions_php->{$un_loc_code}->{'REGION'};
		$region['org_hq_country_region_code'] = $regions_php->{$un_loc_code}->{'REGION CODE'};
		$region['org_hq_country_income'] = $regions_php->{$un_loc_code}->{'INCOME'};
		$region['org_hq_country_income_code'] = $regions_php->{$un_loc_code}->{'INCOME CODE'};
		$region['org_hq_country_wb_code'] = $regions_php->{$un_loc_code}->{'COUNTRY CODE'};
		$region['org_hq_country_name'] = $regions_php->{$un_loc_code}->{'COUNTRY'};
	} else {
		$region['org_hq_country_region'] = null;
		$region['org_hq_country_region_code'] = null;
		$region['org_hq_country_income'] = null;
		$region['org_hq_country_income_code'] = null;
		$region['org_hq_country_wb_code'] = null;
		$region['org_hq_country_name'] = null;
	}
	
	return $region;
}

function sizeStringPhp ($str, $len) {
	if (strlen($str) < $len) {
		// return str_pad($str, $len, "&nbsp;");
		return str_replace('~', '&nbsp;', str_pad($str, $len, '~'));
	} 
	if (strlen($str) > $len) {
		return substr($str,0,$len).'...';
	}
	return $str;
}

function fixFlatfileValues(&$row, $key) {
	// Fix various flat file values
	if ( !array_key_exists('date_created', $row) ) {
		$row['date_created'] = $row['createdAt'];
	}
	if ( !array_key_exists('date_modified', $row) ) {
		$row['date_modified'] = $row['updatedAt'];
	}

	if ( !array_key_exists('eligibility', $row) ) {
		$row['eligibility'] = "YY";
	}


	foreach (array('date_created', 'date_modified', 'createdAt', 'updatedAt') as $date_key) {
		$row[$date_key] = substr($row[$date_key], 0, 10);
	}

	$fields = array('industry_other', 'use_prod_srvc', 'use_prod_srvc_desc', 'use_org_opt', 'use_org_opt_desc', 'use_research', 'use_research', 'use_research_desc', 'use_other', 'use_other_desc', 'org_additional', 'org_additional', 'org_confidence', 'org_open_corporates_id', 'org_type_other', 'org_greatest_impact_detail','data_country_count');
	foreach ($fields as $field) {
		if ( !array_key_exists($field, $row) ) {
			$row[$field] = Null;
		}
	}

	if ( is_null($row['org_year_founded']) ) {
		$row['org_year_founded'] = 0;
	}

	if ( is_null($row['org_confidence']) ) {
		$row['org_confidence'] = 0;
	}
}

function addFeaturesFormatting(&$row, $key) {
	// Fix various flat file values
	if ( !array_key_exists('date_created', $row) ) {
		$row['date_created'] = $row['createdAt'];
	}

	if ( !array_key_exists('date_modified', $row) ) {
		$row['date_modified'] = $row['updatedAt'];
	}

	foreach (array('date_created', 'date_modified', 'createdAt', 'updatedAt') as $date_key) {
		$row[$date_key] = substr($row[$date_key], 0, 10);
	}

	$fields = array('industry_other', 'use_prod_srvc', 'use_prod_srvc_desc', 'use_org_opt', 'use_org_opt_desc', 'use_research', 'use_research', 'use_research_desc', 'use_other', 'use_other_desc', 'org_additional', 'org_additional', 'org_confidence', 'org_open_corporates_id', 'org_type_other', 'org_greatest_impact_detail','data_country_count');
	foreach ($fields as $field) {
		if ( !array_key_exists($field, $row) ) {
			$row[$field] = Null;
		}
	}

	// Remove fields
	$fields = array('data_use_unparsed', 'eligibility');
	foreach ($fields as $field) {
		if ( array_key_exists($field, $row) ) {
			unset($row[$field]);
		}
	}

	// fix booleen values
	$fields = array('no_org_url', 'use_advocacy', 'use_org_opt', 'use_other', 'use_prod_srvc', 'use_research');
	foreach ($fields as $field) {
		if ( array_key_exists($field, $row) ) {
			$row[$field] = ($row[$field]) ? 1 : 0;
		}
	}
}

/**
 * Pretty-print JSON string
 *
 * Use 'format' option to select output format - currently html and txt supported, txt is default
 * Use 'indent' option to override the indentation string set in the format - by default for the 'txt' format it's a tab
 *
 * @param string $json Original JSON string
 * @param array $options Encoding options
 * @return string
 */
function json_pretty($json, $options = array())
{
    $tokens = preg_split('|([\{\}\]\[,])|', $json, -1, PREG_SPLIT_DELIM_CAPTURE);
    $result = '';
    $indent = 0;

    $format = 'txt';

    //$ind = "\t";
    $ind = "    ";

    if (isset($options['format'])) {
        $format = $options['format'];
    }

    switch ($format) {
        case 'html':
            $lineBreak = '<br />';
            $ind = '&nbsp;&nbsp;&nbsp;&nbsp;';
            break;
        default:
        case 'txt':
            $lineBreak = "\n";
            //$ind = "\t";
            $ind = "    ";
            break;
    }

    // override the defined indent setting with the supplied option
    if (isset($options['indent'])) {
        $ind = $options['indent'];
    }

    $inLiteral = false;
    foreach ($tokens as $token) {
        if ($token == '') {
            continue;
        }

        $prefix = str_repeat($ind, $indent);
        if (!$inLiteral && ($token == '{' || $token == '[')) {
            $indent++;
            if (($result != '') && ($result[(strlen($result) - 1)] == $lineBreak)) {
                $result .= $prefix;
            }
            $result .= $token . $lineBreak;
        } elseif (!$inLiteral && ($token == '}' || $token == ']')) {
            $indent--;
            $prefix = str_repeat($ind, $indent);
            $result .= $lineBreak . $prefix . $token;
        } elseif (!$inLiteral && $token == ',') {
            $result .= $token . $lineBreak;
        } else {
            $result .= ( $inLiteral ? '' : $prefix ) . $token;

            // Count # of unescaped double-quotes in token, subtract # of
            // escaped double-quotes and if the result is odd then we are 
            // inside a string literal
            if ((substr_count($token, "\"") - substr_count($token, "\\\"")) % 2 != 0) {
                $inLiteral = !$inLiteral;
            }
        }
    }
    return $result;
}

?>
