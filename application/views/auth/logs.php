<?php $this->load->view('template/header') ?>
<div id="topMessage">
    <h1 style ="margin-left: -4px;">User Logs</h1>
    <p>Below is a list of all the action done by different users on the site </p>
</div>

<div id="infoMessage"></div>

<table  class="tsc_tables2_0" cellspacing="0" summary="DT features" style="width:80%;">
	<tr>
		<th>#</th>
		<th>User ID</th>
		<th>Log</th>
		<th>Date Created</th>
		<th>Action</th>
	</tr>
	<?php foreach ($user_logs as $log):?>
		<tr>
			<td><?php echo $log['id'];?></td>
			<td><?php echo $log['user_id'];?></td>
			<td><?php echo $log['action'];?></td>
			<td><?php echo $log['date'];?></td>
			<td><?php echo  anchor("auth/delete_log/".$log['id'], 'Delete');?></td>
		</tr>
	<?php endforeach;?>
</table>
<div id="topMessage">
   
</div>
<?php $this->load->view('template/footer') ?>