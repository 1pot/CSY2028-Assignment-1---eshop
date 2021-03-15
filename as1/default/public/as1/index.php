<?php 
include 'header.php';
$products = getLastAuctions(10);
$categories = getCategoriesArray();
/// Search Results / Category listing
?>
<h1>Latest Listings</h1>


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
<!--
<hr />
<h1>Sample Form</h1>

<form action="#">
	<label>Text box</label> <input type="text" />
	<label>Another Text box</label> <input type="text" />
	<input type="checkbox" /> <label>Checkbox</label>
	<input type="radio" /> <label>Radio</label>
	<input type="submit" value="Submit" />

</form>
-->
<?php include 'footer.php'; ?>