<?php 

include ('./CompareText.php');

class GoogleSpreadSheetsDataController {

    private $spreadsheet_base_URL = 'https://spreadsheets.google.com/feeds/list';
    
    function getSpreadSheetData ($google_spread_sheets_id, $spreadsheet_sheet, $spreadsheet_query_params, $format) {
        // Open cURL session
        $ch = curl_init();
        $headers = array(
            'Accept: application/json',
            'Content-Type: application/json',
        );
        $resource_url = $this->spreadsheet_base_URL . '/' . $google_spread_sheets_id . '/' . $spreadsheet_sheet  . $spreadsheet_query_params . $format;

        // Parameters definition
        curl_setopt($ch, CURLOPT_URL, $resource_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_HEADER, 0);

        // Get and save response
        $r = curl_exec ($ch);
        // Close cURL session
        curl_close ($ch);

        // Return response
        return $r;

    }

    function convertSpreadSheetJSONToArray($rows){
        $total_rows = count($rows)-1;
        $entries = [];
        for($i=0; $i<=$total_rows;$i++) {
            $row = $rows[$i];
            $entry = [];
            foreach ($row as $cell) {
                $entry['title'] = $row->title->{'$t'};
                $entry['content'] = $row->content->{'$t'};
                $entry['category'] = $row->{'gsx$categoría'} -> {'$t'};
                $entry['identification'] = $row->{'gsx$cédulaon.i.t'} -> {'$t'};
                $entry['name'] = $row->{'gsx$nombredelcomercianteodelaempresa'} -> {'$t'};
                $entry['description'] = substr ($row->{'gsx$brevedescripcióndelservicioofrecidomáximo150caracteres'} -> {'$t'}, 0,95) . '[...]';
                $entry['address'] = $row->{'gsx$dirección'} -> {'$t'};
                $entry['city'] = $row->{'gsx$municipio'} -> {'$t'};
                $entry['contactphone'] = $row->{'gsx$teléfonodecontacto'} -> {'$t'};
                $entry['whatsapp'] = str_replace (' ', '', $row->{'gsx$númerodewhatsapp'} -> {'$t'});
                $entry['email'] = $row->{'gsx$correoelectrónico'} -> {'$t'};
                $entry['facebook'] = $row->{'gsx$fanpagedefacebook'} -> {'$t'};
                $entry['instagram'] = $row->{'gsx$instagram'} -> {'$t'};
                $entry['website'] = $row->{'gsx$páginaweb'} -> {'$t'};

            }
            $entries[] = $entry;
        }
        return $entries;
    }

    function convertSpreadSheetCategoryJSONToArray($rows){
        $total_rows = count($rows)-1;
        $entries = [];
        for($i=0; $i<=$total_rows;$i++) {
            $row = $rows[$i];
            $entry = [];
            foreach ($row as $cell) {
                $entry['category'] = $row->{'gsx$categoría'} -> {'$t'};
                $entry['icon'] = $row->{'gsx$icono'} -> {'$t'};
                $entry['color'] = $row->{'gsx$color'} -> {'$t'};
            }
            $entries[] = $entry;
        }
        return $entries;
    }

    function compareCharsTextually($ch1, $ch2){
        if(CompareText::icpm($ch1, $ch2) === 0){
            return true;
        } else {
            return false;
        }
    }

    function searchSubStringTextually($string, $substring){
        foreach (array_keys($substring) as $position1=>$character1) {
            foreach (array_keys($string) as $position2=>$character2) {
                if (CompareText::icmp($character1, $character2) === 0) {
                    // Verify accents
                    $new_substring = substr($substring, $position1+1);
                    searchSubStringTextually($new_substring, $substring);
                    return true;
                } else {
                    return false;
                }
            }
        }
    }
    function filterArray($array, $value) {
        $array_filtered = [];
        foreach ($array as $item) {
            $is=false;
            foreach ($item as $val){
                // Compare text withou changes
                $pos = strpos($val, htmlspecialchars_decode($value));
                if ($pos !== false) {
                    $array_filtered[] = $item;
                    break;
                }
            }
        }
        return $array_filtered;
    }

    function getValuesFromArrayByKey($array, $key, $value) {
        $array_by_key = [];
        foreach ($array as $item) {
            if($value == htmlspecialchars($item[$key])) {
                $array_by_key[] = $item;
            }   
        }
        return $array_by_key;
    }

    function mergeArraysByKey($array1, $array2, $key) {
        $array_merged_by_key = [];
        foreach ($array1 as $item1) {
            foreach ($array2 as $item2) {
                if($item1[$key] == $item2[$key]) {
                    $array_merged_by_key[] = array_merge($item1, $item2);
                }
            }
        }
        return $array_merged_by_key;
    }

    function getDistincValuesFromArray($array, $distinc_key) {
        $distinc_array = [];
        $temp = [];
        foreach ($array as $item) {
            $temp[] = $item[$distinc_key];
        }
        $distinc_array = array_unique($temp);
        return $distinc_array;
    }

}

?>