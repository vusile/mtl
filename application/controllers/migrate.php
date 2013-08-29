<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of migrate
 *
 * @author Zoom
 */
class Migrate extends CI_Controller {
    //put your code here
    
    function __construct() {
        parent::__construct();
    }
    function index(){
        $this->load->library('migration');

        if ( ! $this->migration->current())
        {
                show_error($this->migration->error_string());
        }
    }
}

?>
