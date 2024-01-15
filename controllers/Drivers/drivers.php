<?php
if (!set_include_path("{$_SERVER['DOCUMENT_ROOT']}"))
    error("500", "set_include_path()");

const BASE_URL = "https://www.formula1.com/en/drivers.html";

function f1_scrape_drivers($base_url): array
{

    // Init arrays of interest
    $team_list = [];
    $img_list = [];
    $number_list = [];
    $name_list = [];
    $lastname_list = [];
    $flag_list = [];

    $page = file_get_contents($base_url);
    $html = new DOMDocument();
    @$html->loadHtml($page);
    $xpath = new DOMXPath($html);

    $node_list = $xpath->query('//div[@class="listing-item--team f1--xxs f1-color--gray5"]');
    foreach ($node_list as $n) {
        $team = $n->nodeValue;
        /*
        Replace blank spaces in the read string, the limit of the replacements is just 2
            - Limit 2 imposed to obtain this situation (not affect the title)
                "News {title}" => ";News;{title}"
        */
        $team = preg_replace("/\s+/", ";", $team, 2);
        $team = explode(";", $team);

        $team_list[] = $team;
    }

    $node_list = $xpath->query('//span[@class="d-block f1--xxs f1-color--carbonBlack"]');
    foreach ($node_list as $n) {
        $name = $n->nodeValue;
        /*
        Replace blank spaces in the read string, the limit of the replacements is just 2
            - Limit 2 imposed to obtain this situation (not affect the title)
                "News {title}" => ";News;{title}"
        */
        //$name = preg_replace("/\s+/", ";", $name, 2);
        //$name = explode(";", $name);

        $name_list[] = $name;
    }


    $node_list = $xpath->query('//span[@class="d-block f1-bold--s f1-color--carbonBlack"]');
    foreach ($node_list as $n) {
        $lastname = $n->nodeValue;
        /*
        Replace blank spaces in the read string, the limit of the replacements is just 2
            - Limit 2 imposed to obtain this situation (not affect the title)
                "News {title}" => ";News;{title}"
        */
        //$name = preg_replace("/\s+/", ";", $name, 2);
        //$name = explode(";", $name);

        $lastname_list[] = $lastname;
    }


    $node_list = $xpath->query('//picture[@class="listing-item--photo"]//img');

    for ($i=0; $i<20; ++$i) {
        $link = $node_list->item($i)->getAttribute("data-src");

        // Explode needed because there are multiple images in data-srcset attribute
        // I want the last of them (better resolution)
        //$array = explode(",", $link);
        //$link = end($array);
        // Instructions needed because the original string is "{img_url} 2x"
        // and "2x" is not relevant, so I can split by blank spaces and obtain "{img_url}"
        //$link = explode(" ", $link)[1];

        // Append in array
        $img_list[] = $link;
    }
    //echo $img_list[1] . "<br><br>";

    $node_list = $xpath->query('//picture[@class="listing-item--number"]//img');

    for ($i=0; $i<20; ++$i) {
        $link = $node_list->item($i)->getAttribute("data-src");

        // Explode needed because there are multiple images in data-srcset attribute
        // I want the last of them (better resolution)
        //$array = explode(",", $link);
        //$link = end($array);
        // Instructions needed because the original string is "{img_url} 2x"
        // and "2x" is not relevant, so I can split by blank spaces and obtain "{img_url}"
        //$link = explode(" ", $link)[1];

        // Append in array
        $number_list[] = $link;
    }

    $node_list = $xpath->query('//picture[@class="coutnry-flag--photo"]//img');

    for ($i=0; $i<20; ++$i) {
        $link = $node_list->item($i)->getAttribute("data-src");

        // Explode needed because there are multiple images in data-srcset attribute
        // I want the last of them (better resolution)
        //$array = explode(",", $link);
        //$link = end($array);
        // Instructions needed because the original string is "{img_url} 2x"
        // and "2x" is not relevant, so I can split by blank spaces and obtain "{img_url}"
        //$link = explode(" ", $link)[1];

        // Append in array
        $flag_list[] = $link;
    }

    return [$name_list, $lastname_list, $flag_list, $team_list, $number_list, $img_list];
}