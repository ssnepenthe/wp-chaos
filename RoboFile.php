<?php
/**
 * This is project's console commands configuration for Robo task runner.
 *
 * @package wp-chaos
 */

/**
 * This class defines the projects Robo tasks.
 */
class RoboFile extends \Robo\Tasks
{
	/**
	 * Update version across all relevant files.
	 *
	 * @param string $version The new plugin version.
	 */
	public function versionBump( $version ) {
		$this->taskReplaceInFile( __DIR__ . '/public/content/mu-plugins/wpc-helpers.php' )
			->regex( '/Version:.*$/m' )
			->to( sprintf( 'Version: %s', $version ) )
			->run();
	}
}
