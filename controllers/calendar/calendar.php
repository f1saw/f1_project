<?php
/** https://getcomposer.org/doc/00-intro.md */
/** https://copyprogramming.com/howto/php-php-get-image-by-xpath?utm_content=cmp-true */
class Circuit {
    public int $round;
    public string $gp_name;
    public string $circuit_name;
    public string $circuit_place;
    public string $race_date;
    public string $img_url;

    public function __construct($round, $gp_name, $circuit_name, $circuit_place, $race_date, $img_url) {
        $this->round = $round;
        $this->gp_name = $gp_name;
        $this->circuit_name = $circuit_name;
        $this->circuit_place = $circuit_place;
        $this->race_date = $race_date;
        $this->img_url = $img_url;
    }

    public function get_gp_name() { return $this->gp_name; }
}

function f1_scrape_calendar($base_url): array {
    // Init array of interest
    $circuits = [];
    $img_links = json_decode(file_get_contents($_SERVER["DOCUMENT_ROOT"] . "\controllers\calendar\imgs.json"));

    $page = file_get_contents($base_url);
    $html = new DOMDocument();
    @$html->loadHtml($page);
    $xpath = new DOMXPath($html);

    $node_list = $xpath->query('//table');
    // node_list[0] => Teams
    // node_list[1] => Planned Grands Prix
    // node_list[2,3] => References

    $calendar_table = $node_list->item(1);
    $entries = $calendar_table->childNodes;
    foreach ($entries as $entry) {

        if ($entry->hasChildNodes()) {
            $rows = $entry->childNodes;

            // for from 1 to n-1 in order to remove first and last row which are useless
            $circuit_index = 0;
            for ($i = 1; $i < count($rows) - 1; $i++) {
                // remove blank entities
                if (!preg_match("/^\s*$/", $rows->item($i)->nodeValue)) {
                    // echo ">>" . $rows->item($i)->nodeValue . "<<<br>";
                    $row = $rows->item($i)->nodeValue;

                    // Get round number which is the first part of row
                    $round = preg_split("/\s/", $row)[1];

                    $other_info = explode("Prix", $row);
                    // after the row above "other_info" looks like this:
                    // array(2) { [0]=> string(18) " 1 Bahrain Grand " [1]=> string(50) " Bahrain International Circuit, Sakhir 2 March " }

                    // Remove the Round number
                    $gp_name = preg_replace("/\d/", "", $other_info[0]);
                    $gp_name .= " Prix";

                    $circuit_name = explode(",", $other_info[1])[0];

                    // Manage two "," in other_info[1] string
                    if (substr_count($other_info[1], ",") == 2) {
                        $place_date = substr($other_info[1], strlen($circuit_name) + 1, strlen($other_info[1]));
                        $place_date = preg_split("/,/", $place_date)[1];
                        $place_date = preg_split("/\s/", $place_date);
                    } else {
                        $place_date = explode(",", $other_info[1])[1];
                        $place_date = preg_split("/\s/", $place_date);
                    }

                    $circuit_place = implode(" ", array_splice($place_date, 1, count($place_date) - 5));

                    // Join Race Day and Month
                    $race_date = $place_date[count($place_date) - 3] . " " . $place_date[count($place_date) - 2];
                    //echo var_dump($circuit_place);

                    // echo $round . " | " . $gp_name . " | " . $circuit_name . " | " . $circuit_place . " | " . $race_date . "<br>";
                    $circuit = new Circuit($round, $gp_name, $circuit_name, $circuit_place, $race_date, $img_links[$circuit_index]);
                    $circuits[] = $circuit;
                    $circuit_index++;
                }
            }
        }
    }

    /*foreach ($circuits as $circuit) {
        echo $circuit->circuit_place . "<br>";
    } */

    return $circuits;
}