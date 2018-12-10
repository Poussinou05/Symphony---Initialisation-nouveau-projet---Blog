<?php
/**
 * Created by PhpStorm.
 * User: wilder
 * Date: 03/12/18
 * Time: 11:54
 */

namespace App\Service;

class Slugify
{
    public function generate(string $input): string
    {
        $cherche = ['-','_','à','ä','ç','é','è','ê','ë','î','ï','ù','û','ü','µ','ô','!','?',';','.','/',':',"'",'+','*','/','%','²','€','£','$','&'];
        $remplace=['','','a','a','c','e','e','e','e','i','i','u','u','u','u','o','','','','','','','','','','','','','e','','','-'];

        $input = trim(strip_tags($input));
        $input = str_replace($cherche,$remplace,$input);

        return $input;
    }
}