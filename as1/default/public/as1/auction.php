<?php
include 'header.php';
// if there is no id so we can not display a product so redirect to home
if(!isset($_GET['id']) || empty($_GET['id'])) {
	header('Location: index.php');
}

// get the product with its id
$stmt = $db->prepare('SELECT * FROM products where id = :id');  
$stmt->execute(['id'=>$_GET['id']]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);
// get the categories as array to get the name of the product category
$categories = getCategoriesArray();
// get the username from user id
$product_user = getUserNameById($product['user_id']);


// calculate the difference between the end date and current time
$end_date = new DateTime($product['end_date']);
$now = new DateTime();
$diff = $end_date->diff($now)->format('%d days, %h hours and %i minutes');
?>

<h1>Product Page</h1>
<article class="product">
	<?php // List the product information ?>
	<img src="product.png" alt="<?=$product['name']?>">
	<section class="details">
		<h2><?=$product['name']?></h2>
		<h3><?=$categories[$product['category_id']]?></h3>
		<p>Auction created by <a href="#"><?=$product_user?></a></p>
		<p class="price">Current bid: £<?=$product['price']?></p>
		<time>Time left: <?=$diff?></time>
		<form action="#" class="bid">
			<input type="text" placeholder="Enter bid amount" />
			<input type="submit" value="Place bid" />
		</form>
	</section>
	<section class="description">
	<p><?=$product['description']?></p>


	</section>
	<?php
		// show the reviews section only if the user logged in
		if($userloggedin) { 
			// if the post submitted insert the review
			if(isset($_POST['reviewtext']) && !empty($_POST['reviewtext'])) {
				insertReview($_POST);
			}
	?>
	<section class="reviews">
		<?php // show all the reviews of the current product ?>
		<h2>Reviews of <?=$product_user?> </h2>
		<ul>
			<?php foreach(getProductReviews($product['id']) as $review) { ?>
			<li>
				<strong><?=getUserNameById($review['user_id'])?></strong> 
				<?=$review['review']?> 
				<em><?=date('d/m/Y', strtotime($review['date']))?></em>
			</li>
		<?php } ?>
		</ul>
		<?php  // display the form of adding review ?>
		<form action="" method="post">
			<label>Add your review</label> <textarea name="reviewtext"></textarea>
			<input type="hidden" name="product_id" value="<?=$product['id']?>">
			<input type="submit" value="Add Review" />
		</form>
	</section>
	<?php } ?>
</article>