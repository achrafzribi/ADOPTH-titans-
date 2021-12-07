<?PHP
include 'configg.php';
class productC 

{
	public function inscription($product,$con)
	{       
		 $sql = "INSERT INTO product (product_name,product_categorie,description) values (:product_name, :product_categorie, :description)";
        try {
            $req = $con->prepare($sql);
            $req->bindValue(':product_name', $product->getproduct_name());
            $req->bindValue(':product_categorie', $product->getproduct_categorie());
			$req->bindValue(':description', $product->getdescription());
            $req->execute();
        } catch (Exception $e) {
            echo 'erreur: ' . $e->getMessage();
        }
	}}

function random_num($length)
{

	$text = "";
	if($length < 5)
	{
		$length = 5;
	}

	$len = rand(4,$length);

	for ($i=0; $i < $len; $i++) { 
		# code...

		$text .= rand(0,9);
	}

	return $text;
}{


function get_all_products()
{
	try {
		$con=config::getConnexion();
        // Create sql statment
        $sql = " select * from products";
        $resultp = $con->query($sql);
		return $resultp;
    } catch (Exception $e) {
        echo "Error " . $e->getMessage();
        exit();
    }
}

function get_single_product()
{
	if(isset($_GET['product_id'])){
		$con=config::getConnexion();
        $product_id = $_GET['product_id'];
        $sql="SELECT * FROM `products` WHERE `product_id` ='$product_id'";
        try{  
			$query=$con->prepare($sql);
			$query->execute();
		}catch (Exception $e){
			die('Erreur: '.$e->getMessage());
		}
		// Get the meeting
		$m = $query->fetch();
		return $m;
	}
}
function get_single_prod($product_id)
{
		$con=config::getConnexion();
        $sql="SELECT * FROM `products` WHERE `product_id` ='$product_id'";
        try{  
			$query=$con->prepare($sql);
			$query->execute();
		}catch (Exception $e){
			die('Erreur: '.$e->getMessage());
		}
		// Get the meeting
		$m = $query->fetch();
		return $m;
}

function feedback ()
{
	if(isset($_GET['send'])){
		$con=config::getConnexion();
		if($_SERVER['REQUEST_METHOD'] == "POST")
		{
			//something was posted
			$product=$_POST['product_id'];
			$rate = $_POST['rate'];
			$message = $_POST['message'];
			if(!empty($product) && !empty($rate) && !empty($message))
			{
				$sql="INSERT INTO `rates`(`rate`, `product`) VALUES ('$rate','$product')";
				$sql2="INSERT INTO `rate_des`(`descrption`, `product`) VALUES ('$message','$product')";
				//save to database
				try{  
					$query=$con->prepare($sql);
					$query->execute();
					$query2=$con->prepare($sql2);
					$query2->execute();
					header("Location:single-product.php?product_id=$product");
				}catch (Exception $e){
					die('Erreur: '.$e->getMessage());
				}
			}
		}	
	}
}

function related_product ($categorie)
{
	try {
		$con=config::getConnexion();
        // Create sql statment
        $sql = " select * from products where `categorie`='$categorie' limit 3";
        $resultp = $con->query($sql);
		return $resultp;
    } catch (Exception $e) {
        echo "Error " . $e->getMessage();
        exit();
    }
}

function get_single_prod_rate ($prod)
{
	try {
		$con=config::getConnexion();
        // Create sql statment
        $sql = "SELECT * FROM `rates` WHERE `product`='$prod' limit 3";
        $resultp = $con->query($sql);
		return $resultp;
    } catch (Exception $e) {
        echo "Error " . $e->getMessage();
        exit();
    }
}

function get_single_prod_message ($prod)
{
	try {
		$con=config::getConnexion();
        // Create sql statment
        $sql = "SELECT * FROM `rate_des` WHERE `product`='$prod' limit 3";
        $resultp = $con->query($sql);
		return $resultp;
    } catch (Exception $e) {
        echo "Error " . $e->getMessage();
        exit();
    }
}

function single_prod_note ($prod)
{
	$resultp=get_single_prod_rate ($prod);
	$n=$resultp->rowCount();
	$final_rate='NAN';
	$s=0;
	if($n>0)
	{
	foreach ($resultp as $sr)
	{
		$s+=$sr['rate'];
	}
	$final_rate=$s/$n;
	}
	return $final_rate;
}

function stock_info ($s)
{
	$sotckinfo='';
    $stockclass='';
    if($s<=0){
    $sotckinfo="Outofstock";
    $stockclass="danger";
	}else{
    $sotckinfo='Instock';
    $stockclass='success';
	}
	echo"<h4><span class='badge badge-$stockclass-lighten'>$sotckinfo</span></h4>";
}

function delete_prod()
{
	if(isset($_GET['delete'])){
	$con=config::getConnexion();
	if(isset($_GET['delete'])){
        $product_id = $_GET['delete'];
        $sql ="DELETE FROM `products` WHERE `product_id` = '$product_id' ";
        try {
			$query=$con->prepare($sql);
			$query->execute();
			header("Location:apps-ecommerce-products.php");
		} catch (Exception $e) {
			echo "Error " . $e->getMessage();
			exit();
		}
}}
}

function add_prod ()
{
	if(isset($_GET['add'])){
	$con=config::getConnexion();
	if($_SERVER['REQUEST_METHOD'] == "POST")
	{
		//something was posted
		$product_name    = trim($_POST['product_name']);
		$photo    = trim($_POST['photo']);
		$categorie = trim($_POST['categorie']);
        $product_description = trim($_POST['product_description']);
        $quantity     = (int) $_POST['quantity'];
        $product_price   = (float) $_POST['product_price'];
		if(!empty($product_name) && !empty($quantity) && !empty($product_price))
		{

			//save to database
            $product_id = random_num(20);
			$sql = "insert into products (product_name,categorie,product_description,quantity,product_price,photo) values ('$product_name','$categorie','$product_description','$quantity','$product_price','$photo')";
			try {
				$query=$con->prepare($sql);
				$query->execute();
				header("Location:apps-ecommerce-products.php");
			} catch (Exception $e) {
				echo "Error " . $e->getMessage();
				exit();
			}
			header("Location: apps-ecommerce-products.php");
			die;
		}
	}
}
}

function update_prod ()
{
	if(isset($_GET['update'])){
	$con=config::getConnexion();
	if($_SERVER['REQUEST_METHOD'] == "POST")
	{
		//something was posted
        $product_id=(int) $_POST['product_id'];
		$product_name    = trim($_POST['product_name']);
		$photo    = trim($_POST['photo']);
		$categorie = trim($_POST['categorie']);
        $product_description = trim($_POST['product_description']);
        $quantity     = (int) $_POST['quantity'];
        $product_price   = (float) $_POST['product_price'];
		if(!empty($product_name) && !empty($quantity) && !empty($product_price))
		{
			//save to database
            $sql= "UPDATE `products` SET `product_name`='$product_name',`categorie`='$categorie',`product_description`='$product_description',`quantity`='$quantity',`photo`='$photo',`product_price`='$product_price' WHERE product_id='$product_id'";
			try {
				$query=$con->prepare($sql);
				$query->execute();
				header("Location:apps-ecommerce-products.php");
			} catch (Exception $e) {
				echo "Error " . $e->getMessage();
				exit();
			}
			header("Location: apps-ecommerce-products.php");
			die;
		}
	}
}
}

function search_prod()
{
	if(isset($_GET['input'])){
		$con=config::getConnexion();
        $product_name = $_GET['input'];
        $sql="SELECT * FROM `products` WHERE `product_name` ='$product_name'";
        try{  
			$query=$con->prepare($sql);
			$query->execute();
			return $query;
		}catch (Exception $e){
			die('Erreur: '.$e->getMessage());
		}
	}
}

function top_sold ()
{
		$con=config::getConnexion();
        $sql="SELECT * FROM `products` ORDER BY number_of_orders DESC LIMIT 3";
        try{  
			$query=$con->prepare($sql);
			$query->execute();
			return $query;
		}catch (Exception $e){
			die('Erreur: '.$e->getMessage());
		}
}

function stock_notif ()
{
	$resultp=get_all_products();
	foreach ($resultp as $prod) : 
		if ($prod['quantity']<10)
		{
			$con=config::getConnexion();
			$id=$prod['product_id'];
			$sql="INSERT INTO `stock_notif`( `prod`) VALUES ('$id')";
			try{  
				$query=$con->prepare($sql);
				$query->execute();
			}catch (Exception $e){
				die('Erreur: '.$e->getMessage());
			}
		}
	endforeach ;
}

function get_notification ()
{
	try {
		$con=config::getConnexion();
        // Create sql statment
        $sql = "SELECT * FROM `stock_notif`";
        $resultp = $con->query($sql);
		return $resultp;
    } catch (Exception $e) {
        echo "Error " . $e->getMessage();
        exit();
    }
}

function delete_notif ()
{
	if(isset($_GET['deletenotif'])){
		$con=config::getConnexion();
        $sql="DELETE FROM `stock_notif` WHERE 1";
        try{  
			$query=$con->prepare($sql);
			$query->execute();
			header("Location: apps-ecommerce-products.php");
		}catch (Exception $e){
			die('Erreur: '.$e->getMessage());
		}
	}
}
////////////////////////////////////////
}
