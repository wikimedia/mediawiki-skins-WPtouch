<?php
/**
 * Hook handler for this skin.
 */
class WPtouchHooks {
	/**
	 * Add the class "skated-wptouch-bg" to the <body> element for pages rendered
	 * with this skin.
	 *
	 * @param OutputPage $out
	 * @param Skin $skin
	 * @param array $bodyAttrs Pre-existing attributes of the <body> tag
	 */
	public static function onOutputPageBodyAttributes( OutputPage $out, Skin $skin, &$bodyAttrs ) {
		if ( $skin instanceof SkinWPtouch ) {
			$bodyAttrs['class'] .= ' skated-wptouch-bg';
		}
	}
}
