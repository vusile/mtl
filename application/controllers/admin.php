<?php
//if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Admin
 *
 * @author Zoom
 */
class Admin extends CI_Controller{
    
    public $path = 'http://localhost/platinum/assets/uploads/files/';

    function __construct() {
        
        parent::__construct();
        $this->load->library('grocery_crud');
        $this->load->library('ion_auth');
        $this->load->library('session');
        $this->load->helper('language');
        if (!$this->ion_auth->logged_in()){
                redirect('auth/login');
        }
       
    }

   function _user_output($output = null){
        $this->load->view('Admin/overview.php',$output);    
    }
            
   function miningCosulting(){
        
        //var_dump($this->session->all_userdata());
        $this->load->config('grocery_crud');
        
        $this->config->set_item('grocery_crud_file_upload_allow_file_types',
                                                            'gif|jpeg|jpg|png');
        $this->grocery_crud->set_table('pages');
        
        $this->grocery_crud->set_theme('datatables');
        
        $this->grocery_crud->columns('title', 'content');
        
        $this->grocery_crud->where('top_level','Mining Consulting Service');
                
        //$this->grocery_crud->where('pages.delete','active');
        
        $this->grocery_crud->display_as('date', 'Created Date')
                           ->display_as('date_modified', 'Modified Date')
                           ->display_as('top_level', 'Parent');
         
        $this->grocery_crud->set_subject(' Page To Mining and consulting services');
        
        $this->grocery_crud->add_fields('title','content');
        
        //$this->grocery_crud->order_by('name','ASC');
        
        $this->grocery_crud->required_fields('title','content');
        
        $this->grocery_crud->edit_fields('title','content', 'top_level');
        
        $this->grocery_crud->callback_after_insert(array($this,'add_url'));
                
        $this->grocery_crud->callback_after_update(array($this,'add_url_update'));
                
        $this->grocery_crud->callback_before_delete(array($this,'log_user_before_page_delete'));
 
        //$this->grocery_crud->callback_delete(array($this,'remove_menu_and_section'));
        
        $this->grocery_crud->add_action('Sub Pages', '', '','ui-icon-plus',array($this,'view_sub_pages')); 
        
        $this->grocery_crud->add_action('Gallery', '', '','ui-icon-plus',array($this,'view_gallery')); 
        
                
        $output = $this->grocery_crud->render();
        
        $this->_admin_output($output); 
    }
    
    function log_user_after_delete($primary_key)
    {
        //$this->db->where('id',$primary_key);
        //$page = $this->db->get('pages')->row();
        $user_logs_insert = array(
            "id" => $this->session->userdata('user_id'),
            "date" => date('Y-m-d H:i:s'),
            "actiond" => 'Deleted {'.$post_array['title'].'} Page '
        );

        $this->db->insert('user_logs',$user_logs_insert);

        return true;
    }
    function log_user_before_page_delete($primary_key)
    {
        $this->db->select('title');
        $this->db->where('id',$primary_key);
        $page = $this->db->get('pages')->row();
        $user_logs_insert = array(
            "id" => $this->session->userdata('user_id'),
            "date" => date('Y-m-d H:i:s'),
            "action" => 'Deleted {'.$page->title.'} Page '
        );

        $this->db->insert('user_logs',$user_logs_insert);

        return true;
    }
 
    function add_url($post_array, $primary_key){
        
        $url =url_title($post_array['title']);
        $data = array (
            'url' =>$url,
            'date'=>date('Y-m-d H:i:s'),
            'top_level'=> 'Mining Consulting Service'
        );
        $this->db->where('id', $primary_key);
        $this->db->update('pages', $data);
        
        //user logs 
        
        $user_logs_insert = array(
            "id" => $this->session->userdata('user_id'),
            "date" => date('Y-m-d H:i:s'),
            "action" => 'Added {'.$post_array['title'].'} Page '
        );

        $this->db->insert('user_logs',$user_logs_insert);
        
        return TRUE;
    }
    
    function add_url_update($post_array, $primary_key){
        
        $url =url_title($post_array['title']);
        $data = array (
            'url' =>$url,
            'date'=>date('Y-m-d H:i:s')
        );
        $this->db->where('id', $primary_key);
        $this->db->update('pages', $data);
        
        //user logs 
        
        $user_logs_insert = array(
            "id" => $this->session->userdata('user_id'),
            "date" => date('Y-m-d H:i:s'),
            "action" => 'Edited {'.$post_array['title'].'} Page '
        );

        $this->db->insert('user_logs',$user_logs_insert);
        
        return TRUE;
    }
    
    function view_sub_pages($primary_key , $row){
        return site_url('admin/miningCosultingSubPages/'.$row->url);
    }
    
    function miningCosultingSubPages($parent=NULL){
        
        //var_dump($this->session->all_userdata());
        $this->load->config('grocery_crud');
        
        $this->config->set_item('grocery_crud_file_upload_allow_file_types',
                                                            'gif|jpeg|jpg|png');
        $this->grocery_crud->set_table('pages');
        
        $this->grocery_crud->set_theme('datatables');
        
        $this->grocery_crud->columns('title', 'content');
        
        $this->grocery_crud->where('type',str_replace('-', ' ', $parent));
                
        //$this->grocery_crud->where('pages.delete','active');
        
        $this->grocery_crud->display_as('date', 'Created Date')
                           ->display_as('date_modified', 'Modified Date')
                           ->display_as('type', 'Parent');
         
        $this->grocery_crud->set_subject(' menu to '.str_replace('-', ' ', $parent).'');
        
        $this->grocery_crud->add_fields('title','content', 'type');
        
        //$this->grocery_crud->order_by('name','ASC');
        
        $this->grocery_crud->required_fields('title','content');
        
        $this->grocery_crud->edit_fields('title','content', 'type');
        
        $this->grocery_crud->callback_after_insert(array($this,'add_url'));
                
        $this->grocery_crud->callback_after_update(array($this,'add_url_update'));
                
        $this->grocery_crud->callback_after_delete(array($this,'log_user_after_delete'));
 
        //$this->grocery_crud->callback_delete(array($this,'remove_menu_and_section'));
        
        $this->grocery_crud->add_action('Types', '', '','ui-icon-plus',array($this,'view_Types')); 
        
        $this->grocery_crud->add_action('Gallery', '', '','ui-icon-plus',array($this,'view_gallery')); 
        
                
        $output = $this->grocery_crud->render();
        
        $this->_admin_output($output); 
    }
    
    function view_Types($primary_key , $row){
        return site_url('admin/miningCosultingSubPagesTypes/'.$row->url);
    } 
    
    function miningCosultingSubPagesTypes($parent=NULL){
        
        //var_dump($this->session->all_userdata());
        $this->load->config('grocery_crud');
        
        $this->config->set_item('grocery_crud_file_upload_allow_file_types',
                                                            'gif|jpeg|jpg|png');
        $this->grocery_crud->set_table('pages');
        
        $this->grocery_crud->set_theme('datatables');
        
        $this->grocery_crud->columns('title', 'content');
        
        $this->grocery_crud->where('parent',str_replace('-', ' ', $parent));
                
        //$this->grocery_crud->where('pages.delete','active');
        
        $this->grocery_crud->display_as('date', 'Created Date')
                           ->display_as('date_modified', 'Modified Date')
                           ->display_as('type', 'Parent');
         
        $this->grocery_crud->set_subject('Types To '.str_replace('-', ' ', $parent).'');
        
        $this->grocery_crud->add_fields('title','content');
        
        //$this->grocery_crud->order_by('name','ASC');
        
        $this->grocery_crud->required_fields('title','content');
        
        $this->grocery_crud->edit_fields('title','content', 'parent');
        
        $this->grocery_crud->callback_after_insert(array($this,'add_url_sub_types'));
                
        $this->grocery_crud->callback_after_update(array($this,'add_url_sub_types_update'));
                
        $this->grocery_crud->callback_after_delete(array($this,'log_user_after_delete'));
 
        //$this->grocery_crud->callback_delete(array($this,'remove_menu_and_section'));
        
        $this->grocery_crud->add_action('Gallery', '', '','ui-icon-plus',array($this,'view_gallery')); 
        
                
        $output = $this->grocery_crud->render();
        
        $this->_admin_output($output); 
    }
    
    function add_url_sub_types($post_array, $primary_key){
        
        $url =url_title($post_array['title']);
        $data = array (
            'url' =>$url,
            'date'=>date('Y-m-d H:i:s'),
            'parent'=>  str_replace('-', ' ', $this->uri->segment(3))
        );
        $this->db->where('id', $primary_key);
        $this->db->update('pages', $data);
        
        //user logs 
        
        $user_logs_insert = array(
            "id" => $this->session->userdata('user_id'),
            "date" => date('Y-m-d H:i:s'),
            "action" => 'Added {'.$post_array['title'].'} Page '
        );

        $this->db->insert('user_logs',$user_logs_insert);
        
        return TRUE;
    }
    
    function add_url_sub_types_update($post_array, $primary_key){
        
        $url =url_title($post_array['title']);
        $data = array (
            'url' =>$url,
            'date'=>date('Y-m-d H:i:s')
        );
        $this->db->where('id', $primary_key);
        $this->db->update('pages', $data);
        
        //user logs 
        
        $user_logs_insert = array(
            "id" => $this->session->userdata('user_id'),
            "date" => date('Y-m-d H:i:s'),
            "action" => 'Edited {'.$post_array['title'].'} Page '
        );

        $this->db->insert('user_logs',$user_logs_insert);
        
        return TRUE;
    }
        
    function oilandgas(){
        
        //var_dump($this->session->all_userdata());
        $this->load->config('grocery_crud');
        
        $this->config->set_item('grocery_crud_file_upload_allow_file_types',
                                                            'gif|jpeg|jpg|png');
        $this->grocery_crud->set_table('pages');
        
        $this->grocery_crud->set_theme('datatables');
        
        $this->grocery_crud->columns('title', 'content');
        
        $this->grocery_crud->where('top_level','Oil & Gas Service');
                
        //$this->grocery_crud->where('pages.delete','active');
        
        $this->grocery_crud->display_as('date', 'Created Date')
                           ->display_as('date_modified', 'Modified Date')
                           ->display_as('top_level', 'Parent');
         
        $this->grocery_crud->set_subject('Page To Oil & Gas services');
        
        $this->grocery_crud->add_fields('title','content');
        
        //$this->grocery_crud->order_by('name','ASC');
        
        $this->grocery_crud->required_fields('title','content','top_level');
        
        $this->grocery_crud->edit_fields('title','content', 'top_level');
        
        $this->grocery_crud->callback_after_insert(array($this,'add_url_oil_and_gass'));
                
        $this->grocery_crud->callback_after_update(array($this,'add_url_oil_and_gass'));
                
        $this->grocery_crud->callback_before_delete(array($this,'log_user_before_page_delete'));
 
        //$this->grocery_crud->callback_delete(array($this,'remove_menu_and_section'));
        
        $this->grocery_crud->add_action('Sub Pages', '', '','ui-icon-plus',array($this,'view_oil_and_sub_pages')); 
        
        $this->grocery_crud->add_action('Gallery', '', '','ui-icon-plus',array($this,'view_gallery')); 
       
        $output = $this->grocery_crud->render();
        
        $this->_admin_output($output); 
    }
    
    function add_url_oil_and_gass($post_array, $primary_key){
        
        $url =url_title($post_array['title']);
        $data = array (
            'url' =>$url,
            'date'=>date('Y-m-d H:i:s'),
            'top_level'=> 'Oil & Gas Service'
        );
        $this->db->where('id', $primary_key);
        $this->db->update('pages', $data);
        
        //user logs 
        
        $user_logs_insert = array(
            "id" => $this->session->userdata('user_id'),
            "date" => date('Y-m-d H:i:s'),
            "action" => 'Added {'.$post_array['title'].'} Page '
        );

        $this->db->insert('user_logs',$user_logs_insert);
        
    }
    
    function view_oil_and_sub_pages($primary_key , $row){
      return site_url('admin/oilandgasSubPages/'.$row->url);  
    }
    
    function oilandgasSubPages($parent=NULL){
        
        //var_dump($this->session->all_userdata());
        $this->load->config('grocery_crud');
        
        $this->config->set_item('grocery_crud_file_upload_allow_file_types',
                                                            'gif|jpeg|jpg|png');
        $this->grocery_crud->set_table('pages');
        
        $this->grocery_crud->set_theme('datatables');
        
        $this->grocery_crud->columns('title', 'content');
        
        $this->grocery_crud->where('type',str_replace('-', ' ', $parent));
                
        //$this->grocery_crud->where('pages.delete','active');
        
        $this->grocery_crud->display_as('date', 'Created Date')
                           ->display_as('date_modified', 'Modified Date')
                           ->display_as('type', 'Parent');
         
        $this->grocery_crud->set_subject('Pages');
        
        $this->grocery_crud->add_fields('title','content');
        
        //$this->grocery_crud->order_by('name','ASC');
        
        $this->grocery_crud->required_fields('title','content');
        
        $this->grocery_crud->edit_fields('title','content', 'type');
        
        $this->grocery_crud->callback_after_insert(array($this,'add_url_oil_sub_pages'));
                
        $this->grocery_crud->callback_after_update(array($this,'add_url_oil_sub_pages'));
                
        $this->grocery_crud->callback_before_delete(array($this,'log_user_before_page_delete'));
         
        $this->grocery_crud->add_action('Gallery', '', '','ui-icon-plus',array($this,'view_gallery')); 
        
                
        $output = $this->grocery_crud->render();
        
        $this->_admin_output($output); 
        
    }
    
    function add_url_oil_sub_pages($post_array, $primary_key){
        
        $url =url_title($post_array['title']);
        $data = array (
            'url' =>$url,
            'date'=>date('Y-m-d H:i:s'),
            'type'=>  str_replace('-', ' ', $this->uri->segment(3))
        );
        $this->db->where('id', $primary_key);
        $this->db->update('pages', $data);
        
        //user logs 
        
        $user_logs_insert = array(
            "id" => $this->session->userdata('user_id'),
            "date" => date('Y-m-d H:i:s'),
            "action" => 'Added {'.$post_array['title'].'} Page '
        );

        $this->db->insert('user_logs',$user_logs_insert);
        
    }      
        
    function clients(){
        
        $this->load->config('grocery_crud');
        
        $this->config->set_item('grocery_crud_file_upload_allow_file_types',
                                        'GIF|gif|jpeg|JPEG|jpg|JPG|png|PNG');
        $this->grocery_crud->set_table('clients');
        
        $this->grocery_crud->columns('name', 'website','image');
        
        $this->grocery_crud->add_fields('name', 'website', 'description', 'image');
        
        $this->grocery_crud->display_as('image', 'Photo');
        
        $this->grocery_crud->edit_fields('name', 'website', 'description');
 
        //$this->grocery_crud->set_theme('datatables');
        
        $this->grocery_crud->set_subject('Clients');
        
        $this->grocery_crud->required_fields('name', 'image');
        
        $this->grocery_crud->set_field_upload('image','assets/uploads/files/clients');
        
        $this->grocery_crud->callback_after_insert(array($this,'add_client_url'));
        
        $this->grocery_crud->callback_after_update(array($this,'add_client_url_update'));
        
        $this->grocery_crud->callback_before_delete(array($this,'delete_slides_callback'));
        
        $this->grocery_crud->callback_after_upload(array($this,'create_clients_Thumb_callback_after_upload'));
        
        $output = $this->grocery_crud->render();
        
        $this->_admin_output($output); 
    }
    
    function add_client_url($post_array, $primary_key){
        
        $url =url_title($post_array['name']);
        $data = array (
            'url' =>$url,
            'website'=>'http://'.str_replace('http://', '', $post_array['website']).'/'
        );
        $this->db->where('id', $primary_key);
        $this->db->update('clients', $data);
        
        //user logs 
        
        $user_logs_insert = array(
            "user_id" => $this->session->userdata('user_id'),
            "date" => date('Y-m-d H:i:s'),
            "action" => 'Added image for client {'.$post_array['name'].'}'
        );

        $this->db->insert('user_logs',$user_logs_insert);
        
        return TRUE;
    }
        
    function add_client_url_update($post_array, $primary_key){
        
        $url =url_title($post_array['name']);
        $data = array (
            'url' =>$url,
            'website'=>'http://'.  str_replace('http://', '', $post_array['website']).''
        );
        $this->db->where('id', $primary_key);
        $this->db->update('clients', $data);
        
        //user logs 
        
        $user_logs_insert = array(
            "user_id" => $this->session->userdata('user_id'),
            "date" => date('Y-m-d H:i:s'),
            "action" => 'Updated image for client {'.$post_array['name'].'}'
        );

        $this->db->insert('user_logs',$user_logs_insert);
        
        return TRUE;
    }
    
    function recyclebin(){
        
        $this->load->library('form_validation');
        $this->load->helper('form_helper');
        
        $this->db->where('delete','recycle');
        $this->db->from('pages');
        $deleted_pages = $this->db->count_all_results();
        
        $this->db->where('delete','recycle');
        $this->db->from('subpages');
        $deleted_menu = $this->db->count_all_results();
        
        $this->db->where('delete','recycle');
        $this->db->from('sections');
        $deleted_section = $this->db->count_all_results();
        
        $this->db->where('delete','recycle');
        $this->db->from('articles');
        $deleted_articles = $this->db->count_all_results();
        
        $data['data'] = '<table id ="recycle">
        <thead>
        <tr>
        <th>Recycled Pages</th>
        <th colspan="2">Action</th>
        </tr>
        </thead>
        <tbody>';
        if($deleted_pages!=NULL){
        $data['data'] .='<tr>
            <td>Total Number of recycled pages</td><td>'.$deleted_pages.'</td>
            <td>'.anchor('admin/recycledpaged', 'View').' |  '.anchor('admin/recycledpagesdelete', 'Delete').' | 
                '.anchor('admin/recycledpaged', 'Restore').'</td> 
            </tr>';
        }
        if($deleted_menu!=NULL){
        $data['data'] .='<tr><td>Total Number of recycled menus</td><td>'.$deleted_menu.'</td></tr>';
        }
        if($deleted_section!=NULL){
        $data['data'] .='<tr><td>Total Number of recycled section</td><td>'.$deleted_section.'</td></tr>';
        }
        if($deleted_articles!=NULL){
        $data['data'] .='<tr><td>Total Number of recycled articles</td><td>'.$deleted_articles.'</td></tr>';
        }
        $data['data'].='
        </tbody>
        </table>';
        
        $this->load->view('admin/recycle', $data);
    
    }
    
    function create_clients_Thumb_callback_after_upload($uploader_response,$field_info, $files_to_upload){
        
        $this->load->library('image_moo');

        //Is only one file uploaded so it ok to use it with $uploader_response[0].

        $file_uploaded = $field_info->upload_path.'/'.$uploader_response[0]->name; 
        
        chmod($file_uploaded, 0777);
        
        $thumb_uploaded = $field_info->upload_path.'/'.$uploader_response[0]->name; 

        $this->image_moo->load($file_uploaded)
                        //->set_background_colour("#767077")
                        ->resize(50,70)
                        ->save( $thumb_uploaded, TRUE);
    }
    
    function news(){
        
        $this->load->config('grocery_crud');
        
        $this->config->set_item('grocery_crud_file_upload_allow_file_types',
                                                            'gif|jpeg|jpg|png');
        $this->grocery_crud->set_table('news');
        
        $this->grocery_crud->columns('title','story');
 
        //$this->grocery_crud->set_theme('datatables');
        
        $this->grocery_crud->set_subject('News');
        
        $this->grocery_crud->add_fields('title','story', 'image');
        
        $this->grocery_crud->order_by('news_id','DESC');
        
        $this->grocery_crud->edit_fields('title','story', 'image');
        
        $this->grocery_crud->required_fields('title','story');
        
        $this->grocery_crud->set_field_upload('image','assets/uploads/files/news');
        
        $this->grocery_crud->callback_after_upload(array($this,'create_news_thumb_callback_after_upload'));
        
        //$this->grocery_crud->callback_before_insert(array($this,'add_thumb_befor_insert'));
        
        $this->grocery_crud->callback_after_insert(array($this,'add_news_url'));
        
        $this->grocery_crud->callback_after_update(array($this,'add_news_url'));
        
        $this->grocery_crud->callback_before_delete(array($this,'delete_news_pic_before_delete'));
 
        
        $output = $this->grocery_crud->render();
        
        $this->_admin_output($output); 
    }
    
    function create_news_thumb_callback_after_upload($uploader_response,$field_info, $files_to_upload){
        
        $this->load->library('image_moo');

        //Is only one file uploaded so it ok to use it with $uploader_response[0].

        $real_file_uploaded = $field_info->upload_path.'/'.$uploader_response[0]->name; 

        $show_file_uploaded = $field_info->upload_path.'/show/'.$uploader_response[0]->name;

        $this->image_moo->load($real_file_uploaded)
                          ->set_background_colour("#424450")
                          ->resize(500,330, TRUE)
                          ->save($show_file_uploaded);


        $this->load->library('image_moo');

        //Is only one file uploaded so it ok to use it with $uploader_response[0].

        $file_uploaded = $field_info->upload_path.'/'.$uploader_response[0]->name; 

        chmod($file_uploaded, 0777);

        $thumb_uploaded = $field_info->upload_path.'/thumb/Thumb_'.$uploader_response[0]->name; 

        $this->image_moo->load($file_uploaded)
                        ->set_background_colour("#424450")
                        ->resize(90,60, TRUE)
                        ->save( $thumb_uploaded);

        //update news table set thum path

        if (!$this->image_moo){

            print $this->image_moo->display_errors();
        }
        else{
            return true;
        }

    }
    
    function add_news_url($post_array, $primary_key){
        
        $url =url_title($post_array['title']);
        $url.='-'.$primary_key;
        $news_content = strip_tags($post_array['story']);
        $data = array (
            'url' =>$url
        );
        $this->db->where('news_id', $primary_key);
        $this->db->update('news', $data);
        
        return TRUE;
    }
    
    function delete_news_pic_before_delete($primary_key){
        
        $user= $this->db->select('image')->where('news_id',$primary_key)->get('news')->row();
        $path = base_url().'/assets/uploads/files/';
        $image      = $path.'news/'.$user->image;
        $show_image = $path.'news/tumb/Tumb_'.$user->image;
        $home_thumb = $path.'news/home_tumb/Tumb_'.$user->image;
        print $path;
        if(file_exists($image)){
            unlink($image);
        }
        if(file_exists($show_image)){
            unlink($show_image);
        }
        if(file_exists($home_thumb)){
            unlink($home_thumb);
        }
        
        return true;
    }
    
    function logs(){ 
        
        $this->load->config('grocery_crud');
        
        $this->config->set_item('grocery_crud_file_upload_allow_file_types',
                                                            'gif|jpeg|jpg|png');
        $this->grocery_crud->set_table('user_logs');
        
        $this->grocery_crud->columns('id','action', 'date');
        
        $this->grocery_crud->display_as('id', 'User');
 
        //$this->grocery_crud->set_theme('datatables');
        
        $this->grocery_crud->set_subject('User Logs');
        
        $this->grocery_crud->set_relation('id','users','username');
        
        //$this->grocery_crud->add_fields('title','story', 'image');unset_add();
        
        $this->grocery_crud->unset_add();
        
        $this->grocery_crud->unset_edit();
        
        $this->grocery_crud->order_by('date','DESC');
            
        $output = $this->grocery_crud->render();
        
        $this->_admin_output($output); 
    }
    
    function environment(){
        
        //var_dump($this->session->all_userdata());
        $this->load->config('grocery_crud');
        
        $this->config->set_item('grocery_crud_file_upload_allow_file_types',
                                                            'gif|jpeg|jpg|png');
        $this->grocery_crud->set_table('pages');
        
        $this->grocery_crud->set_theme('datatables');
        
        $this->grocery_crud->columns('title', 'content');
        
        $this->grocery_crud->where('top_level','Environment');
                
        //$this->grocery_crud->where('pages.delete','active');
        
        $this->grocery_crud->display_as('date', 'Created Date')
                           ->display_as('date_modified', 'Modified Date')
                           ->display_as('top_level', 'Parent');
         
        $this->grocery_crud->set_subject(' Page To Environment services');
        
        $this->grocery_crud->add_fields('title','content');
        
        //$this->grocery_crud->order_by('name','ASC');
        
        $this->grocery_crud->required_fields('title','content');
        
        $this->grocery_crud->edit_fields('title','content', 'top_level');
        
        $this->grocery_crud->callback_after_insert(array($this,'add_url_environment'));
                
        $this->grocery_crud->callback_after_update(array($this,'add_url_update'));
                
        $this->grocery_crud->callback_before_delete(array($this,'log_user_before_page_delete'));
        
        $this->grocery_crud->add_action('Sub Pages', '', '','ui-icon-plus',array($this,'view_environment_sub_pages')); 
        
        $this->grocery_crud->add_action('Gallery', '', '','ui-icon-plus',array($this,'view_gallery')); 
           
        $output = $this->grocery_crud->render();
        
        $this->_admin_output($output); 
        
    }
    
    function add_url_environment($post_array, $primary_key){
        
        $url =url_title($post_array['title']);
        $data = array (
            'url' =>$url,
            'date'=>date('Y-m-d H:i:s'),
            'top_level'=> 'Environment'
        );
        $this->db->where('id', $primary_key);
        $this->db->update('pages', $data);
        
        //user logs 
        
        $user_logs_insert = array(
            "id" => $this->session->userdata('user_id'),
            "date" => date('Y-m-d H:i:s'),
            "action" => 'Added {'.$post_array['title'].'} Page '
        );

        $this->db->insert('user_logs',$user_logs_insert);
        
        return TRUE;
    }
    
    function view_environment_sub_pages($primary_key , $row){
        
        return site_url('admin/environmentSubPages/'.$row->url);
    }
    
    function environmentSubPages($parent=NULL){
        
        //var_dump($this->session->all_userdata());
        $this->load->config('grocery_crud');
        
        $this->config->set_item('grocery_crud_file_upload_allow_file_types',
                                                            'gif|jpeg|jpg|png');
        $this->grocery_crud->set_table('pages');
        
        $this->grocery_crud->set_theme('datatables');
        
        $this->grocery_crud->columns('title', 'content');
        
        $this->grocery_crud->where('type',str_replace('-', ' ', $parent));
                
        //$this->grocery_crud->where('pages.delete','active');
        
        $this->grocery_crud->display_as('date', 'Created Date')
                           ->display_as('date_modified', 'Modified Date')
                           ->display_as('type', 'Parent');
         
        $this->grocery_crud->set_subject(' Menu To '.str_replace('-', ' ', $parent).'');
        
        $this->grocery_crud->add_fields('title','content');
        
        //$this->grocery_crud->order_by('name','ASC');
        
        $this->grocery_crud->required_fields('title','content');
        
        $this->grocery_crud->edit_fields('title','content', 'type');
        
        $this->grocery_crud->callback_after_insert(array($this,'add_url_environment_sub_page'));
                
        $this->grocery_crud->callback_after_update(array($this,'add_url_update'));
                
        $this->grocery_crud->callback_after_delete(array($this,'log_user_after_delete'));
 
        //$this->grocery_crud->callback_delete(array($this,'remove_menu_and_section'));
        
        $this->grocery_crud->add_action('Types', '', '','ui-icon-plus',array($this,'view_Types')); 
        
        $this->grocery_crud->add_action('Gallery', '', '','ui-icon-plus',array($this,'view_gallery')); 
        
                
        $output = $this->grocery_crud->render();
        
        $this->_admin_output($output); 
        
    }
    
    function add_url_environment_sub_page($post_array, $primary_key){
        
        $url =url_title($post_array['title']);
        $data = array (
            'url' =>$url,
            'date'=>date('Y-m-d H:i:s'),
            'type'=>  str_replace('-', ' ', $this->uri->segment(3))
        );
        $this->db->where('id', $primary_key);
        $this->db->update('pages', $data);
        
        //user logs 
        
        $user_logs_insert = array(
            "id" => $this->session->userdata('user_id'),
            "date" => date('Y-m-d H:i:s'),
            "action" => 'Added {'.$post_array['title'].'} Page '
        );

        $this->db->insert('user_logs',$user_logs_insert);
        
        return TRUE;
    }
    
    /////////////////////////    
    
    function training(){
        
        //var_dump($this->session->all_userdata());
        $this->load->config('grocery_crud');
        
        $this->config->set_item('grocery_crud_file_upload_allow_file_types',
                                                            'gif|jpeg|jpg|png');
        $this->grocery_crud->set_table('pages');
        
        $this->grocery_crud->set_theme('datatables');
        
        $this->grocery_crud->columns('title', 'content');
        
        $this->grocery_crud->where('top_level','Training');
                
        //$this->grocery_crud->where('pages.delete','active');
        
        $this->grocery_crud->display_as('date', 'Created Date')
                           ->display_as('date_modified', 'Modified Date')
                           ->display_as('top_level', 'Parent');
         
        $this->grocery_crud->set_subject(' Page To Training Programs');
        
        $this->grocery_crud->add_fields('title','content');
        
        //$this->grocery_crud->order_by('name','ASC');
        
        $this->grocery_crud->required_fields('title','content');
        
        $this->grocery_crud->edit_fields('title','content', 'top_level');
        
        $this->grocery_crud->callback_after_insert(array($this,'add_url_training'));
                
        $this->grocery_crud->callback_after_update(array($this,'add_url_update'));
                
        $this->grocery_crud->callback_before_delete(array($this,'log_user_before_page_delete'));
        
        $this->grocery_crud->add_action('Sub Pages', '', '','ui-icon-plus',array($this,'view_environment_sub_pages')); 
        
        $this->grocery_crud->add_action('Gallery', '', '','ui-icon-plus',array($this,'view_gallery')); 
           
        $output = $this->grocery_crud->render();
        
        $this->_admin_output($output); 
        
    }
    
    function add_url_training($post_array, $primary_key){
        
        $url =url_title($post_array['title']);
        $data = array (
            'url' =>$url,
            'date'=>date('Y-m-d H:i:s'),
            'top_level'=> 'Training'
        );
        $this->db->where('id', $primary_key);
        $this->db->update('pages', $data);
        
        //user logs 
        
        $user_logs_insert = array(
            "id" => $this->session->userdata('user_id'),
            "date" => date('Y-m-d H:i:s'),
            "action" => 'Added {'.$post_array['title'].'} Page '
        );

        $this->db->insert('user_logs',$user_logs_insert);
        
        return TRUE;
    }
    
    function view_training_sub_pages($primary_key , $row){
        
        return site_url('admin/trainingSubPages/'.$row->url);
    }
    
    function trainingSubPages($parent=NULL){
        
        //var_dump($this->session->all_userdata());
        $this->load->config('grocery_crud');
        
        $this->config->set_item('grocery_crud_file_upload_allow_file_types',
                                                            'gif|jpeg|jpg|png');
        $this->grocery_crud->set_table('pages');
        
        $this->grocery_crud->set_theme('datatables');
        
        $this->grocery_crud->columns('title', 'content');
        
        $this->grocery_crud->where('type',str_replace('-', ' ', $parent));
                
        //$this->grocery_crud->where('pages.delete','active');
        
        $this->grocery_crud->display_as('date', 'Created Date')
                           ->display_as('date_modified', 'Modified Date')
                           ->display_as('type', 'Parent');
         
        $this->grocery_crud->set_subject(' Menu To '.str_replace('-', ' ', $parent).'');
        
        $this->grocery_crud->add_fields('title','content');
        
        //$this->grocery_crud->order_by('name','ASC');
        
        $this->grocery_crud->required_fields('title','content');
        
        $this->grocery_crud->edit_fields('title','content', 'type');
        
        $this->grocery_crud->callback_after_insert(array($this,'add_url_training_sub_page'));
                
        $this->grocery_crud->callback_after_update(array($this,'add_url_update'));
                
        $this->grocery_crud->callback_after_delete(array($this,'log_user_after_delete'));
 
        //$this->grocery_crud->callback_delete(array($this,'remove_menu_and_section'));
        
        $this->grocery_crud->add_action('Types', '', '','ui-icon-plus',array($this,'view_Types')); 
        
        $this->grocery_crud->add_action('Gallery', '', '','ui-icon-plus',array($this,'view_gallery')); 
        
                
        $output = $this->grocery_crud->render();
        
        $this->_admin_output($output); 
        
    }
    
    function add_url_trainingt_sub_page($post_array, $primary_key){
        
        $url =url_title($post_array['title']);
        $data = array (
            'url' =>$url,
            'date'=>date('Y-m-d H:i:s'),
            'type'=>  str_replace('-', ' ', $this->uri->segment(3))
        );
        $this->db->where('id', $primary_key);
        $this->db->update('pages', $data);
        
        //user logs 
        
        $user_logs_insert = array(
            "id" => $this->session->userdata('user_id'),
            "date" => date('Y-m-d H:i:s'),
            "action" => 'Added {'.$post_array['title'].'} Page '
        );

        $this->db->insert('user_logs',$user_logs_insert);
        
        return TRUE;
    }
    
    function view_gallery($primary_key , $row){
        
        return site_url('admin/gallery/'.$row->url); 
    }
    
    /////////////////////////    
    
    function projects(){
        
        $this->load->config('grocery_crud');
        
        $this->config->set_item('grocery_crud_file_upload_allow_file_types',
                                                            'gif|jpeg|jpg|png');
        $this->grocery_crud->set_table('projects');
        
        $this->grocery_crud->columns('title','story', 'start_date','end_date');
        
        $this->grocery_crud->display_as('story','Project Description')
                           ->display_as('Start_date', 'Start Date')
                           ->display_as('end_date', 'End Date');
  
        //$this->grocery_crud->set_theme('datatables');
        
        $this->grocery_crud->set_subject('Projects');
        
        $this->grocery_crud->add_fields('title','story', 'start_date','end_date');
        
        $this->grocery_crud->order_by('id','DESC');
        
        $this->grocery_crud->edit_fields('title','story', 'start_date','end_date');
        
        $this->grocery_crud->required_fields('title','story', 'start_date','end_date');
        
        $this->grocery_crud->add_action('Gallery', ''.  base_url().'assets/grocery_crud/themes/flexigrid/css/images/g-icon.png', 'admin/projectgallery');
        
        $this->grocery_crud->callback_after_insert(array($this,'add_url_projects'));
        
        $this->grocery_crud->callback_after_update(array($this,'add_url_projects'));
       
        $output = $this->grocery_crud->render();
        
        $this->_admin_output($output); 
        
    }
    
    function add_url_projects($post_array, $primary_key){
        
        $url =url_title($post_array['title']);
        $data = array (
            'url' =>$url,
            'date_updated'=>date('Y-m-d H:i:s'),
        );
        $this->db->where('id', $primary_key);
        $this->db->update('projects', $data);
        
        //user logs 
        
        $user_logs_insert = array(
            "id" => $this->session->userdata('user_id'),
            "date" => date('Y-m-d H:i:s'),
            "action" => 'Added {'.$post_array['title'].'} Project Page '
        );

        $this->db->insert('user_logs',$user_logs_insert);
        
        return TRUE;
    }
    
    function view_project_gallery($primary_key , $row){
        
        return site_url('admin/projectSubPages/'.$row->url);
    }
    
    function projectgallery(){
        
        $this->db->select('url, title');
        $this->db->where('id', $this->uri->segment(3));
        $url=  $this->db->get('projects')->row();
        
        $this->load->config('grocery_crud');
        
        $this->config->set_item('grocery_crud_file_upload_allow_file_types',
                                                            'gif|jpeg|jpg|png');
        $this->grocery_crud->set_table('gallery');
        
        $this->grocery_crud->columns('image','url', 'description');
        
        $this->grocery_crud->where('url', $url->url);
         
        $this->grocery_crud->display_as('url', 'Page');
        
        $this->grocery_crud->add_fields('image','description');
        
        $this->grocery_crud->edit_fields('image','description');
        
        $this->grocery_crud->required_fields('image');
                
        $this->grocery_crud->set_subject('Image To '.  ucwords($url->title));
        
        $this->grocery_crud->set_field_upload('image','assets/uploads/files/projects');
        
        $this->grocery_crud->callback_after_upload(array($this,'create_project_thumb_callback_after_upload'));
       
        $this->grocery_crud->callback_after_insert(array($this,'add_url_project_gallery'));
        
        $this->grocery_crud->callback_after_update(array($this,'add_url_project_gallery'));
        
        $this->grocery_crud->callback_before_delete(array($this,'delete_news_pic_before_delete'));
 
        
        $output = $this->grocery_crud->render();
        
        $this->_admin_output($output); 
               
    }
    
    function add_url_project_gallery($post_array, $primary_key){
         
        $this->db->select('url', 'title');
        $this->db->where('id', $this->uri->segment(3));
        $url=  $this->db->get('projects')->row();
        $data = array (
            'url' =>$url->url,
        );
        $this->db->where('id', $primary_key);
        $this->db->update('gallery', $data);
        
        //user logs 
        
        $user_logs_insert = array(
            "id" => $this->session->userdata('user_id'),
            "date" => date('Y-m-d H:i:s'),
            "action" => 'Added image to {'.$url->title.'} Gallery '
        );

        $this->db->insert('user_logs',$user_logs_insert);
        
        return TRUE;
    }
    
    function create_project_thumb_callback_after_upload($uploader_response,$field_info, $files_to_upload){
        
        $this->load->library('image_moo');

        //Is only one file uploaded so it ok to use it with $uploader_response[0].

        $real_file_uploaded = $field_info->upload_path.'/'.$uploader_response[0]->name; 

        //$show_file_uploaded = $field_info->upload_path.'/show/'.$uploader_response[0]->name;

        $this->image_moo->load($real_file_uploaded)
                          ->set_background_colour("#434551")
                          ->resize(500,330, TRUE)
                          ->save($real_file_uploaded, TRUE);


        $this->load->library('image_moo');

        //Is only one file uploaded so it ok to use it with $uploader_response[0].

        $file_uploaded = $field_info->upload_path.'/'.$uploader_response[0]->name; 

        chmod($file_uploaded, 0777);

        $thumb_uploaded = $field_info->upload_path.'/thumb/Thumb_'.$uploader_response[0]->name; 

        $this->image_moo->load($file_uploaded)
                        ->set_background_colour("#434551")
                        ->resize(90,60, TRUE)
                        ->save( $thumb_uploaded, TRUE);

        //update news table set thum path

        if (!$this->image_moo){

            print $this->image_moo->display_errors();
        }
        else{
            return true;
        }

    }
    
    function gallery(){
        
        $this->load->config('grocery_crud');
        
        $this->config->set_item('grocery_crud_file_upload_allow_file_types',
                                                            'gif|jpeg|jpg|png');
        $this->grocery_crud->set_table('gallery');
        
        $this->grocery_crud->columns('image','url', 'description');
 
        //$this->grocery_crud->set_theme('datatables');
        
        $this->grocery_crud->set_relation('url', 'pages','title');
        
        $this->grocery_crud->display_as('url', 'Page');
        
        $this->grocery_crud->add_fields('image','description');
        
        $this->grocery_crud->edit_fields('image','description');
        
        $this->grocery_crud->required_fields('image');
                
        $this->grocery_crud->set_subject('Image To '.  ucwords(str_replace('-', ' ', $this->uri->segment(3))).' Gallery');
        
        $this->grocery_crud->set_field_upload('image','assets/uploads/files/pages');
        
        $this->grocery_crud->callback_after_upload(array($this,'create_page_thumb_callback_after_upload'));
        
                
        $this->grocery_crud->callback_after_insert(array($this,'add_gallery_url'));
        
        $this->grocery_crud->callback_after_update(array($this,'add_gallery_url'));
        
        $this->grocery_crud->callback_before_delete(array($this,'delete_news_pic_before_delete'));
 
        
        $output = $this->grocery_crud->render();
        
        $this->_admin_output($output); 
        
    }
    
    function create_page_thumb_callback_after_upload($uploader_response,$field_info, $files_to_upload){
        
        $this->load->library('image_moo');

        //Is only one file uploaded so it ok to use it with $uploader_response[0].

        $real_file_uploaded = $field_info->upload_path.'/'.$uploader_response[0]->name; 

        //$show_file_uploaded = $field_info->upload_path.'/show/'.$uploader_response[0]->name;

        $this->image_moo->load($real_file_uploaded)
                          ->set_background_colour("#434551")
                          ->resize(500,330, TRUE)
                          ->save($real_file_uploaded, TRUE);


        $this->load->library('image_moo');

        //Is only one file uploaded so it ok to use it with $uploader_response[0].

        $file_uploaded = $field_info->upload_path.'/'.$uploader_response[0]->name; 

        chmod($file_uploaded, 0777);

        $thumb_uploaded = $field_info->upload_path.'/thumb/Thumb_'.$uploader_response[0]->name; 

        $this->image_moo->load($file_uploaded)
                        ->set_background_colour("#434551")
                        ->resize(90,60, TRUE)
                        ->save( $thumb_uploaded, TRUE);

        //update news table set thum path

        if (!$this->image_moo){

            print $this->image_moo->display_errors();
        }
        else{
            return true;
        }

    }

    function add_gallery_url($post_array, $primary_key){

        $data = array (
           'url' =>  $this->uri->segment(3),
       );
       $this->db->where('id', $primary_key);
       $this->db->update('gallery', $data);

       return TRUE;
    }
    
    function home(){
        
        $this->load->config('grocery_crud');
        
        $this->config->set_item('grocery_crud_file_upload_allow_file_types',
                                                            'gif|jpeg|jpg|png');
        $this->grocery_crud->set_table('home');
        
        $this->grocery_crud->columns('title','description', 'order', 'image');
 
        //$this->grocery_crud->set_theme('datatables');
        
        $this->grocery_crud->set_subject('Image TO Home Slids');
        
        $this->grocery_crud->add_fields('title','description', 'image');
        
        $this->grocery_crud->order_by('order','ASC');
        
        $this->grocery_crud->edit_fields('title','description', 'image');
        
        $this->grocery_crud->required_fields('title','description', 'image');
        
        $this->grocery_crud->set_field_upload('image','assets/uploads/files/pages');
        
        $this->grocery_crud->callback_after_upload(array($this,'create_page_thumb_callback_after_upload'));
        
        //$this->grocery_crud->callback_after_update(array($this,'create_url_callback'));
        $this->grocery_crud->add_action('Up', base_url().'assets/grocery_crud/themes/flexigrid/css/images/up.png', 'admin/homeup');
        
        $this->grocery_crud->add_action('down', base_url().'assets/grocery_crud/themes/flexigrid/css/images/down.png', 'admin/homedown');
                        
        $output = $this->grocery_crud->render();
        
        $this->_admin_output($output); 
    }
    
     function homeup($id){
         
        $order_key = array();
        $order_value = array();
        
        $order =  $this->db->select('order')->from('home')
                  ->get()->result_array();
        foreach ($order as $key=>$value){
            
            foreach ($value as $order_by){
                
                array_push($order_value, $order_by);
                
                array_push($order_key, $order_by);
            }
        }
  
        $order_s = array_combine($order_key, $order_value);
        $order_this =  $this->db->select('order')->from('home')
                  ->where('id', $id)->get()->row();
         
         $selection = $order_this->order;
         if($order_this->order >=1){
             $page_to_order = $order_this->order;
            
             $order_my_page =$page_to_order - 1;
             
             $order_that =$page_to_order + 1;
             
             $data = array ('order'=>$order_my_page);
             
             $down = $this->db->select('id')->where('order', $order_my_page)->get('home')->row();
             
            //print $down->id.'<hr />';
             
             if($down){
                 
                 $up = $this->db->where('id', $id)->update('home', $data);
                 if($up){
                     
                     $order_data = array ('order'=>$page_to_order);
                     $this->db->where('id', $down->id)->update('home', $order_data);

                }

             }
             
             redirect(base_url('admin/home'));     
         }
         else
         {
             redirect(base_url('admin/home'));
         }
    }
    
    
    
    function homedown($id){
         
        $order_key = array();
        $order_value = array();
        
        $order =  $this->db->select('order')->from('home')
                  ->get()->result_array();
        foreach ($order as $key=>$value){
            
            foreach ($value as $order_by){
                
                array_push($order_value, $order_by);
                
                array_push($order_key, $order_by);
            }
        }
  
        $order_s = array_combine($order_key, $order_value);
        $order_this =  $this->db->select('order')->from('home')
                  ->where('id', $id)->get()->row();
         
         $selection = $order_this->order;
         
         if($order_this->order >=1 && !($order_this->order  >=  max($order_s))){
             
             $page_to_order = $order_this->order;
            
             $order_my_page =$page_to_order - 1;
             
             $order_that =$page_to_order + 1;
             
             $data = array ('order'=>$order_that);
             
             $up = $this->db->select('id')->where('order', $order_that)->get('home')->row();
             
            //print $down->id.'<hr />';
             
             if($up){
                 
                 $down = $this->db->where('id', $id)->update('home', $data);
                 if($down){
                     
                     $order_data = array ('order'=>$page_to_order);
                     $this->db->where('id', $up->id)->update('home', $order_data);

                }

             }
             
             redirect(base_url('admin/home'));     
         }
         else
         {
             redirect(base_url('admin/home'));
         }
         
    }
    
    // Am using the same output foreach table bcoz the admin theme doesn't change
    function _admin_output($output = null){
        $this->load->view('adminoutput.php',$output);    
    }
    
}

?>
 