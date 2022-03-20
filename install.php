<?php

/**
 * @date 11.03.2022
 * @author Ugur Cengiz <ugurcengiz.mail@gmail.com>
 * @guest Volkan Coskun <webdvpv@gmail.com>
 * 
 * Hatira PHP terminal projesi. Tek komut calistirmada projeyi indirme ve aktif etme
 * Guzel sohbeti ve harika arkadasligindan oturu meslektasim Volkan Coskun'a sonsuz tesekkur
 * 
 * - Volkan Coskun
 *      "Herkesin hayatina kimse karisamaz!"
 * 
 * - Ugur Cengiz
 *      "Bir elin nesi var, iki el saksaksak!"
 */

$projectBinaryData = file_get_contents(
    "https://github.com/muffinweb/LangValuator/archive/refs/heads/master.zip",
    false,
    stream_context_create(array(
        "ssl" => array(
            "verify_peer" => false,
            "verify_peer_name" => false
        )
    ))
);

//Projeyi zip olarak indir
$projectZip = fopen("project.zip", "w+");
fwrite($projectZip, $projectBinaryData);
fclose($projectZip);
echo "1. Proje indirildi\n";

//Zipi extract et

if(file_exists('project.zip')){
    $zip = new ZipArchive;
    if($zip->open('project.zip') == TRUE){
        $zip->extractTo('./');
        $zip->close();
        echo "2. Proje unzip edildi\n";

        /**
         * 
         */
        // Get array of all source files
        $files = scandir("LangValuator-master");
        // Identify directories
        $source = "LangValuator-master/";
        $destination = "./";
        // Cycle through all source files
        foreach ($files as $file) {
            if (in_array($file, array(".",".."))) continue;
            // If we copied this successfully, mark it for deletion
            if (rename($source.$file, $destination.$file)) {
                $delete[] = $source.$file;
            }
        }
        echo "3. Proje Dosyalari Hazirlandi.\n";

        $output = null;
        $result_code = null;
        exec("php -S localhost:8888 && open http://localhost:8888", $output, $result_code);
        echo "4. Siteniz suan yayinda";
    }
}