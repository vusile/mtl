<?php $this->load->view('template/header') ?>
<div class="tsc_message_box1 tsc_simple_bg success closeable"><?php echo $message;?></div>

<?php echo form_open("auth/create_group");?>
<table border="0" cellspacing="0" cellpadding="6" bgcolor="#EDEFF4" style="padding:25px; border:1px dotted #ccc; ">
<tr>
     <th colspan="2"><?php echo "To <h1>". lang('create_group_heading');?></h1>
    <?php echo" ". lang('create_group_subheading');?></th>

 </tr>
 <tr>
     <td><?php echo lang('create_group_name_label', 'group_name');?></td>
     <td><?php echo form_input($group_name);?></td>
 </tr>
 <tr>
     <td><?php echo lang('create_group_desc_label', 'description');?> </td>
     <td><?php echo form_input($description);?></td>
 </tr>
 <tr>
     <td><?php echo form_submit('submit', lang('create_group_submit_btn'));?></td>
     <td></td>
 </tr>
</table>
<?php echo form_close();?>
<?php $this->load->view('template/footer') ?>