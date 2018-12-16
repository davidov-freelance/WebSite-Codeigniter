<?php
/*
 * Контроллер принимающий ответ от CRM
 *
 */

class CRM extends CI_Controller
{

    private $api_key = "00a010aa0204e15df09d7dc208f150f4";

    function __construct()
    {
        parent::__construct();
        if($this->input->post('api_key') != $this->api_key ){
            echo json_encode(['status'=>'error', 'msg'=>'Access defined']);
            exit();
        }
        $this->load->model("api/API_model", "api_model");
        $this->load->model("user/advertiser/stat_model", "stat_model");
    }


    public function change_status(  ){
        $request =  $this->api_model->getRequest( $this->input->post('lead_id') );


        if($request->num_rows() == 0){
            echo json_encode(['status'=>'error', 'msg'=>'Lead not found']);
            exit();
        }

        $status = $this->stat_model->changeStatus($this->input->post('lead_id'), $this->input->post('status'), false);

        $request = $request->row_array();
        $flow = $this->db->select("flows.*, offers.name as offer_name")
            ->from("flows")
            ->join("offers", "offers.id=flows.offer_id", "left")
            ->where("flows.id", $request['flow_id'])->get()->row();


        // если одобрено и требуется отправка постбэка
        if( $this->input->post('status') == "1" AND isset( $flow->postback_success ) AND $flow->postback_success ){
            $request['status'] = 'approved';
            $this->api_model->sendPostback( $request, $flow );
        }

        // если отклонено и требуется отправка постбэка
        if( $this->input->post('status') == "-1" AND isset($flow->postback_fail) AND $flow->postback_fail ){
            $request['status'] = 'declined';
            $this->api_model->sendPostback( $request, $flow );
        }


        echo json_encode($status);
    }



}


