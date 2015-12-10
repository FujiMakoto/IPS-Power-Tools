<?="<?php"?>


namespace <?=$classNamespace?>;

/* To prevent PHP errors (extending class does not exist) revealing path */
if ( !defined( '\IPS\SUITE_UNIQUE_KEY' ) )
{
	header( ( isset( $_SERVER['SERVER_PROTOCOL'] ) ? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0' ) . ' 403 Forbidden' );
	exit;
}

class _<?=$className?> extends \IPS\Patterns\ActiveRecord
{
	/**
	 * @brief   Application
	 */
	public static $application = '<?=$appDir?>';

	/**
	 * @brief   [ActiveRecord] Multiton Store
	 */
	protected static $multitons;

	/**
	 * @brief   [ActiveRecord] Database Table
	 */
	public static $databaseTable = <?=$databaseTable?>;

	/**
	 * @brief   [ActiveRecord] ID Database Column
	 */
	public static $databaseColumnId = <?=$databaseColumnId?>;

	/**
	 * @brief   [ActiveRecord] Database ID Fields
	 */
	protected static $databaseIdFields = array();

	/**
	 * @brief   Bitwise values
	 */
	public static $bitOptions = array();
}