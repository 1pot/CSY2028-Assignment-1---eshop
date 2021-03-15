<?php
// get all the categories from database
// return array of categories
function getCategories() {
	global $db;
	$stmt = $db->prepare('SELECT * FROM categories');  
	$stmt->execute();
	return $stmt->fetchALL(PDO::FETCH_ASSOC);
}

// get all the categories and return an array[category_id] = category_name
function getCategoriesArray() {
	$arr = [];
	foreach(getCategories() as $cat) {
		$arr[$cat['id']] = $cat['name'];
	}
	return $arr;
}

// get all auctions
// if user_id passed get only the auctions of this user
function getAuctions($user_id=0) {
	global $db;
	$user_part = (!empty($user_id)) ? " Where user_id = :user_id" : "";
	$stmt = $db->prepare('SELECT * FROM products'.$user_part);
	if(!empty($user_id)) {
		$data = ['user_id'=>$user_id];
	}  else {
		$data = [];
	}
	$stmt->execute($data);
	return $stmt->fetchALL(PDO::FETCH_ASSOC);
}

// get the username of specific user id
function getUserNameById($user_id) {
	global $db;
	$stmt = $db->prepare('SELECT username FROM users Where id = :id');  
	$stmt->execute(['id'=>$user_id]);
	$row = $stmt->fetch(PDO::FETCH_ASSOC);
	return $row['username'];
}

// get the last auctions
// can limit the number of the auctions by passing limit
// can filter the auctions by a category
function getLastAuctions($limit, $catid=0) {
	global $db;
	$where = empty($catid)?"":" Where category_id = :catid";
	$stmt = $db->prepare('SELECT * FROM products '.$where.' order by id desc limit '.$limit);
	$data = empty($catid)?[]:['catid'=>$catid];
	$stmt->execute($data);
	return $stmt->fetchALL(PDO::FETCH_ASSOC);
}

// get all the reviews of specific product
function getProductReviews($product_id) {
	global $db;
	$stmt = $db->prepare('SELECT * FROM reviews Where product_id = :product_id');  
	$stmt->execute(['product_id'=>$product_id]);
	return $stmt->fetchALL(PDO::FETCH_ASSOC);
}

// insert a new review to database
function insertReview($data) {
	global $db;
	$dbdata = [
		'review'=>$data['reviewtext'],
		'date'=>date('Y-m-d'),
		'user_id'=>$_SESSION['userid'],
		'product_id'=>$data['product_id'],
	];
	
	$stmt = $db->prepare('Insert into reviews 
			values(NULL, :review, :date, :user_id, :product_id)');  
	$stmt->execute($dbdata);
}