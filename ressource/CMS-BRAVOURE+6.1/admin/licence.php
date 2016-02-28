<?php
session_start();

	$key = md5(rand(0,9999).time());
	$licence = md5("ddf2273cdd754f91cc6554c9ef76154c9209cdd754f91cc6554c9e63109d75451912");

	$verification = 0;

	$version = 6; // version 6
?>