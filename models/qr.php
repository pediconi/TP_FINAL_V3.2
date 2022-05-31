<?php namespace models;

echo FRONT_ROOT.'phpqrcode/qrlib.php';
require_once FRONT_ROOT.'phpqrcode/qrlib.php';

class Qr {
  
    public function generateQr(){

        $dir = 'qr_temp/';

        if (!file_exists($dir) ){
            mkdir($dir);
        }

        $filename = $dir.'qr.png';

        $size = 10;
        $level = 'M';
        $frameSize = 3;
        $content = 'Codigo';

        QRcode::png($content, $filename, $level, $size, $frameSize);

        echo '<img src="'.$filename.'"/>';

    }



}