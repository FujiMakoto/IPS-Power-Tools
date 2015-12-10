<?="<?php"?>


namespace <?=$classNamespace?>;

/* To prevent PHP errors (extending class does not exist) revealing path */
if ( !defined( '\IPS\SUITE_UNIQUE_KEY' ) )
{
	header( ( isset( $_SERVER['SERVER_PROTOCOL'] ) ? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0' ) . ' 403 Forbidden' );
	exit;
}

class _<?=$className?> extends \IPS\Content\Comment implements \IPS\Content\EditHistory, \IPS\Content\ReportCenter, \IPS\Content\Hideable, \IPS\Content\Reputation, \IPS\Content\Searchable, \IPS\Content\Embeddable
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
	 * @brief   [Content\Comment]	Item Class
	 */
	public static $itemClass = '<?=$itemClass?>';

	/**
	 * @brief   [ActiveRecord] Database Table
	 */
	public static $databaseTable = '<?=$databaseTable?>';

	/**
	 * @brief   [ActiveRecord] Database Prefix
	 */
	public static $databasePrefix = '<?=$databasePrefix?>';

	/**
	 * @brief   [ActiveRecord] ID Database Column
	 */
	public static $databaseColumnId = '<?=$databaseColumnId?>';

<?php if ( $dbMap ) { ?>
	/**
	 * @brief   Database Column Map
	 */
	public static $databaseColumnMap = array(
		<?php if ( $dbMapItem !== NULL ) { ?>'item'             => '<?=$dbMapItem?>',<?php } ?>

		<?php if ( $dbMapAuthor !== NULL ) { ?>'author'           => '<?=$dbMapAuthor?>',<?php } ?>

		<?php if ( $dbMapAuthorName !== NULL ) { ?>'author_name'      => '<?=$dbMapAuthorName?>',<?php } ?>

		<?php if ( $dbMapContent !== NULL ) { ?>'content'          => '<?=$dbMapContent?>',<?php } ?>

		<?php if ( $dbMapDate !== NULL ) { ?>'date'             => '<?=$dbMapDate?>',<?php } ?>

		<?php if ( $dbMapIpAddress !== NULL ) { ?>'ip_address'       => '<?=$dbMapIpAddress?>',<?php } ?>

		<?php if ( $dbMapEditTime !== NULL ) { ?>'edit_time'        => '<?=$dbMapEditTime?>',<?php } ?>

		<?php if ( $dbMapEditName !== NULL ) { ?>'edit_member_name' => '<?=$dbMapEditName?>',<?php } ?>

		<?php if ( $dbMapEditShow !== NULL ) { ?>'edit_show'        => '<?=$dbMapEditShow?>',<?php } ?>

		<?php if ( $dbMapApproved !== NULL ) { ?>'approved'         => '<?=$dbMapApproved?>'<?php } ?>

	);
<?php } else { ?>
	/**
	 * @brief   Database Column Map
	 */
	public static $databaseColumnMap = array();
<?php } ?>

	/**
	 * @brief   Title
	 */
	public static $title = '<?=$title?>';

	/**
	 * @brief   Icon
	 */
	public static $icon = '<?=$icon?>';

	/**
	 * @brief   [Content] Key for hide reasons
	 */
	public static $hideLogKey = '<?=$hideLogKey?>';

	/**
	 * @brief   Reputation Type
	 */
	public static $reputationType = '<?=$reputationType?>';
}