<?php
//echo '<pre>';
if (isset($_FILES["fileToUpload"]) && !empty($_FILES["fileToUpload"])) {
    //echo 'entrou no if';
    $target_dir = "";
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $file = $_FILES["fileToUpload"]["name"];
    // Check if image file is a actual image or fake image
    if (isset($_POST["submit"])) {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            //echo "The file " . basename($_FILES["fileToUpload"]["name"]) . " has been uploaded.";
            convertXML($file);
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
} else {
    //echo '</pre>';
    ?>
    <!DOCTYPE html>
    <html>
        <body>

            <form action="index.php" method="post" enctype="multipart/form-data">
                Select a csv to upload:
                <input type="file" name="fileToUpload" id="fileToUpload">
                <input type="submit" value="Upload Image" name="submit">
            </form>

        </body>
    </html>

    <?php
}

function convertXML($fileName) {
    //echo '<br>entrou na funcão';
    $row = 1;
    $result = array();
    $titles = array();
    if (($handle = fopen($fileName, "r")) !== FALSE) {
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            $num = count($data);
            //echo "<p> $num fields in line $row: <br /></p>\n";
            if ($row == 1) {
                for ($b = 0; $b < $num; $b++) {
                    $titles[$b] = $data[$b];
                }
            }
            if ($row > 1) {
                $temp = array();
                for ($c = 0; $c < $num; $c++) {
                    $temp[$titles[$c]] = $data[$c];
                }
                $result[$row - 2] = $temp;
            }
            $row++;
        }
        fclose($handle);
        generateXML($result);
    } else {
        echo '<br> error to open the file';
    }
}

function generateXML($list) {
    $xml = new SimpleXMLElement('<xml/>');
    $entries = $xml->addChild('entries');
    $entries->addAttribute('ext','Password Exporter');
    $entries->addAttribute('extxmlversion','1.1');
    $entries->addAttribute('type','saved');
    $entries->addAttribute('encrypt','false');
    //var_dump($list);

    $total = count($list);
    for ($i = 0; $i <= $total; ++$i) {
        $item = $entries->addChild('entry');
        $item->addAttribute('host', $list[$i]['name']);
        $item->addAttribute('user', $list[$i]['username']);
        $item->addAttribute('password', $list[$i]['password']);
        $item->addAttribute('formSubmitURL', $list[$i]['url']);
        $item->addAttribute('httpRealm', "");
        $item->addAttribute('userFieldName', "");
        $item->addAttribute('passFieldName', "");
    }
    
    //var_dump($xml);

    //die('end csv');
    Header('Content-type: text/xml');
    header('Pragma: public');
    header('Cache-control: private');
    header('Expires: -1');
    print($xml->asXML());
    $xml->asXml('new.xml');
}
