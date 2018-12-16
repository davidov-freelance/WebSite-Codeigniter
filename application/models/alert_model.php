<?php

class Alert_model extends CI_Model {


    /*
     * Определние сообщений
    */
    public static function alertMsg( $msg, $type ){
        if( self::findMsg( $type ) ){
            $CI =& get_instance();
            $CI->load->view("site/alert", ['msg'=>$msg, 'type'=>$type] );
        }
    }

    public static function findMsg($type)
    {
        if (isset($_GET['msg']) AND $_GET['msg'] == $type) return true;
        else return false;
    }

}
