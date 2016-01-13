<?php $this->load->view('header'); ?>
    <!-- /section:basics/navbar.layout -->
<body class="skin-4 no-skin">
<?php $this->load->view('navbar'); ?>
<div class="main-container" id="main-container">
    <!-- #section:basics/sidebar -->
    <?php $this->load->view('sidebar'); ?>

    <!-- /section:basics/sidebar -->
    <?php $this->load->view('main-content'); ?>

 <?php $this->load->view('footer'); ?>