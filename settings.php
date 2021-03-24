<?php

$DB_CONNECTION_HOST = 'localhost';
$DB_CONNECTION_USER = 'root';
$DB_CONNECTION_PASSWORD = '';
$DB_CONNECTION_NAME = 'event_scheduler';

$EVENT_PRIORITY_CHOICES = [
	"low" => "Low",
	"medium" => "Medium",
	"high" => "High",
	"critical" => "Critical"
];

define("DB_CONNECTION_HOST", $DB_CONNECTION_HOST);
define("DB_CONNECTION_USER", $DB_CONNECTION_USER);
define("DB_CONNECTION_PASSWORD", $DB_CONNECTION_PASSWORD);
define("DB_CONNECTION_NAME", $DB_CONNECTION_NAME);