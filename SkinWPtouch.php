<?php
/**
 * WPtouch skin
 *
 * @file
 */

/**
 * Inherit main code from SkinTemplate, set the CSS and template filter.
 *
 * @ingroup Skins
 */
class SkinWPtouch extends SkinTemplate {
	public $skinname = 'wptouch', $stylename = 'wptouch',
		$template = 'WPtouchTemplate';

	/**
	 * Initializes OutputPage and sets up skin-specific parameters
	 *
	 * @param OutputPage $out
	 */
	public function initPage( OutputPage $out ) {
		global $wgLocalStylePath;

		parent::initPage( $out );

		$out->addMeta( 'viewport', 'width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no' );
		$out->addLink( [
			'rel' => 'apple-touch-icon',
			'href' => $wgLocalStylePath . '/WPtouch/resources/images/favicon.png'
		] );
	}
}
