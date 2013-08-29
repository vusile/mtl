<?php $this->load->view('template/header') ?>


<div id="infoMessage"><?php echo $message;?></div>
<?php $attributes = array('class' => 'email', 'id' => 'myform');?>
<?php echo form_open(uri_string());?>
 <table border="0" cellspacing="0" cellpadding="6" bgcolor="#EDEFF4" style="padding:25px; border:1px dotted #ccc; ">
     <tr>
         <th colspan="2"><?php echo "To <h1>". lang('edit_user_heading');?></h1>
<?php echo" ". lang('edit_user_subheading');?></th>
         
     </tr>
     <tr>
         <td><?php echo lang('edit_user_fname_label', 'first_name');?></td>
         <td><?php echo form_input($first_name);?></td>
     </tr>
     <tr>
         <td><?php echo lang('edit_user_lname_label', 'last_name');?></td>
         <td><?php echo form_input($last_name);?></td>
     </tr>
     <tr>
         <td> <?php echo lang('edit_user_company_label', 'company');?></td>
         <td> <?php echo form_input($company);?></td>
     </tr>
     <tr>
         <td><?php echo lang('edit_user_phone_label', 'phone');?></td>
         <td> <?php echo form_input($phone);?></td>
     </tr>
     <tr>
         <td><?php echo lang('edit_user_password_label', 'password');?></td>
         <td><?php echo form_input($password);?></td>
     </tr>
     <tr>
         <td><?php echo lang('edit_user_password_confirm_label', 'password_confirm');?></td>
         <td><?php echo form_input($password_confirm);?></td>
     </tr>
     <tr>
         <td><?php echo lang('edit_user_groups_heading');?></td>
         <td>
             <?php foreach ($groups as $group):?>
             
	<label class="checkbox">
	<?php
		$gID=$group['id'];
		$checked = null;
		$item = null;
		foreach($currentGroups as $grp) {
			if ($gID == $grp->id) {
				$checked= ' checked="checked"';
			break;
			}
		}
	?>
	<input type="checkbox" name="groups[]" value="<?php echo $group['id'];?>"<?php echo $checked;?>>
	<?php echo $group['name'];?>
	</label>
	<?php endforeach?>
         
         </td>
     </tr>
     <tr>
         <td></td>
         <td>
      <?php echo form_submit('submit', lang('edit_user_submit_btn'));?></p></td>
     </tr>

	

      <?php echo form_hidden('id', $user->id);?>
      <?php echo form_hidden($csrf); ?>

 </table>
<?php echo form_close();?>
<?php $this->load->view('template/footer') ?>