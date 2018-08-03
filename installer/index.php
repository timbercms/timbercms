<?php

    if (file_exists(__DIR__ ."/../core/installer.lock"))
    {
        header('Location: ../index.php');
    }

    session_start();
    ini_set("display_errors", "1");
    error_reporting(E_ALL & ~E_NOTICE);
    $version = simplexml_load_file(__DIR__ ."/../admin/version.xml");
    if (file_exists(__DIR__ ."/../configuration.php"))
    {
        require_once(__DIR__ ."/../configuration.php");
    }
    require_once(__DIR__ ."/../core/classes/database.php");
    $db = new Database();

?>
<!DOCTYPE html>
<html>
    <head>
        <title>Bulletin. Installer</title>
        <link rel="stylesheet" type="text/css" href="../templates/default/css/bootstrap.min.css" />
        <link rel="stylesheet" type="text/css" href="installer.css" />
    </head>
    <body>
        <div class="header-container">
            <span class="title">Bulletin. Installer</span><span class="subtitle">v<?php echo $version->numerical; ?></span>
        </div>
        <div class="body-container">
            <?php if ($_GET["stage"] == 0 || strlen($_GET["stage"]) == 0) { ?>
                <h1>Database Connection</h1>
                <?php if ($_GET["error"] == 1) { ?>
                    <div class="alert alert-danger" style="margin-bottom: 40px;">
                        Failed to establish a connection to the database. Please check your settings and try again.
                    </div>
                <?php } ?>
                <form action="index.php?stage=1" method="post">
                    <h3>Website Information</h3>
                    <div class="form-group">
                        <label class="col-form-label"><strong>Website URL</strong></label>
                        <p>You must include a trailing slash (https://www.website.com/). <strong>This has been prefilled for you, make sure it is correct before moving on to the next stage.</strong></p>
                        <input type="text" name="base_url" class="form-control" required placeholder="Your website address, with trailing slash. (https://www.website.com/)" value="<?php echo $_SERVER["REQUEST_SCHEME"]; ?>://<?php echo $_SERVER["SERVER_NAME"]; ?>/" />
                    </div>
                    <div class="form-group">
                        <label class="col-form-label"><strong>Subfolder</strong></label>
                        <p><span style="color: #FF0000;">You may leave this field blank if required</span></p>
                        <p>If your website is in a subfolder, for example https://www.website.com/cms, enter the subfolder as /cms/.</p>
                        <input type="text" name="subfolder" class="form-control" placeholder="Your website subfolder. If none, leave blank." value="<?php echo str_replace("installer/", "", $_SERVER["REQUEST_URI"]); ?>" />
                    </div>
                    <div class="form-group">
                        <label class="col-form-label"><strong>Cookie Domain</strong></label>
                        <p>Usually you can leave this as "/", however, <strong>if you know what you're doing you can change this</strong>.</p>
                        <input type="text" name="cookie_domain" class="form-control" value="/" />
                    </div>
                    
                    <h3>Database Information</h3>
                    <div class="form-group">
                        <label class="col-form-label"><strong>Database Host</strong></label>
                        <input type="text" name="db_host" value="localhost" class="form-control" required />
                    </div>
                    <div class="form-group">
                        <label class="col-form-label"><strong>Database Name</strong></label>
                        <input type="text" name="db_name" value="" class="form-control" required placeholder="Your database name" />
                    </div>
                    <div class="form-group">
                        <label class="col-form-label"><strong>Database Username</strong></label>
                        <input type="text" name="db_username" value="" class="form-control" required placeholder="Your database username" />
                    </div>
                    <div class="form-group">
                        <label class="col-form-label"><strong>Database Password</strong></label>
                        <input type="password" name="db_password" value="" class="form-control" placeholder="Your database password" />
                    </div>
                    <div class="form-group">
                        <label class="col-form-label"><strong>Database Prefix</strong></label>
                        <input type="text" name="db_prefix" value="bul_" class="form-control" required placeholder="bul_" />
                    </div>
                    <button type="submit" class="btn btn-primary float-right">Next Stage ></button>
                    <div class="clearfix"></div>
                </form>
            <?php } else if ($_GET["stage"] == 1) { ?>
                <?php
                    if ($db->connect($_POST["db_host"], $_POST["db_name"], $_POST["db_username"], $_POST["db_password"]))
                    {
                        $baseurl = $_POST["base_url"];
                        $subfolder = $_POST["subfolder"];
                        $prefix = $_POST["db_prefix"];
                        if (substr($baseurl, -1) != "/")
                        {
                            $baseurl = $baseurl."/";
                        }
                        if (substr($prefix, -1) != "_")
                        {
                            $prefix = $prefix."_";
                        }
                        if (strlen($subfolder) > 0)
                        {
                            if (substr($subfolder, -1) != "/")
                            {
                                $subfolder = $subfolder."/";
                            }
                            if (substr($subfolder, 0, 1) != "/")
                            {
                                $subfolder = "/".$subfolder;
                            }
                        }
                        else
                        {
                            $subfolder = "/";
                        }
                        $config_string = '<?php
                        
    define("DATABASE_HOST", "'. $_POST["db_host"] .'");
    define("DATABASE_USER", "'. $_POST["db_username"] .'");
    define("DATABASE_PASSWORD", "'. $_POST["db_password"] .'");
    define("DATABASE_NAME", "'. $_POST["db_name"] .'");
    define("DATABASE_PREFIX", "'. $prefix .'_");
    define("BASE_URL", "'. $baseurl.($subfolder != "/" ? ltrim($subfolder, "/") : "") .'");
    define("SUBFOLDER", "'. $subfolder .'");
    define("LAUNCH_TIME", "'. time() .'");
    define("COOKIE_DOMAIN", "'. $_POST["cookie_domain"] .'");

?>';

                        $file = fopen(__DIR__ ."/../configuration.php", "w");
                        fwrite($file, $config_string);
                        fclose($file);
                        
                        $htaccess = 'Options +FollowSymLinks
RewriteEngine On

RewriteCond %{SERVER_PORT} 80
RewriteRule ^(.*)$ '. $baseurl.($subfolder != "/" ? ltrim($subfolder, "/") : "") .'$1 [R,L]
 
RewriteCond %{SCRIPT_FILENAME} !-d
RewriteCond %{SCRIPT_FILENAME} !-f
 
RewriteRule ^.*$ ./index.php

RedirectMatch 404 ^404.php';
                        
                        $file = fopen(__DIR__ ."/../.htaccess", "w");
                        fwrite($file, $htaccess);
                        fclose($file);
                        header("Location: index.php?stage=2");
                    }
                    else
                    {
                        header("Location: index.php?stage=0&error=1");
                    }
                ?>
            <?php } else if ($_GET["stage"] == 2) { ?>
                <h1>Administrator account</h1>
                <?php if ($_GET["error"] == 1) { ?>
                    <div class="alert alert-danger" style="margin-bottom: 40px;">
                        The two passwords did not match. Please check your settings and try again.
                    </div>
                <?php } else { ?>
                    <form action="index.php?stage=3" method="post">
                        <h3>Website Identity</h3>
                        <div class="form-group">
                            <label class="col-form-label"><strong>Website Name</strong></label>
                            <input type="text" name="site_name" class="form-control" required placeholder="My First Website" />
                        </div>
                        <h3>Your Information</h3>
                        <div class="form-group">
                            <label class="col-form-label"><strong>Username</strong></label>
                            <input type="text" name="username" class="form-control" required placeholder="Enter your username" />
                        </div>
                        <div class="form-group">
                            <label class="col-form-label"><strong>Password</strong></label>
                            <input type="password" name="password" class="form-control" required placeholder="Enter your password" />
                        </div>
                        <div class="form-group">
                            <label class="col-form-label"><strong>Password (again)</strong></label>
                            <input type="password" name="password_again" class="form-control" required placeholder="Enter your password again" />
                        </div>
                        <div class="form-group">
                            <label class="col-form-label"><strong>Email Address</strong></label>
                            <input type="text" name="email" class="form-control" required placeholder="Enter your email address" />
                        </div>
                        <button type="submit" class="btn btn-primary float-right">Install! ></button>
                        <div class="clearfix"></div>
                    </form>
                <?php } ?>
            <?php } else if ($_GET["stage"] == 3) { ?>
                <?php
    
                    if ($_POST["password"] != $_POST["password_again"])
                    {
                        header("Location: index.php?stage=2&error=1");
                    }
    
                    $db->query("CREATE TABLE `#__articles` (
                         `id` int(11) NOT NULL AUTO_INCREMENT,
                         `title` varchar(500) DEFAULT NULL,
                         `alias` varchar(500) NOT NULL,
                         `category_id` int(11) NOT NULL DEFAULT '0',
                         `content` text,
                         `published` int(11) NOT NULL DEFAULT '1',
                         `publish_time` int(11) DEFAULT NULL,
                         `author_id` int(11) DEFAULT NULL,
                         `hits` int(11) DEFAULT NULL,
                         `meta_description` varchar(500) DEFAULT NULL,
                         `image` varchar(1000) DEFAULT NULL,
                         PRIMARY KEY (`id`)
                        )");
                    $db->query("CREATE TABLE `#__articles_comments` (
                         `id` int(11) NOT NULL AUTO_INCREMENT,
                         `article_id` int(11) NOT NULL,
                         `content` text NOT NULL,
                         `published` int(11) NOT NULL,
                         `publish_time` int(11) NOT NULL,
                         `author_id` int(11) NOT NULL,
                         PRIMARY KEY (`id`)
                        )");
                    $db->query("CREATE TABLE `#__articles_categories` (
                         `id` int(11) NOT NULL AUTO_INCREMENT,
                         `title` varchar(500) DEFAULT NULL,
                         `alias` varchar(500) NOT NULL,
                         `description` text,
                         `published` int(11) DEFAULT '1',
                         `params` text,
                         PRIMARY KEY (`id`)
                        )");
                    $db->query("CREATE TABLE `#__components` (
                         `id` int(11) NOT NULL AUTO_INCREMENT,
                         `title` varchar(255) DEFAULT NULL,
                         `description` varchar(5000) DEFAULT NULL,
                         `internal_name` varchar(255) DEFAULT NULL,
                         `is_frontend` int(11) NOT NULL DEFAULT '0',
                         `is_backend` int(11) NOT NULL DEFAULT '0',
                         `is_locked` int(11) DEFAULT '0',
                         `is_core` int(11) DEFAULT '0',
                         `author_name` varchar(500) DEFAULT NULL,
                         `author_url` varchar(2000) DEFAULT NULL,
                         `version` varchar(255) DEFAULT '1.0.0',
                         `params` text,
                         `enabled` int(11) DEFAULT '1',
                         PRIMARY KEY (`id`)
                        )");
                    $db->query("CREATE TABLE `#__components_modules` (
                         `id` int(11) NOT NULL AUTO_INCREMENT,
                         `title` varchar(255) DEFAULT NULL,
                         `description` varchar(5000) DEFAULT NULL,
                         `internal_name` varchar(255) DEFAULT NULL,
                         `author_name` varchar(500) DEFAULT NULL,
                         `author_url` varchar(2000) DEFAULT NULL,
                         `version` varchar(255) DEFAULT '1.0.0',
                         PRIMARY KEY (`id`)
                        )");
                    $db->query("CREATE TABLE `#__components_hooks` (
                         `id` int(11) NOT NULL AUTO_INCREMENT,
                         `title` varchar(255) DEFAULT NULL,
                         `description` varchar(5000) DEFAULT NULL,
                         `component_name` varchar(255) DEFAULT NULL,
                         `author_name` varchar(500) DEFAULT NULL,
                         `author_url` varchar(2000) DEFAULT NULL,
                         `version` varchar(255) DEFAULT '1.0.0',
                         `enabled` int(11) DEFAULT '1',
                         PRIMARY KEY (`id`)
                        )");
                    $db->query("CREATE TABLE `#__enquiries` (
                         `id` int(11) NOT NULL AUTO_INCREMENT,
                         `name` varchar(255) DEFAULT NULL,
                         `email` varchar(255) DEFAULT NULL,
                         `content` text,
                         `sent_time` int(11) DEFAULT NULL,
                         PRIMARY KEY (`id`)
                        )");
                    $db->query("CREATE TABLE `#__menus` (
                         `id` int(11) NOT NULL AUTO_INCREMENT,
                         `title` varchar(500) DEFAULT NULL,
                         PRIMARY KEY (`id`)
                        )");
                    $db->query("CREATE TABLE `#__menus_items` (
                         `id` int(11) NOT NULL AUTO_INCREMENT,
                         `menu_id` int(11) NOT NULL,
                         `parent_id` int(11) NOT NULL DEFAULT '0',
                         `title` varchar(500) DEFAULT NULL,
                         `alias` varchar(500) DEFAULT NULL,
                         `published` int(11) DEFAULT NULL,
                         `access_group` int(11) DEFAULT NULL,
                         `component` varchar(255) DEFAULT NULL,
                         `controller` varchar(255) DEFAULT NULL,
                         `content_id` varchar(255) DEFAULT NULL,
                         `params` text,
                         `is_home` int(11) DEFAULT '0',
                         `ordering` varchar(255) DEFAULT '0',
                         PRIMARY KEY (`id`)
                        )");
                    $db->query("CREATE TABLE `#__modules` (
                         `id` int(11) NOT NULL AUTO_INCREMENT,
                         `title` varchar(255) DEFAULT NULL,
                         `type` varchar(255) DEFAULT NULL,
                         `show_title` int(11) DEFAULT NULL,
                         `published` int(11) DEFAULT NULL,
                         `position` varchar(255) DEFAULT NULL,
                         `params` varchar(10000) DEFAULT NULL,
                         `pages` varchar(255) DEFAULT NULL,
                         `ordering` varchar(255) DEFAULT '0',
                         PRIMARY KEY (`id`)
                        )");
                    $db->query("CREATE TABLE `#__sessions` (
                         `id` int(11) NOT NULL AUTO_INCREMENT,
                         `php_session_id` varchar(255) DEFAULT NULL,
                         `user_id` int(11) DEFAULT NULL,
                         `last_action_time` int(11) DEFAULT NULL,
                         PRIMARY KEY (`id`)
                        )");
                    $db->query("CREATE TABLE `#__usergroups` (
                         `id` int(11) NOT NULL AUTO_INCREMENT,
                         `title` varchar(255) DEFAULT NULL,
                         `is_admin` int(11) DEFAULT '0',
                         PRIMARY KEY (`id`)
                        )");
                    $db->query("CREATE TABLE `#__users` (
                         `id` int(11) NOT NULL AUTO_INCREMENT,
                         `username` varchar(255) DEFAULT NULL,
                         `email` varchar(255) DEFAULT NULL,
                         `usergroup_id` int(11) DEFAULT NULL,
                         `password` varchar(255) DEFAULT NULL,
                         `activated` int(11) DEFAULT '0',
                         `blocked` int(11) DEFAULT '0',
                         `blocked_reason` varchar(500) DEFAULT NULL,
                         `register_time` int(11) DEFAULT NULL,
                         `last_action_time` int(11) DEFAULT NULL,
                         `verify_token` varchar(5000) DEFAULT NULL,
                         `avatar` varchar(255) DEFAULT NULL,
                         `params` text DEFAULT NULL,
                         PRIMARY KEY (`id`)
                        )");
                    $db->query("CREATE TABLE `#__users_recovery` (
                         `id` int(11) NOT NULL AUTO_INCREMENT,
                         `user_id` int(11) DEFAULT NULL,
                         `reset_requested` int(11) DEFAULT NULL,
                         `token` varchar(5000) DEFAULT NULL,
                         PRIMARY KEY (`id`)
                        )");
    
                    $db->query("INSERT INTO #__components (title, description, internal_name, is_frontend, is_backend, is_locked, is_core, author_name, author_url, version, params, enabled) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", array("Content", "Article category and detail view. Includes comments via third-party Disqus.", "content", "1", "1", "1", "1", "Chris Smith", "https://github.com/Smith0r", $version->numerical, 'a:1:{s:15:"enable_comments";s:1:"0";}', "1"));
                    $db->query("INSERT INTO #__components (title, description, internal_name, is_frontend, is_backend, is_locked, is_core, author_name, author_url, version, params, enabled) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", array("User", "Provides functions for account management, and profile views.", "user", "1", "1", "1", "1", "Chris Smith", "https://github.com/Smith0r", $version->numerical, '', "1"));
                    $db->query("INSERT INTO #__components (title, description, internal_name, is_frontend, is_backend, is_locked, is_core, author_name, author_url, version, params, enabled) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", array("Settings", "Provides sitewide, and component specific settings.", "settings", "0", "1", "1", "1", "Chris Smith", "https://github.com/Smith0r", $version->numerical, 'a:6:{s:10:"site_title";s:'. strlen($_POST["site_name"]) .':"'. $_POST["site_name"] .'";s:16:"default_template";s:7:"default";s:14:"admin_template";s:7:"default";s:11:"cookie_name";s:15:"bulletin_cookie";s:15:"cookie_duration";s:2:"28";s:17:"default_usergroup";s:1:"1";}', "1"));
                    $db->query("INSERT INTO #__components (title, description, internal_name, is_frontend, is_backend, is_locked, is_core, author_name, author_url, version, params, enabled) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", array("Extensions", "Provides management of extensions.", "extensions", "0", "1", "1", "1", "Chris Smith", "https://github.com/Smith0r", $version->numerical, '', "1"));
                    $db->query("INSERT INTO #__components (title, description, internal_name, is_frontend, is_backend, is_locked, is_core, author_name, author_url, version, params, enabled) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", array("Menu Manager", "Basic Menu Management.", "menu", "0", "1", "1", "1", "Chris Smith", "https://github.com/Smith0r", $version->numerical, '', "1"));
                    $db->query("INSERT INTO #__components (title, description, internal_name, is_frontend, is_backend, is_locked, is_core, author_name, author_url, version, params, enabled) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", array("Module Manager", "Basic Module Management.", "modules", "0", "1", "1", "1", "Chris Smith", "https://github.com/Smith0r", $version->numerical, '', "1"));
                    $db->query("INSERT INTO #__components (title, description, internal_name, is_frontend, is_backend, is_locked, is_core, author_name, author_url, version, params, enabled) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", array("Update Manager", "Allow updating of the base CMS.", "update", "0", "1", "1", "1", "Chris Smith", "https://github.com/Smith0r", $version->numerical, '', "1"));
                    $db->query("INSERT INTO #__components (title, description, internal_name, is_frontend, is_backend, is_locked, is_core, author_name, author_url, version, params, enabled) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", array("About", "Provides information about packages and installed CMS.", "about", "0", "1", "1", "0", "Chris Smith", "https://github.com/Smith0r", $version->numerical, '', "1"));
                    $db->query("INSERT INTO #__components (title, description, internal_name, is_frontend, is_backend, is_locked, is_core, author_name, author_url, version, params, enabled) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", array("Dashboard", "Show information on the Admin Panel homepage.", "dashboard", "0", "1", "1", "1", "Chris Smith", "https://github.com/Smith0r", $version->numerical, '', "1"));
                    $db->query("INSERT INTO #__components (title, description, internal_name, is_frontend, is_backend, is_locked, is_core, author_name, author_url, version, params, enabled) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", array("Sitemap", "Shows XML sitemap.", "sitemap", "1", "0", "0", "0", "Chris Smith", "https://github.com/Smith0r", $version->numerical, '', "1"));
                    $db->query("INSERT INTO #__components (title, description, internal_name, is_frontend, is_backend, is_locked, is_core, author_name, author_url, version, params, enabled) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", array("Contact", "Contact Form display. Sends email to configured address.", "contact", "1", "1", "0", "0" "Chris Smith", "https://github.com/Smith0r", $version->numerical, 'a:3:{s:11:"admin_email";s:'. strlen($_POST["email"]) .':"'. $_POST["email"] .'";s:14:"complete_title";s:23:"Thanks for your message";s:16:"complete_message";s:81:"<p>Thank you for getting in touch. We\'ll get back to you as soon as possible.</p>";}', "1"));
                    $db->query("INSERT INTO #__components_modules (title, description, internal_name, author_name, author_url, version) VALUES (?, ?, ?, ?, ?, ?)", array("Latest News", "Show the latest news in a list", "latestnews", "Chris Smith", "https://github.com/Smith0r", $version->numerical));
                    $db->query("INSERT INTO #__components_modules (title, description, internal_name, author_name, author_url, version) VALUES (?, ?, ?, ?, ?, ?)", array("Main Menu", "Show the main menu.", "mainmenu", "Chris Smith", "https://github.com/Smith0r", $version->numerical));
                    $db->query("INSERT INTO #__components_modules (title, description, internal_name, author_name, author_url, version) VALUES (?, ?, ?, ?, ?, ?)", array("Login", "Show login form.", "login", "Chris Smith", "https://github.com/Smith0r", $version->numerical));
                    $db->query("INSERT INTO #__components_modules (title, description, internal_name, author_name, author_url, version) VALUES (?, ?, ?, ?, ?, ?)", array("HTML", "Custom HTML Module.", "html", "Chris Smith", "https://github.com/Smith0r", $version->numerical));
                    $db->query("INSERT INTO #__components_modules (title, description, internal_name, author_name, author_url, version) VALUES (?, ?, ?, ?, ?, ?)", array("Menu", "Show menu items in a menu format.", "menu", "Chris Smith", "https://github.com/Smith0r", $version->numerical));
                    $db->query("INSERT INTO #__components_modules (title, description, internal_name, author_name, author_url, version) VALUES (?, ?, ?, ?, ?, ?)", array("Search", "Show search form.", "search", "Chris Smith", "https://github.com/Smith0r", $version->numerical));
                    $db->query("INSERT INTO #__components_hooks (title, description, component_name, author_name, author_url, version, enabled) VALUES (?, ?, ?, ?, ?, ?, ?)", array("Content", "Hooks for the content component.", "content", "Chris Smith", "https://github.com/Smith0r", $version->numerical, 1));
                    $db->query("INSERT INTO #__components_hooks (title, description, component_name, author_name, author_url, version, enabled) VALUES (?, ?, ?, ?, ?, ?, ?)", array("User", "Hooks for the user component.", "user", "Chris Smith", "https://github.com/Smith0r", $version->numerical, 1));
                    $db->query("INSERT INTO #__components_hooks (title, description, component_name, author_name, author_url, version, enabled) VALUES (?, ?, ?, ?, ?, ?, ?)", array("Sitemap", "Hooks for the sitemap component.", "sitemap", "Chris Smith", "https://github.com/Smith0r", $version->numerical, 1));
                    $db->query("INSERT INTO #__menus (title) VALUES (?)", array("Main Menu"));
                    $db->query("INSERT INTO #__menus_items (menu_id, parent_id, title, alias, published, component, controller, content_id, params, is_home, ordering) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", array("1", "0", "Home", "home", "1", "content", "category", "1", "N;", "1", "0"));
                    $db->query("INSERT INTO #__modules (title, type, show_title, published, position, params, pages, ordering) VALUES (?, ?, ?, ?, ?, ?, ?, ?)", array("Main Menu", "mainmenu", "0", "1", "main-menu", 'a:1:{s:7:"menu_id";s:1:"1";}', "0", "0"));
                    $db->query("INSERT INTO #__modules (title, type, show_title, published, position, params, pages, ordering) VALUES (?, ?, ?, ?, ?, ?, ?, ?)", array("User Menu", "login", "0", "1", "sidebar", '', "0", "0"));
                    $db->query("INSERT INTO #__usergroups (title, is_admin) VALUES (?, ?)", array("Members", "0"));
                    $db->query("INSERT INTO #__usergroups (title, is_admin) VALUES (?, ?)", array("Administrators", "1"));
                        
                    $db->query("INSERT INTO #__users (username, email, usergroup_id, password, activated, blocked, register_time, last_action_time) VALUES (?, ?, ?, ?, ?, ?, ?, ?)", array($_POST["username"], $_POST["email"], "2", password_hash($_POST["password"], PASSWORD_DEFAULT), "1", "0", time(), time()));
                    $db->query("INSERT INTO #__articles_categories (title, alias, description, published, params) VALUES (?, ?, ?, ?, ?)", array("Site Pages", "site-pages", "", "1", 'a:1:{s:10:"show_title";s:1:"1";}'));
                    $db->query("INSERT INTO #__articles (title, alias, category_id, content, published, publish_time, author_id, hits, meta_description, image) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", array("Welcome to Bulletin CMS", "welcome-to-bulletin-cms", "1", '<p>Welcome to Bulletin CMS!</p><p>Please feel free to delete this article.</p><p>If you require help with any part of the CMS, please open an issue on Github (<a href="https://github.com/Smith0r/bulletin" target="_blank">https://github.com/Smith0r/bulletin</a>)</p>', "1", time(), "1", "0", "Welcome to Bulletin CMS!", ""));
    
                    header("Location: index.php?stage=4");
    
                ?>
            <?php } else if ($_GET["stage"] == 4) { ?>
                <?php
    
                    $file = fopen(__DIR__ ."/../core/installer.lock", "w");
                    fwrite($file, "Installation complete.");
                    fclose($file);
    
                ?>
                <h1>Installation Complete!</h1>
                <p>Installation of your new CMS has completed successfully!</p>
                <p><strong>Please now delete the "installer" directory, and navigate to your new CMS!</strong></p>
                <p><a href="<?php echo BASE_URL."home"; ?>" class="btn btn-primary">Visit your homepage</a></p>
            <?php } ?>
        </div>
    </body>
</html>