<?php
require 'lib/Domain.php';
require 'lib/simple_html_dom.php';
require 'lib/controller.php';
require 'app/controllers/application_controller.php';
require 'app/controllers/home_controller.php';
require 'lib/exceptions.php';
require 'lib/geoip/geoip.inc';


set_time_limit(0);

ini_set('user_agent', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US) AppleWebKit/525.13 (KHTML, like Gecko) Chrome/0.A.B.C Safari/525.13');

define('PHP_ROOT', dirname(__FILE__));

$site_path = str_replace( '\\', '/', dirname( $_SERVER['PHP_SELF'] ) );
if (iconv_strlen( $site_path ) == 1)
    $site_path = '';

$route = preg_replace( '#^' . $site_path . '/#', '', $_SERVER['REQUEST_URI'] );

$site_path = 'http' . (isset( $_SERVER['HTTPS'] ) ? 's' : '') . '://' . $_SERVER['HTTP_HOST'] . $site_path;

define( 'SITE_PATH', $site_path );

header('Content-type: text/html; charset=windows-1251');
$controller_name = strtolower($_REQUEST['controller']);

if (!isset($_REQUEST['action']) || empty($_REQUEST['action']))
    $action_name = 'index';
else
    $action_name = strtolower($_REQUEST['action']);

$controller_class = $controller_name . 'Controller';

ob_start();

$controller_path = "app/controllers/{$controller_name}_controller.php";
if (file_exists($controller_path))
    require $controller_path;


if (class_exists( $controller_class )) {
    if (!method_exists( $controller_class, $action_name ))
        $action_name = 'index';
}
else {
    $controller_name = 'home';
    $action_name = 'index';
    $controller_class = $controller_name . 'Controller';
}

$controller = new $controller_class( $controller_name );
$controller->$action_name();


$ob = ob_get_clean();
?>

<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
        <link href="public/stylesheets/style.css" type="text/css" rel="stylesheet" />
        <script type="text/javascript" src="public/javascripts/jquery-1.6.2.min.js"></script>
    </head>
    <body>
        <div id=container>
            <div id=header>
                <div id=header_content>
                    <a href="index.php" id=site_logo>
                        <span>Domain informer</span>
                    </a>
                    <ul id=account_box>
                        <li <?=$controller_name == 'home' ? 'class=selected' : ''?>><a href="index.php">Home</a></li>
                        <li <?=$controller_name == 'domain' ? 'class=selected' : ''?>><a href="?controller=domain">Domain Info</a></li>
                    </ul>
                </div>
            </div>
            <div id=main>
                <div id=page_content>
                    <?=$ob?>
                </div>
            </div>
            <div id=footer>
                <div id=footer_content>
                    <ul id=nav_bottom>
                        <li>
                            <a href="#">About</a>
                            <p>Comming soon</p>
                        </li>
                    </ul>
                    <p class=copyright>
                        copyright @2011
                    </p>
                    <ul class=site_links>
                        <li><a href="index.php">Home</a></li>
                        <li><a href="?controller=domain">Domain Info</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </body>
</html>
 
