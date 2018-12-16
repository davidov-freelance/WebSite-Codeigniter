<?php

class MY_Route extends CI_Route {

        function MY_Route(){
           parent::CI_Route();
        }
           
        function _validate_request($segments)
        {
                if (file_exists(APPPATH.'controllers/'.$segments[0].EXT))
                {

                        return $segments;
                }

                if (is_dir(APPPATH.'controllers/'.$segments[0]))
                {               
                        $this->set_directory($segments[0]);
                        $segments = array_slice($segments, 1);
                        
                        if (isset($segments[0]) && is_dir(APPPATH.'controllers/'.$this->fetch_directory().'/'.$segments[0]))
                        {
                                $this->set_directory($this->fetch_directory().'/'.$segments[0]);
                                $segments = array_slice($segments, 1);
                        }

                        if (count($segments) > 0)
                        {
                                if ( ! file_exists(APPPATH.'controllers/'.$this->fetch_directory().$segments[0].EXT))
                                {
                                        show_404($this->fetch_directory().$segments[0]);
                                }
                        }
                        else
                        {
                                $this->set_class($this->default_controller);
                                $this->set_method('index');
                        
                                if ( ! file_exists(APPPATH.'controllers/'.$this->fetch_directory().$this->default_controller.EXT))
                                {
                                        $this->directory = '';
                                        return array();
                                }
                        
                        }

                        return $segments;
                }

                show_404($segments[0]);
        }
}