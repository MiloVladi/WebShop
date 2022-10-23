<?php

ini_set("display_errors", 1);

include "controller/ShopController.php";
include "services/Database.php";
include "services/Session.php";
include "models/pdoDBGateway.php";
include "models/productTypesModel.php";
include "models/productsModel.php";
include "models/cartModel.php";
include "views/JsonView.php";

define("DBHost", "localhost");
define("DBName", "products_bb");
define("DBPassword", "");
define("DBUsername", "root");
define('APP_URL', 'http://localhost/fh/MILOSAVLJEVIC_FE_Uebung5/');