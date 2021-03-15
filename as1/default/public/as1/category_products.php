<?php 
include 'header.php';
// if we don't have the category id redirect to home
if(!isset($_GET['catid']) || empty($_GET['catid'])) {
	header('Location: index.php');
}
// get the last 10 products of this category id
$products = getLastAuctions(10, $_GET['catid']);
// get the categories as array to get the name of the product category
$categories = getCategoriesArray();
?>
<h1>Category listing</h1>


<ul class="productList">
	<?php // looping through the products to display it ?>
	<?php foreach($products as $p) { ?>
	<li>
		<img src="product.png" alt="<?=$p['name']?>">
		<article>
			<h2><?=$p['name']?></h2>
			<h3><?=$categories[$p['category_id']]?></h3>
			<p><?=$p['description']?></p>

			<p class="price">Current bid: £<?=$p['price']?></p>
			<a href="auction.php?id=<?=$p['id']?>" class="more">More &gt;&gt;</a>
		</article>
	</li>
	<?php } ?>
</ul>
<?php include 'footer.php'; ?>