<?php
$this->load->view('header/header1', array('title' => $title));

$this->load->view($page);

$this->load->view('footer/footer1', array('title' => $title));
?>