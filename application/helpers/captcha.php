<?php

class Captcha_Helper extends CI_Controller {

    public function write_captcha( $cap ){
        $data = array(
            'captcha_time'	=> $cap['time'],
            'ip_address'	=> $this->input->ip_address(),
            'word'	=> $cap['word']
        );

        $query = $this->db->insert_string('captcha', $data);
        $this->db->query($query);
    }



    public function captcha_valid( $value )
    {
        $expiration = time()-7200;
        $this->db->query("DELETE FROM captcha WHERE captcha_time < ".$expiration);
        $sql = "SELECT COUNT(*) AS count FROM captcha WHERE word = ? AND ip_address = ? AND captcha_time > ?";
        $binds = array($value, $this->input->ip_address(), $expiration);
        $query = $this->db->query($sql, $binds);
        $row = $query->row();
        if ($row->count == 0)
        {
            $this->form_validation->set_message('captcha_valid', 'Некорректный код подтверждения!');
            return false;
        }
        else
            return true;
    }


}