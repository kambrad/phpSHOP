<?php 

    require_once "./config.php";

    session_status() !== PHP_SESSION_ACTIVE ? session_start() : print (session_status());

    error_reporting(E_ERROR | E_PARSE);

    // fetch total number of rows inside db table
    $fetchRow = $db->prepare("SELECT COUNT(*) as rowNum FROM `products`");
    $totalRows;

    if ($fetchRow->execute() == true) {
        $totalRows = $fetchRow->get_result()->fetch_assoc()['rowNum'];
    }

    // fetch products from db

    $products = $db->prepare("SELECT * FROM `products` ORDER BY `id` ASC LIMIT 6");
    $products->execute();
    $productsResult = $products->get_result();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <title>Shop</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Merriweather:ital,wght@0,300;0,400;0,700;0,900;1,300;1,400;1,700;1,900&display=swap');

        *{
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Urbanist', sans-serif;
        }
        
        body 
        {
            overflow-x: hidden;
        }

        nav 
        {
            position: relative;
            width: 100%;
            top: 0;
            left: 0;
            background-color: white;
            display: flex;
            color: black;
            align-items: center;
            justify-content: space-around;
            height: 10vh;
            box-shadow: 0px 3px 15px rgba(0,0,0,0.2);
        }

        nav .nav-logo h1 
        {
            font-size: 55px;
        }

        nav .nav-links ul 
        {
            display: flex;
            list-style: none;
        }

        nav .nav-links 
        {
            transform: translate(-25%, 0);
        }

        nav .nav-links ul li{
            margin: 0 10px;
        }

        nav .nav-links ul li a 
        {
            color: black;
            text-decoration: none;
            text-transform: uppercase;
            font-size: 14px;
            font-weight: bold;
        }

        nav .nav-contact 
        {
            display: flex;
            align-items: center;
            gap: 15px;
            position: relative;
            /* border: 1px solid red; */
            width: 5%;
        }
        nav .nav-contact img
        {
            cursor: pointer;
            width: 28px;
        }

        nav .nav-contact span 
        {
            position: absolute;
            top: 0;
            right: 0;
            font-size: 12px;
            color: red;
        }

        #carousel 
        {
            margin: 20px auto;
            width: 1000px;
            height: 80vh;
            overflow: hidden;
        }
        #carousel .slideshow 
        {
            display: flex;
            gap: 10px;
            transition: all 650ms ease;
        }
        #carousel .slideshow img  
        {
            /* width: 60vw; */
            /* transform: translateX(-2 * 100vw); */
            width: 1000px;
            height: 80vh;
            object-fit: cover;
        }

        #products
        {
            margin: 30px auto;
            width: 1300px;
            border-top: 1px solid lightgrey;
            height: 100vh;
        }
        #products h1 
        {
            text-transform: uppercase;
            font-size: 50px;
            margin: 40px 0px;
        }
        #products .container 
        {
            margin: auto;
            width: 100%;
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 60px;
            justify-content: center;
        }
        #products .container .product 
        {
            border: 1px solid lightgrey;
            padding: 50px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: space-evenly;
            position: relative;
            cursor: pointer;
            overflow: hidden;
            height: 40vh;
        }
        #products .container .product img 
        {
            width: 100%;
            object-fit: contain;
        }
        #products .container .product h1 
        {
            font-size: 20px;
        }
        #products .container .product h2
        {
            font: 20px lighter;
            text-transform: uppercase;
            position: relative;
            transform: translate(0, -20px);
        }
        #products .container .product span
        {
            position: absolute;
            background-color: black;
            color: white;
            top: 0;
            left: 0;
            width: 100%;
            height: 60vh;
            opacity: 0.6;
            display: flex;
            align-items: center;
            justify-content: center;
            text-transform: uppercase;
            font-weight: 600;
            visibility: hidden;
            transition: all 150ms ease;
        }
    
        #products .container .product span h1
        {
            transform: translate(0, -130px) rotate(-50deg);
        }

        #products .products_header 
        {
            /* border: 1px solid red; */
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin: auto;
            width: 1100px;
        }
        #products .products_header .filter 
        {
            display: flex;
            gap: 20px;
        }
        #products .products_header .filter input 
        {
            padding: 8px;
            border: none;
            border-bottom: 1px solid lightgrey;
        }
        #products .products_header .filter input:focus
        {
            outline: none;
        }
        #products .products_header .filter select
        {
            padding: 10px;
            /* border-bottom: 1px solid lightgrey; */
            border: 1px solid black;
            cursor: pointer;
        }

        #counter 
        {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: space-evenly;
            margin-left: 20px;
            transform: translate(-15%, -10%);
            height: 5vh;
        }

        #counter p 
        {
            font-size: 12px;
            margin-left: 50px;
            width: 100%;
            position: relative;
            /* margin-left: auto; */
        }

        #counter a
        {
            cursor: pointer;
            font-size: 12px;
            color: blue;
        }

        #counter .number 
        {
            display: flex;
            width: 100%;
            justify-content: center;
            gap: 10px;
        }
    
    </style>
</head>
<body>
    <nav>
        <div class="nav-logo">
            <h1>Kam.</h1>
        </div>

        <div class="nav-links">
            <ul>
                <li class="active"><a href="index.php">Home</a></li>
                <li><a href="">Shop</a></li>
                <li><a href="">Contact</a></li>
            </ul>
        </div>

        <div class="nav-contact">
            <img src="https://img.icons8.com/windows/32/null/user.png"/>
            <img src="https://img.icons8.com/fluency-systems-regular/32/null/shopping-bag--v1.png"/>
            <span>0</span>
        </div>
    </nav>

    <section id="carousel">
        <div class="slideshow">
            <img src="./img/image1.jpg" alt="image one">
            <img src="./img/image2.jpg" alt="image two">
            <img src="./img/image3.jpg" alt="image three">
        </div>
    </section>

    <section id="products">
        <div class="products_header">
            <h1>Shop</h1>
            <div class="filter">
                <input type="text" placeholder="Search product...">
                <select>
                    <option selected hidden>Color</option>
                    <option value="Black">Black</option>
                    <option value="Red">Red</option>
                    <option value="White">White</option>
                    <option value="Blue">Blue</option>
                    <option value="Orange">Orange</option>
                    <option value="Yellow">Yellow</option>
                </select>
            </div>
        </div>
        <div class="container">
            <?php 
                while ($row = $productsResult->fetch_assoc()):
                    echo "
                    <div class='product'>
                        <img src='$row[img]' alt='product image' id='img'>
                        <h1>$row[name]</h1>
                        <h2>$$row[price]</h2>
                        <span>
                            <h1>View Product</h1>
                        </span>
                    </div>
                    ";
                endwhile;
            ?>


                <?php 
                    // target link
                    $fetchLink = 'fetchLinks';

                    // total num of rows
                    $totalRows = (int) $totalRows;

                    // current page
                    $currentPage = 0;

                    // per page
                    $perPage = 6;

                    // num links
                    $numLinks = 3;

                    // show count
                    $showCount = true;

                    function createLinks()
                    {
                        global $totalRows, $currentPage, $perPage, $showCount, $numLinks;

                        /**  if total rows & per page equal 0 
                         * @return null
                        */

                        if ($totalRows == 0 || $perPage == 0){
                            return;
                        }

                        $numPages = ceil($totalRows / $perPage);

                        if ($numPages == 1) {
                            if ($showCount) 
                            {
                                $info = "<p>Showing " . $totalRows . "</p>";
                                return $info;
                            } else 
                            {
                                return '';
                            }
                        }

                        if (!is_numeric($currentPage))
                        {
                            $currentPage = (int) $currentPage;
                        }

                        $output = "<div id='counter'>";

                        if ($showCount) 
                        {
                            $currentOffset = $currentPage;
                            $info = "<p>Showing " .  ($currentOffset + 1) . " to ";

                            if (($currentOffset + $perPage) < $totalRows) 
                                $info .= ($currentOffset + $perPage);
                            else 
                                $info .= $totalRows;
                            
                            $info .= " of " . $totalRows . " </p>
                            <div class='number'>";
                            
                            $output .= $info;
                        }

                        if ($currentPage > $totalRows){
                            $currentPage = ($numPages - 1) * $perPage;
                        }


                        // current page & per page
                        $start = (($currentPage - $numLinks) > 0) ? $currentPage - ($numLinks - 1) : 1;
                        $end = (($currentPage + $numLinks ) < $numPages) ? $currentPage + $numLinks : $numPages;
                        
                        for ($loop = $start - 1; $loop <= $end; $loop++){
                            $i = ($loop * $perPage) - $perPage;
                            if ($i >= 0)
                            {
                                if ($currentPage == $loop) 
                                {
                                    $output .= '&nbsp;<b>' . $loop . '</b></div></div>';
                                } else 
                                {
                                    $n = ($i == 0) ? '' : $i;
                                    $output .= '&nbsp;' . getLink($n, $loop) . '';
                                }
                            }
                        }
                        return $output;
                    }

                    function getLink($count, $text) 
                    {
                        global $fetchLink;

                        $onClick = '';

                        if (!empty($fetchLink)) 
                        {
                            $onClick .= "onclick=".$fetchLink."(". $count . ")";
                        }

                        return "<a class='page'" . $onClick . ">".$text."</a>
                        "; 
                    } 

                    echo createLinks();


                ?>
        </div>
    </section>
    
</body>

<script type="text/javascript">
    const { log } = console;

    const slideShow = document.getElementsByClassName("slideshow");
    const slideShowImg = slideShow[0].children;

    const product = document.getElementsByClassName("product");


    let slideCount = -1;
    setInterval(() => {
        slideCount = (slideCount + 1);

        slideCount >= 3 ? slideCount = -1 : undefined;

        switch (slideCount)
        {
            case 0:
                // slideShow[0].style.transform = `translateX(${slideCount === 0 ? (-slideCount * 1010 + 'px') : (-0 * 1010)}px)`;
                slideShow[0].style.transform = `translateX(${-slideCount * 1010}px)`;
                break;
            case 1:
                // slideShow[0].style.transform = `translateX(${slideCount === 1 ? (-slideCount * 1010 + 'px') : (-1 * 1010)}px)`;
                slideShow[0].style.transform = `translateX(${-slideCount * 1010}px)`;
                break;
            case 2:
                // slideShow[0].style.transform = `translateX(${slideCount === 2 ? (-slideCount * 1010 + 'px') : (-2 * 1010)}px)`;
                slideShow[0].style.transform = `translateX(${-slideCount * 1010}px)`;
                break;
            
        }
}, 2000);

for (let i = 0; i < product.length; i++) 
{
    product[i].addEventListener('mouseenter', (e) => {
        const span = product[i].getElementsByTagName('span')[0];

        span.style.visibility = 'visible';
    })

    product[i].addEventListener('mouseleave', (e) => {
        const span = product[i].getElementsByTagName('span')[0];

        span.style.visibility = 'hidden';
    })
}

</script>
</html>