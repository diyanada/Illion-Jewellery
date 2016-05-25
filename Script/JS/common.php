<?php

/*
 * Copyright (C) 2016 Diyanada Gunawardena.
 * diyanada@gmail.com
 */

header("Content-type: application/javascript; charset: UTF-8");

include (dirname(__FILE__) . '/../../owsh_secret.php');

echo 'function external_source_js(paht){';				
echo 'return "' . $url_path . '" + paht;';
echo '}';

