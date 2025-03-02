<?php

namespace Classes;

class File
{
    public function read($file)
    {
        $folderPath = "uploads/images/";
        $image_parts = explode(";base64,", $file);
        $filepart = explode("image/", $image_parts[0]);
        switch ($filepart[1]) {
            case 'png' || 'jpg' || 'jpeg':
                $image_base64 = base64_decode($image_parts[1]);
                $file = $folderPath . uniqid() . '.png';
               /*  var_dump($file);
                die(); */
                if (file_put_contents($file, $image_base64)) {
                    return $file;
                }else{
                    return $file = null;
                }
            break;
        }
    }
}