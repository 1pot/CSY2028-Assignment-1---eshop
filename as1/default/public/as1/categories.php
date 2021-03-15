<?php 
include 'admin_header.php';
// the default we are not in the edit mode
$edit = false;
//if action met then we will check the action
if(isset($_GET['action'])) {
	switch ($_GET['action']) {
		// if action is add we will insert the category
		case 'add':
			$stmt = $db->prepare('Insert into categories values(NULL, :name)');  
			$stmt->execute(['name'=>$_GET['name']]);
			break;
		//case edit met then edit selected category
		case 'edit':
			// set that we are in the edit mode
			$edit = true;
			if(!isset($_GET['id']) || empty($_GET['id'])) {
				continue;
			}
			// get the row of the selected category
			$stmt = $db->prepare('SELECT * FROM categories where id = :id');  
			$stmt->execute(['id'=>$_GET['id']]);
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			break;
		// if action is doedit update the category with the new name
		case 'doedit':
			$stmt = $db->prepare('Update categories set name = :name Where id = :id');  
			$stmt->execute(['name'=>$_GET['name'], 'id'=>$_GET['id']]);
			break;
		// if action is delete, delete the category from database
		case 'delete':
			if(!isset($_GET['id']) || empty($_GET['id'])) {
				continue;
			}
			$stmt = $db->prepare('Delete from categories Where id = :id');  
			$stmt->execute(['id'=>$_GET['id']]);
			break;
		default:
			break;
	}
}
?>
<main>
<h1>Categories</h1>
<?php // if we are in edit mode we will display 'Edit' else display 'Add' ?>
<h2><?=($edit?'Edit':'Add')?> Category</h2>
<form action="" method="get">
	<input type="text" name="name" required="required" value="<?=($edit?$row['name']:'')?>" />
	<input type="hidden" name="action" value="<?=($edit?'doedit':'add')?>" />
	<?php if ($edit) { ?>
	<input type="hidden" name="id" value="<?=$row['id']?>" />
	<?php } ?>
	<input type="submit" name="submit" value="<?=($edit?'Edit':'Add')?>" />
</form>
<?php
// Get all the categories to list it
$rows = getCategories();
?>
<table calss="table">
	<tr>
		<th>Name</th>
		<th>Actions</th>
	</tr>
	<?php foreach($rows as $row) { ?>
	<tr>
		<td><?=$row['name'];?></td>
		<td>
			<a href="categories.php?action=edit&id=<?=$row['id']?>">Edit</a>
			<a href="categories.php?action=delete&id=<?=$row['id']?>">Delete</a>
		</td>
	</tr>
	<?php } ?>
</table>
</main>
<?php include 'admin_footer.php'; ?>