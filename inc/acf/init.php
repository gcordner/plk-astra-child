<?php

require_once __DIR__ . '/acf-builder/autoload.php';
if ( ! class_exists( 'Doctrine\Common\Inflector\Inflector' ) ) {
	require_once __DIR__ . '/Doctrine/Common/Inflector/Inflector.php';
}

require_once 'acf-options.php';
require_once 'acf-templates.php';
require_once 'acf-taxonomy.php';
