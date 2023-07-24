<?php

    define("HOST", "localhost");
    define("DB_USER", "root");
    define("DB_PASS", "");
    define("DB_DATABASE", "index");

    $db = new mysqli(HOST, DB_USER, DB_PASS, DB_DATABASE);

    if ($db->connect_error !== false):
        $createDatabase = $db->query("CREATE DATABASE IF NOT EXISTS `index`");

        $createTable = $db->query("CREATE TABLE IF NOT EXISTS `products` (
            `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
            `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
            `price` decimal(10,2) COLLATE utf8_unicode_ci NOT NULL
        )ENGINE=InnoDB DEFAULT CHARSET=utf8;");

        $alterTable = $db->prepare(
            "ALTER TABLE `products` ADD `img` varchar(255) NOT NULL") or die("Error: " . $db->error);

        // if ( $alterTable === false ) 
        // {
        //     echo "false " . $db->error;
        // } else 
        // {
        //     echo "true";
        // }

        // if ($createDatabase == true && $createTable == true) 
        // {
        //     echo "DATABASE CREATED & TABLE CREATED";
        // } else { 
        //     echo "not created";
        // };
    else: 
        print ("sql connected error " . $db->error);
    endif;

    // $insertQuery = "INSERT INTO `products` (`id`, `name`, `price`, `img`) VALUES (1, 'Black Shirt', 5.99, './img/b.jpg'), (2, 'Red Shirt', 3.99, './img/r.jpg'), (3, 'White Shirt', 4.99, './img/w.jpg'),
    // (4, 'Green Shirt', 6.99, './img/g.jpg'), (5, 'Orange Shirt', 2.99, './img/o.jpg'), (6, 'Pink Shirt', 7.99, './img/p.jpg'), (7, 'Blue Shirt', 5.99, './img/bl.jpg'), (8, 'Yellow Shirt', 3.99, './img/y.jpg'),
    // (9, 'Grey Shirt', 4.99, './img/gr.jpg'), (10, 'Light Blue Shirt', 6.99, './img/lb.jpg')";

    // $dbInsertQuery = $db->prepare($insertQuery) or die ('INSERTS QUERY ERROR ' . $db->error);

    // if ($dbInsertQuery->execute() === true):
    //     echo "true";
    // else:
    //     echo "false";
    // endif;

    $STRIPE_PUBLIC_KEY = '';
    $STRIPE_SECRET_KEY = '';

?>