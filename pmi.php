<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <table>
            <?php
            require_once 'pmi_functions.php';

            $str = file_get_contents('http://cearensesnocanada.com/pmi.json');
            $list = json_decode($str, true); // decode the JSON into an associative array
            if (!$list or empty($list)) {
                $list = getMailList();
            }

            $i = 0;
            $print = '';
            
            foreach ($list as $item) {
                echo '<tr><td colspan="2"><b>' . $item['country'] . '</b></td></tr>';
                foreach ($item['chapters'] as $k => $c) {
                    $k = str_replace(normalizeChars($k) . '/', '', $k);
                    echo '<tr><td>' . $k . '</td><td>' . $c . '</td></tr>';
                    $i++;
                    $print .= $c . ', ';
                    if ($i == 35) {
                        $print .= '<hr />';
                        $i = 0;
                    }
                }
                echo '<tr><td colspan="2" bgcolor="#dcdcdc" height="7"></td></tr>';
                //$print .= '<hr />';
            }
            ?>

        </table>
        <hr />
        <?php
        /* echo $print;
        $listString = json_encode($list);
        echo '<hr />';
        echo $listString;
        */ ?>
    </body>
</html>
