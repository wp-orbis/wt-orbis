<?php

get_header();

// Temporary array to connect Orbis users to WordPress
$users = array(
	2 => 6 ,
	3 => 5 ,
	4 => 1 ,
	5 => 4 ,
	7 => 3 ,
	8 => 24
);


global $current_user;

// Get userid
get_currentuserinfo();
$userID = $users[$current_user->ID];

?>

<style>

span {
	display: block;

	color: #999;

	font-size: 11px;
}

</style>

<?php

global $wpdb;

$result = $wpdb->get_results( "SELECT * FROM orbis_tasks WHERE assigned_to_id = $userID ORDER BY id DESC LIMIT 10");

?>


<div class="page-header">
	<h1 class="pull-left">
		Tasks <small><?php _e('Tasks from this user', 'orbis'); ?></small>
	</h1>
	
	<a class="btn pull-right" href="<?php bloginfo("url")?>/wp-admin/post-new.php?post_type=orbis_person"><i class="icon-plus-sign"></i> <?php _e('Add task', 'orbis'); ?></a>
	
	<div class="clearfix"></div>
</div>


<table class="table table-striped table-bordered">
	<thead>
		<tr>
			<th>Project</th>
			<th>Beschrijving</th>
			<th>Tijd</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		<?php $date = 0; foreach($result as $row): ?>
		
		<?php if($date != $row->date): $date = $row->date; ?>
		
		<tr>
			<td colspan="3"><h2><?php echo $row->date; ?></h2></td>
		</tr>
		
		<?php endif; ?>

		<tr>
			<td><?php echo $row->project_id; ?></td>
			<td>
				<i class="icon-file"></i>
				<?php echo $row->task; ?>
				<span>Created on <?php echo date('d F Y', $row->added_on_date); ?> by <?php echo $row->added_by_id; ?></span>
			</td>
			<td><?php echo gmdate("H:i", $row->planned_duration); ?></td>
			<td><a href="#">Done</a></td>
		</tr>

		<?php endforeach; ?>
	</tbody>
</table>



<div class="row">
	<div class="span4">
		<h3>Add task</h3>
		  <form class="form-horizontal">
			<fieldset>
			  <div class="control-group">
				<label class="control-label" for="input01">Text input</label>
				<div class="controls">
				  <input type="text" class="input-xlarge" id="input01">
				  <p class="help-block">In addition to freeform text, any HTML5 text-based input appears like so.</p>
				</div>
			  </div>
			  <div class="control-group">
				<label class="control-label" for="optionsCheckbox">Checkbox</label>
				<div class="controls">
				  <label class="checkbox">
					<input type="checkbox" id="optionsCheckbox" value="option1">
					Option one is this and that&mdash;be sure to include why it's great
				  </label>
				</div>
			  </div>
			  <div class="control-group">
				<label class="control-label" for="select01">Select list</label>
				<div class="controls">
				  <select id="select01">
					<option>something</option>
					<option>2</option>
					<option>3</option>
					<option>4</option>
					<option>5</option>
				  </select>
				</div>
			  </div>
			  <div class="control-group">
				<label class="control-label" for="multiSelect">Multicon-select</label>
				<div class="controls">
				  <select multiple="multiple" id="multiSelect">
					<option>1</option>
					<option>2</option>
					<option>3</option>
					<option>4</option>
					<option>5</option>
				  </select>
				</div>
			  </div>
			  <div class="control-group">
				<label class="control-label" for="textarea">Textarea</label>
				<div class="controls">
				  <textarea class="input-xlarge" id="textarea" rows="3"></textarea>
				</div>
			  </div>
			  <div class="form-actions">
				<button type="submit" class="btn btn-primary">Add task</button>
				<button class="btn">Cancel</button>
			  </div>
			</fieldset>
		  </form>
	</div>
</div>

<?php get_footer(); ?>