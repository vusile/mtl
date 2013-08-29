<?php $this->load->view('template/header') ?>


<div id="infoMessage"><?php echo $message;?></div>

<?php echo form_open("auth/create_user");?>
<table border="0" cellspacing="0" cellpadding="6" bgcolor="#EDEFF4" style="padding:25px; border:1px dotted #ccc; ">
    <tr>
         <th colspan="2"><?php echo "To <h1>". lang('create_user_heading');?></h1>
        <?php echo" ". lang('create_user_subheading');?></th>
         
     </tr>
     <tr>
         <td><?php echo lang('create_user_fname_label', 'first_name');?></td>
         <td><?php echo form_input($first_name);?></td>
     </tr>
     <tr>
         <td><?php echo lang('create_user_lname_label', 'first_name');?></td>
         <td><?php echo form_input($last_name);?></td>
     </tr>
     <tr>
         <td><?php echo lang('create_user_company_label', 'company');?></td>
         <td><?php echo form_input($company);?></td>
     </tr>
     <tr>
         <td><?php echo lang('create_user_email_label', 'email');?></td>
         <td><?php echo form_input($email);?></td>
     </tr>
     <tr>
         <td><?php echo lang('create_user_phone_label', 'phone');?></td>
         <td><?php echo form_input($phone);?></td>
     </tr>
     <tr>
         <td><?php echo lang('create_user_password_label', 'password');?></td>
         <td><?php echo form_input($password);?></td>
     </tr>
     <tr>
         <td><?php echo lang('create_user_password_confirm_label', 'password_confirm');?></td>
         <td><?php echo form_input($password_confirm);?></td>
     </tr>
     <tr>
         <td><?php echo form_submit('submit', lang('create_user_submit_btn'));?></td>
         <td></td>
     </tr>

</table>
<?php echo form_close();?>
<?php $this->load->view('template/footer') ?>
