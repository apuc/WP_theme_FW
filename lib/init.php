<?php
use lib\App;

include ROOT_DIR . DOP_DIR . "/config/Config.php";

require_once ROOT_DIR . DOP_DIR ."/assets/AssetsConfig.php";
require_once ROOT_DIR . DOP_DIR ."/assets/AppAssets.php";

require_once "Include_file.php";
require_once "Parser.php";
require_once "Routing.php";
require_once "CRUD.php";

include "App.php";
$app = new App();

require_once "Controller.php";
require_once "Widget.php";
require_once "Db.php";
require_once "Model.php";

$app->include_file->addHelpers();

$app->include_file->addModels();
$app->include_file->addWidgets();
