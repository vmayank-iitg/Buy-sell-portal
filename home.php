<!doctype html>
<html lang="en">
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <title>Home</title>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
    <div class="navbar-brand" >IITGbazaar</div>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse " id="navbarSupportedContent">
        
        <ul class="navbar-nav mb-2 mb-lg-0 container-fluid">
        
        
        <?php 
            echo "<div class=\"mx-auto\">";
            if(isset($_COOKIE['userName']))
                echo $_COOKIE['userName'];
            else
                echo "<strong>HOME</strong>";
            echo "</div>";
        ?>
        
        <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
        </a>
        <?php 
            if(isset($_COOKIE['userName']))
                echo "<ul class=\"dropdown-menu dropdown-menu-end\" aria-labelledby=\"navbarDropdown\">
                <li><a class=\"dropdown-item btn disabled\" href=\"#\">Continue Shopping...</a></li>
                <li><a class=\"dropdown-item\" href=\"cart.php\">Cart</a></li>
                <li><a class=\"dropdown-item\" href=\"buyer_orders.php\">orders</a></li>
                <li><a class=\"dropdown-item \" href=\"buyer_delivered.php\"> delivered orders</a></li>
                <li><a class=\"dropdown-item \" href=\"buyer_view_comp.php\">View Complains</a></li>
                <li><a class=\"dropdown-item\" href=\"buyer_make_comp.php\">Report Issues</a></li>
                <li><a class=\"dropdown-item\" href=\"buyer_signout.php\">sign out</a></li>
            </ul>";
            else {
                echo "
                <ul class=\"dropdown-menu dropdown-menu-end\" aria-labelledby=\"navbarDropdown\">
                    <li><a class=\"dropdown-item\" href=\"signin.php\">Sign in</a></li>
                </ul>
                ";
            }
        ?>
        
        </li>
        
        </ul>
        
    </div>
    </div>
</nav>
    <?php 
        $servername = "localhost"; //Name of the server where database resides, ex: 127.0.0.1
        $port_no = 3306; // Port number for Windows 
        $username = "user";
        $password = "";
        $myDB= "project"; //Name of the database to access
        try {$conn = new PDO("mysql:host=$servername; port= $port_no, dbname=$myDB", $username, $password); //set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } 
        catch(PDOException $e){echo "Connection failed: " . $e->getMessage();}
        $flag=0;
        $query="";
        if(!isset($_COOKIE['userName']))
            $query="SELECT P.* FROM project.product P , project.seller S WHERE S.sellerid=P.sellerid and S.subid=\"PRE\" and P.status=\"unsold\"";
        else
            $query=$query="SELECT P.* FROM project.product P , project.seller S WHERE S.sellerid=P.sellerid and S.subid=\"PRE\" and P.status=\"unsold\" and P.productid NOT IN (SELECT productid from project.cart where buyerid='{$_COOKIE['userName']}')";
        $sql=$conn->prepare($query);
        $sql->execute();
        echo "<div class=\"container-md mt-5 \">";
            if($sql->rowCount())
            {   
                $r=$sql->fetchAll(PDO::FETCH_ASSOC);
                foreach($r as $item)
                {
                    echo "<div class='shadow-sm p-3 mb-5 bg-body rounded'>
                        <section>Name : {$item['name']} </section>
                        <section>Cost : {$item['cost']}</section>
                        <section>Brand : {$item['brand']}</section>
                        <section>Production Year : {$item['prodyear']}</section>
                        <section>Category : {$item['category']}</section>";
                    if(!($item['image1']==="NA" && $item['image2']==="NA" && $item['image3']==="NA"))
                    {
                        echo "<div class=\"container\">";
                        if($item['image1']!=="NA")
                        echo "<img src=\"{$item['image1']}\" height=\"200px\" width=\"200px\" class='me-2 mt-2'>";
                        if($item['image2']!=="NA")
                        echo "<img src=\"{$item['image2']}\" height=\"200px\" width=\"200px\" class='me-2 mt-2'>";
                        if($item['image3']!=="NA")
                        echo "<img src=\"{$item['image3']}\" height=\"200px\" width=\"200px\" class='me-2 mt-2'>";
                        echo  "</div>";
                    }
                    if(isset($_COOKIE['userName']))
                    echo "<form method='post' action='add_to_cart.php'>
                            <input type=\"hidden\" name=\"id\" value='{$item['productid']}'/>
                            <input type='submit' name='submit' class='btn btn-primary btn-lg btn-block mt-2' value='add to cart'/>
                        </form>";
                    echo   "</div>";
                }
            }
            
        echo "</div>";
        if(!isset($_COOKIE['userName']))
            $query="SELECT P.* FROM project.product P , project.seller S WHERE S.sellerid=P.sellerid and S.subid=\"BA\" and P.status=\"unsold\"";
        else
            $query=$query="SELECT P.* FROM project.product P , project.seller S WHERE S.sellerid=P.sellerid and S.subid=\"BA\" and P.status=\"unsold\" and P.productid NOT IN (SELECT productid from project.cart where buyerid='{$_COOKIE['userName']}')";
        $sql=$conn->prepare($query);
        $sql->execute();
        echo "<div class=\"container-md mt-5 \">";
            if($sql->rowCount())
            {   
                $r=$sql->fetchAll(PDO::FETCH_ASSOC);
                foreach($r as $item)
                {
                    echo "<div class='shadow-sm p-3 mb-5 bg-body rounded'>
                        <section>Name : {$item['name']} </section>
                        <section>Cost : {$item['cost']}</section>
                        <section>Brand : {$item['brand']}</section>
                        <section>Production Year : {$item['prodyear']}</section>
                        <section>Category : {$item['category']}</section>";
                    if(!($item['image1']==="NA" && $item['image2']==="NA" && $item['image3']==="NA"))
                    {
                        echo "<div class=\"container\">";
                        if($item['image1']!=="NA")
                        echo "<img src=\"{$item['image1']}\" height=\"200px\" width=\"200px\" class='me-2 mt-2'>";
                        if($item['image2']!=="NA")
                        echo "<img src=\"{$item['image2']}\" height=\"200px\" width=\"200px\" class='me-2 mt-2'>";
                        if($item['image3']!=="NA")
                        echo "<img src=\"{$item['image3']}\" height=\"200px\" width=\"200px\" class='me-2 mt-2'>";
                        echo  "</div>";
                    }
                    if(isset($_COOKIE['userName']))
                    echo "<form method='post' action='add_to_cart.php'>
                            <input type=\"hidden\" name=\"id\" value='{$item['productid']}'/>
                            <input type='submit' name='submit' class='btn btn-primary btn-lg btn-block mt-2' value='add to cart'/>
                        </form>";
                    echo   "</div>";
                }
            }
            
        echo "</div>";
    ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    
</body>
</html>