<?php
/**
 * WPtouch skin
 *
 * @file
 * @ingroup Skins
 * @version 1.0
 * @date 14 June 2015
 * @author Jack Phoenix <jack@countervandalism.net>
 *
 * To install place the WPtouch folder (the folder containing this file!) into
 * skins/ and add this line to your wiki's LocalSettings.php:
 * require_once "$IP/skins/WPtouch/WPtouch.php";
 */

// Skin credits that will show up on Special:Version
$wgExtensionCredits['skin'][] = array(
	'path' => __FILE__,
	'name' => 'WPtouch',
	'version' => '1.0',
	'author' => array( 'Dale Mugford', 'Duane Storey', 'Dan Flores', 'Jack Phoenix' ),
	'description' => 'Simple skin for mobile devices',
	'url' => 'https://www.mediawiki.org/wiki/Skin:WPtouch',
);

$wgHooks['OutputPageBodyAttributes'][] = 'SkinWPtouch::onOutputPageBodyAttributes';

// The first instance must be strtolower()ed so that useskin=wptouch works and
// so that it does *not* force an initial capital (i.e. we do NOT want
// useskin=Wptouch) and the second instance is used to determine the name of
// *this* file.
$wgValidSkinNames['wptouch'] = 'WPtouch';

// Autoload the skin class and set up CSS & JS (via ResourceLoader)
$wgAutoloadClasses['SkinWPtouch'] = __DIR__ . '/WPtouch.skin.php';
$wgAutoloadClasses['WPtouchTemplate'] = __DIR__ . '/WPtouch.skin.php';

// Internationalization
$wgMessagesDirs['SkinWPtouch'] = __DIR__ . '/i18n';

$wgResourceModules['skins.wptouch'] = array(
	'styles' => array(
		'main.css' => array( 'media' => 'screen' ),
		'really-small.css' => array( 'media' => 'all and (max-width: 350px)' )
	),
	'position' => 'top',
	'remoteBasePath' => $wgStylePath . '/WPtouch/resources/css',
	'remoteExtPath' => $wgStylePath . '/WPtouch/resources/css',
	'localBasePath' => __DIR__ . '/resources/css'
);

$wgResourceModules['skins.wptouch.js'] = array(
	'scripts' => array( 'core.js', 'url-bar.js' ),
	'remoteBasePath' => $wgStylePath . '/WPtouch/resources/javascript',
	'remoteExtPath' => $wgStylePath . '/WPtouch/resources/javascript',
	'localBasePath' => __DIR__ . '/resources/javascript'
);