<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <base href='<?php echo base_url(); ?>'/>
        <title>MTL | Content Management System</title>
        <link type="text/css" rel="stylesheet" href="http://www.dreamtemplate.com/dreamcodes/tables2/css/tsc_tables2.css" />
        <!-- DC Message Box CSS -->
        <link type="text/css" rel="stylesheet" href="http://www.dreamtemplate.com/dreamcodes/message_box/css/tsc_message_box.css" />
        <script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
        <!-- DC Message Box JS -->
        <script type="text/javascript" src="http://www.dreamtemplate.com/dreamcodes/message_box/js/jquery.cookie.js"></script>
        <script type="text/javascript" src="http://www.dreamtemplate.com/dreamcodes/message_box/js/tsc_message_box.js"></script>
        <!-- DC Form Beautify JS -->
        <script type="text/javascript" src="http://www.dreamtemplate.com/dreamcodes/form_beautify/js/jquery.jqtransform.js"></script>
        <script src="js/script.js" type="text/javascript"></script>
        <link type="text/css" rel="stylesheet" href="css/admin.css">
        <script type="text/javascript">

        </script>
    </head>
    <body>
        <div id="wrapper">
            <div class="Headermenu ">
                <div class='navigation'>
                <ul>
                    <li class="home selected"><?php echo anchor('auth', '<span>Users</span>') ?></li>
                    <li class="contact"><?php echo anchor('admin/logs', '<span>User Logs</span>') ?></li>
                    <li class="products"><?php echo anchor('admin/miningCosulting', '<span>Mining</span>') ?></li>
                    <li class="products"><?php echo anchor('admin/oilandgas', '<span>Oil & Gas</span>') ?></li>
                    <li class="products"><?php echo anchor('admin/environment', '<span>Environment</span>') ?></li>
                    <li class="products"><?php echo anchor('admin/training', '<span>Training</span>') ?></li>
                    <li class="products"><?php echo anchor('admin/news', '<span>News</span>') ?></li>
                    <li class="products"><?php echo anchor('admin/projects', '<span>Projects</span>') ?></li>
                    <li class="products"><?php echo anchor('admin/clients', '<span>Clients</span>') ?></li>
                    <li class="products"><?php echo anchor('admin/home', '<span>home</span>') ?></li>
                    <li class="contact"><?php echo anchor('auth/logout', '<span>Logout</span>') ?></li>
                </ul>
                </div>
           
            </div>
            
        