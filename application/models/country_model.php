<?php

class Country_model extends CI_Model{


    function getCountries(){
        return $this->db->get('countries')->result();
    }

    function getCityCountry( $city_id ){
        return $this->db->get_where('cities', ["id"=>(int)$city_id])->row()->country_id;
    }

    public function edit_city($id, $post ){

        $insertDataC = array(
            'country_id' => $post['c_id'],
            'name' => $post['name'],
            'name2' => $post['name2'],
            'name3' => $post['name3'],
            'eng_name' => $post['translate'],
        );
        if( $id ){
            $this->db->where("id", $id)->update("cities", $insertDataC );
        } else{

            $this->db->insert('cities', $insertDataC);
            $id = $this->db->insert_id();
        }
        return $id;



    }

    public function getCities($country_id){
        return $this->db->get_where("cities", array("country_id" => $country_id))->result();
    }

    public function getCity($city_id){
        return $this->db->get_where("cities", array("id" => $city_id))->row();
    }





    // синхронизация данных с crm
    public function updateData(){
        $cities = json_decode( file_get_contents( "http://api.alejka.ru/cities" ) );
        $countries = json_decode( file_get_contents( "http://api.alejka.ru/countries" ) );
        foreach( $cities as $city ){
            $query = $this->db->get_where('cities', array('name' => $city->name) )->result();
            if( !count( $query ) ){
                $insertData = array(
                    'id' => $city->id,
                    'name' => $city->name,
                    'country_id' => $city->countryId
                );
                $this->db->insert('cities', $insertData);
            }
        }



        foreach( $countries as $country ){
            $query = $this->db->get_where('countries', array('country_name' => $country->name) )->result();
            if( !count( $query ) ){
                $insertDataC = array(
                    'country_id' => $country->id,
                    'country_name' => $country->name
                );
                $this->db->insert('countries', $insertDataC);
            }
        }
        exit();

    }

}

