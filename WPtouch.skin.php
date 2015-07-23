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
		$template = 'WPtouchTemplate', $useHeadElement = true;

	/**
	 * Add the class "skated-wptouch-bg" to the <body> element for pages rendered
	 * with this skin.
	 *
	 * @param OutputPage $out
	 * @param Skin $skin
	 * @param array $bodyAttrs Pre-existing attributes of the <body> tag
	 * @return bool
	 */
	public static function onOutputPageBodyAttributes( $out, $skin, &$bodyAttrs ) {
		// The skin class check has to be present because hooks are global!
		// I'm actually not sure if that's the case anymore (this used to use
		// an anonymous function in the setup file), but better to be safe than
		// sorry...and I'm lazy, too.
		if ( get_class( $skin ) == 'SkinWPtouch' ) {
			$bodyAttrs['class'] .= ' skated-wptouch-bg';
		}
		return true;
	}

	/**
	 * Initializes OutputPage and sets up skin-specific parameters
	 *
	 * @param OutputPage $out
	 */
	public function initPage( OutputPage $out ) {
		global $wgLocalStylePath;

		parent::initPage( $out );

		$out->addMeta( 'viewport', 'width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no' );
		$out->addLink( array(
			'rel' => 'apple-touch-icon',
			'href' => $wgLocalStylePath . '/WPtouch/resources/images/favicon.png'
		) );

		$out->addModules( 'skins.wptouch.js' );
	}

	/**
	 * @param $out OutputPage
	 */
	function setupSkinUserCss( OutputPage $out ) {
		parent::setupSkinUserCss( $out );

		// Append to the default screen common & print styles...
		$out->addModuleStyles( array(
			'mediawiki.skinning.interface',
			'mediawiki.skinning.content.externallinks',
			'skins.wptouch'
		) );
	}
}

class WPtouchTemplate extends BaseTemplate {
	function execute() {
		global $wgStylePath;

		$skin = $this->data['skin'];

		$logoIcon = wfFindFile( 'WPtouch-logo-icon.png' );
		if ( is_object( $logoIcon ) ) {
			$logoURL = $logoIcon->getUrl();
		} else {
			$logoURL = $wgStylePath . '/WPtouch/resources/images/favicon.png';
		}

		// Login stuff borrowed from the UserLoginBox extension
		if ( session_id() == '' ) {
			wfSetupSession();
		}

		if ( !LoginForm::getLoginToken() ) {
			LoginForm::setLoginToken();
			$token = LoginForm::getLoginToken();
		} else {
			$token = LoginForm::getLoginToken();
		}

		$loginURL = SpecialPage::getTitleFor( 'Userlogin' )->getFullURL( array(
			'action' => 'submitlogin',
			'type' => 'login',
			'wpLoginToken' => $token
		) );

		$this->html( 'headelement' );
?>
<!-- New noscript check, we need JS on now folks -->
<noscript>
<div id="noscript-wrap">
	<div id="noscript">
		<h2><?php $this->msg( 'wptouch-noscript-title' ) ?></h2>
		<?php echo $this->getMsg( 'wptouch-noscript-body' )->parseAsBlock() ?>
	</div>
</div>
</noscript>

<!--#start The Login Overlay -->
<div id="wptouch-login">
	<div id="wptouch-login-inner">
		<form name="loginform" id="loginform" action="<?php echo htmlspecialchars( $loginURL, ENT_QUOTES ) ?>" method="post">
			<label><input type="text" name="wpName" id="wpName" value="<?php $this->msg( 'userlogin-yourname' ) ?>" /></label>
			<label><input type="password" name="wpPassword" id="wpPassword" value="<?php $this->msg( 'userlogin-yourpassword' ) ?>" /></label>
			<input type="hidden" id="logsub" name="submit" value="Login" tabindex="9" />
			<a href="#"><img class="head-close" src="<?php $this->text( 'stylepath' ) ?>/WPtouch/resources/images/head-close.png" alt="close" /></a>
		</form>
	</div>
</div>

 <!-- #start The Search Overlay -->
<div id="wptouch-search">
	<div id="wptouch-search-inner">
		<form method="get" id="searchform" action="<?php $this->text( 'wgScript' ) ?>">
			<input type="hidden" name="title" value="<?php $this->text( 'searchtitle' ) ?>"/>
			<?php
				echo $this->makeSearchInput( array( 'id' => 'searchInput' ) );
				echo $this->makeSearchButton( 'go', array( 'id' => 'searchGoButton', 'class' => 'searchButton' ) );
			?>
			<a href="#"><img class="head-close" src="<?php $this->text( 'stylepath' ) ?>/WPtouch/resources/images/head-close.png" alt="close" /></a>
		</form>
	</div>
</div>

<div id="wptouch-menu" class="dropper">
	<div id="wptouch-menu-inner">
		<div id="menu-head">
			<div id="tabnav">
				<a href="#head-navigation"><?php $this->msg( 'navigation' ) ?></a> <a href="#head-toolbox"><?php $this->msg( 'toolbox' ) ?></a> <a href="#head-personal"><?php $this->msg( 'personaltools' ) ?></a><a href="#head-actions"><?php $this->msg( 'actions' ) ?></a>
			</div>

			<ul id="head-navigation">
			<?php
			$skipped = array( 'LANGUAGES', 'SEARCH', 'TOOLBOX' );
			foreach ( $this->data['sidebar'] as $boxName => $content ) {
				if ( $content === false || in_array( $boxName, $skipped ) ) {
					continue;
				}
				if ( is_array( $content ) ) {
					foreach ( $content as $key => $val ) {
						echo $this->makeListItem( $key, $val );
					}
				}
			}
			?>
			</ul>

			<ul id="head-toolbox">
				<?php
				foreach ( $this->getToolbox() as $key => $item ) {
					echo $this->makeListItem( $key, $item );
				}

				Hooks::run( 'SkinTemplateToolboxEnd', array( &$this, true ) );
				?>
			</ul>

			<ul id="head-personal">
				<?php
				foreach ( $this->getPersonalTools() as $key => $item ) {
					echo $this->makeListItem( $key, $item );
				}
				?>
			</ul>

			<ul id="head-actions">
				<?php
				foreach ( $this->data['content_actions'] as $key => $tab ) {
					echo $this->makeListItem( $key, $tab );
				}
				?>
			</ul>
		</div>
	</div>
</div>

<div id="headerbar">
	<div id="headerbar-title">
		<img id="logo-icon" src="<?php echo $logoURL ?>" alt="<?php $this->msg( 'sitetitle' ) ?>" />
		<a href="<?php echo Title::newMainPage()->getFullURL() ?>"><?php $this->msg( 'sitetitle' ) ?></a>
	</div>
	<div id="headerbar-menu">
		<a href="#"></a>
	</div>
</div>

<div id="drop-fade">
	<a id="searchopen" class="top" href="#"><?php $this->msg( 'search' ) ?></a>
</div>

<div class="content">
	<div class="post">
		<h2><?php $this->data['displaytitle'] != '' ? $this->html( 'title' ) : $this->text( 'title' ) ?></h2>
		<hr />
		<div class="clearer"></div>
		<div class="mainentry mw-body">
			<?php $this->html( 'bodytext' ) ?>
			<?php if ( $this->data['dataAfterContent'] ) { $this->html( 'dataAfterContent' ); } ?>
		</div>
	</div>
</div>

		<div class="cleared"></div>
		<div class="visualClear"></div>

		<?php $this->printTrail(); ?>
	</body>
</html>
<?php
	} // end of execute() method
} // end of class