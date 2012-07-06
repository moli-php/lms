<?php echo Common::displayMenu(true,array("label"=>"Add New User","most_action"=>"User.view_adduser"));?>

<div>
	<h3><?php echo $text; ?></h3>
</div>
<input type="button" id="button">
<div id="dialog">
<div id="datepicker"></div>
asd
</div>
<?php Common::urlInclude('page'); ?>
<?php Common::paginate($iCurrentPage, $iRowsPerPage, $iTotalRows); ?>