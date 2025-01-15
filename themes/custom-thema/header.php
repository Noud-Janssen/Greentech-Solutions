<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo get_template_directory_uri() ?>/css/style.css">
    <?php wp_head(); ?>
</head>
<div id="wrapper">
<header id="header">
    <a href="/"><img src="<?php echo get_template_directory_uri() ?>/assets/logo.svg" alt="" class="logo" /></a>
    <nav class="links">
        <ul>
            <li><a href="/">Home</a></li>
        </ul>
    </nav>
    <nav class="main">
        <ul>
            <li class="search">
                <a class="fa-search" href="#search">Search</a>
                <form id="search" method="get" action="#">
                    <input type="text" name="s" placeholder="Search" />
                </form>
            </li>
            <li class="menu">
                <a class="fa-bars" href="#menu">Menu</a>
            </li>
        </ul>
    </nav>
</header>
<body <?php body_class(); ?>>
