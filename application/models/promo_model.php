<?php

class Promo_Model extends CI_Model{

    public $download_dir = "app/download/";
    public $data_dir = 'app/promo/landings/';

    public function archive_landing( $data ){
        $zip = new ZipArchive;
        $res = $zip->open($this->download_dir.$data['file_name'].'.zip', ZipArchive::CREATE);
        if ($res === TRUE) {
            $landing_dir = $this->data_dir.$data['alias']."/data/";

            $index = file_get_contents($landing_dir."index.txt");
            $thx = file_get_contents($landing_dir."thx.txt");
            $policy = file_get_contents($landing_dir."policy.html");
            $overads = file_get_contents($landing_dir."libs/overads.txt");


            $search = ['{API_KEY}', '{FLOW_KEY}', '{GOAL_ID}', '{TERM_GROUP}'];
            $replace = [$data['api_key'], $data['flow_key'], $data['goal_id'], $data['term_group']];


            $zip->addFromString("index.php", str_replace($search, $replace, $index ));
            $zip->addFromString("thx.php", str_replace($search, $replace, $thx ));
            $zip->addFromString("/libs/overads.php", str_replace($search, $replace, $overads ));
            $zip->addFromString("policy.html", $policy);


            $directory = realpath('app/promo/landings/'.$data['alias'].'/data/files/');
            $options = array('add_path' => 'files/', 'remove_path' => $directory);
            $zip->addPattern('/.*$/', $directory, $options);


            $zip->close();
        } else{
            exit();
        }
    }

}