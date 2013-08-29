<?php $this->load->view('template/header') ?>
<?php echo form_open("auth/deactivate/".$user->id);?>
<table border="0" cellspacing="0" cellpadding="6" bgcolor="#EDEFF4" style="padding:25px; border:1px dotted #ccc; ">
<tr>
     <th colspan="2"><?php echo "To <h1>". lang('deactivate_heading');?></h1>
   <?php echo sprintf(lang('deactivate_subheading'), $user->username);?></th>

 </tr>
 <tr>
     <td><?php echo lang('deactivate_confirm_y_label', 'confirm');?></td>
     <td><input type="radio" name="confirm" value="yes" checked="checked" /></td>
 </tr>
 <tr>
     <td><?php echo lang('deactivate_confirm_n_label', 'confirm');?></td>
     <td><input type="radio" name="confirm" value="no" /></td>
 </tr>
 <tr>
     <td><?php echo form_submit('submit', lang('deactivate_submit_btn'));?></td>
     <td></td>
 </tr>


  <?php echo form_hidden($csrf); ?>
  <?php echo form_hidden(array('id'=>$user->id)); ?>

  <p></p>

<?php echo form_close();?>
<?php $this->load->view('template/footer') ?>