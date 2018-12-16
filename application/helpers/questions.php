<?php

class Questions_Helper extends CI_Controller {

    public function write_question( $question ){
        $data = array(
            'ask_time'	=> time(),
            'ip_address'	=> $this->input->ip_address(),
            'question_id'	=> $question->id
        );
        $query = $this->db->insert_string('ask_questions', $data);
        $this->db->query($query);
        return $this->db->insert_id();
    }


    public function ask_question(){
        $question =  $this->db->select("*")->order_by('id', 'random')->get('questions')->row();
        $ask['ask_id'] = $this->write_question( $question );
        $ask['question'] = $question->question;
        return $ask;

    }


    public function answer_valid( $value )
    {
        $expiration = time()-7200;
        $this->db->query("DELETE FROM ask_questions WHERE ask_time < ".$expiration);

        $ask = $this->db->select("*")->from('ask_questions')->where('ip_address', $this->input->ip_address())->order_by('id', 'desc')->get()->row();
        $answer = $this->db->get_where('answers', array('question_id' => $ask->question_id, 'answer'=>$value))->row();

        if( isset($answer->id) ){
            return true;
        } else{
            return false;
        }
    }



}