<?php 
include 'header.php';
if(!$userloggedin) { header("Location: index.php"); }
// the default we are not in the edit mode
$edit = false;
//if action met then we will check the action
if(isset($_REQUEST['action'])) {
	switch ($_REQUEST['action']) {
		// if action is add we will insert the auction
		case 'add':
			$data = [
				'name'=>$_POST['name'],
				'description'=>$_POST['description'],
				'end_date'=>$_POST['end_date'],
				'user_id'=>$_SESSION['userid'],
				'price'=>$_POST['price'],
				'category_id'=>$_POST['category_id'],
			];
			
			$stmt = $db->prepare('Insert into products 
					values(NULL, :name, :description, :end_date, :user_id, 
							:price, :category_id)');  
			$stmt->execute($data);
			break;
		//case edit met then edit selected auction
		case 'edit':
			// set that we are in the edit mode
			$edit = true;
			if(!isset($_GET['id']) || empty($_GET['id'])) {
				continue;
			}
			// get the row of the selected auction
			$user_part = " and user_id = :user_id";
			$stmt = $db->prepare('SELECT * FROM products where id = :id'.$user_part);  
			$stmt->execute(['id'=>$_GET['id'], 'user_id'=>$_SESSION['userid']]);
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			break;
		// if action is doedit update the auction with the new name
		case 'doedit':
			$stmt = $db->prepare('Update products set 
				name = :name, description = :description, end_date = :end_date, 
				user_id = :user_id, price = :price, category_id = :category_id
				Where id = :id');  
			$stmt->execute([
				'name'=>$_POST['name'],
				'description'=>$_POST['description'],
				'end_date'=>$_POST['end_date'],
				'user_id'=>$_SESSION['userid'],
				'price'=>$_POST['price'],
				'category_id'=>$_POST['category_id'],
				'id'=>$_POST['id'],
			]);
			break;
		// if action is delete, delete the auction from database
		case 'delete':
			if(!isset($_GET['id']) || empty($_GET['id'])) {
				continue;
			}
			$user_part = " and user_id = :user_id";
			$stmt = $db->prepare('Delete from products Where id = :id'.$user_part);  
			$stmt->execute(['id'=>$_GET['id'], 'user_id'=>$_SESSION['userid']]);
			break;
		default:
			break;
	}
}
?>
<main>
<h1>Auctions</h1>
<?php // if we are in edit mode we will display 'Edit' else display 'Add' ?>
<h2><?=($edit?'Edit':'Add')?> Auction</h2>
<form action="" method="post">
	<label>Name: </label>
	<input type="text" name="name" required="required" 
		value="<?=($edit?$row['name']:'')?>" />
	<label>Category: </label>
	<select name="category_id" required="required">
		<option value="0" disabled>Select Category</option>
		<?php 
			$categories = [];
			foreach(getCategories() as $cat) { 
		?>
		<option value="<?=$cat['id']?>"
				<?=(($edit&&$cat['id']==$row['category_id'])?'selected="selected"':'')?>>
				<?=$cat['name']?>
		</option>
		<?php 
				$categories[$cat['id']] = $cat['name'];
			} 
		?>
	</select>
	
	<label>Description:</label>
	<textarea name="description">
		<?=($edit?$row['description']:'')?>
	</textarea>
	
	<label>End Date: (yyyy-mm-dd)</label>
	<input type="text" name="end_date" required="required" value="<?=($edit?$row['end_date']:'')?>" />
	
	<label>Price:</label>
	<input type="text" name="price" required="required" value="<?=($edit?$row['price']:'')?>" />
	<input type="hidden" name="action" value="<?=($edit?'doedit':'add')?>" />
	<?php if ($edit) { ?>
	<input type="hidden" name="id" value="<?=$row['id']?>" />
	<?php } ?>
	<input type="submit" name="submit" value="<?=($edit?'Edit':'Add')?>" />
</form>
<?php
// Get all the auctions to list it
$rows = getAuctions($_SESSION['userid']);
?>
<table width="70%" calss="table">
	<tr>
		<th>Name</th>
		<th>Category</th>
		<th>Price</th>
		<th>Actions</th>
	</tr>
	<?php foreach($rows as $row) { ?>
	<tr>
		<td><?=$row['name'];?></td>
		<td><?=$categories[$row['category_id']];?></td>
		<td><?=$row['price'];?></td>
		<td>
			<a href="auction.php?id=<?=$row['id']?>">View</a>
			<a href="auctions.php?action=edit&id=<?=$row['id']?>">Edit</a>
			<a href="auctions.php?action=delete&id=<?=$row['id']?>">Delete</a>
		</td>
	</tr>
	<?php } ?>
</table>
</main>
<?php include 'footer.php'; ?>