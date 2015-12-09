<?="<?php"?>

namespace <?=$namespace?>;

/* To prevent PHP errors (extending class does not exist) revealing path */
if ( !defined( '\IPS\SUITE_UNIQUE_KEY' ) )
{
	header( ( isset( $_SERVER[ 'SERVER_PROTOCOL' ] ) ? $_SERVER[ 'SERVER_PROTOCOL' ] : 'HTTP/1.0' ) . ' 403 Forbidden' );
	exit;
}

class _<?=$className?> extends \IPS\Content\Item
{
	/**
	 * @brief   Application
	 */
	public static $application = '<?=$appDir?>';

	/**
	 * @brief   Module
	 */
	public static $module = '<?=$module?>';

	/**
	 * @brief   Database Table
	 */
	public static $databaseTable = '<?=$databaseTable?>';

	/**
	 * @brief   Database Prefix
	 */
	public static $databasePrefix = '<?=$databasePrefix?>';

	/**
	 * @brief   Multiton Store
	 */
	protected static $multitons;

	/**
	 * @brief	[ActiveRecord] ID Database Column
	 */
	public static $databaseColumnId = '<?=$databaseColumnId?>';

	/**
	 * @brief   Default Values
	 */
	protected static $defaultValues = NULL;

	/**
	 * @brief   Node Class
	 */
	public static $containerNodeClass = <?=$containerNodeClass?>;

	/**
	 * @brief   Comment Class
	 */
	public static $commentClass = <?=$commentClass?>;

	/**
	 * @brief   Review Class
	 */
	public static $reviewClass = <?=$reviewClass?>;
<?php if ( $dbMap ) ?>
	/**
	 * @brief   Database Column Map
	 */
	public static $databaseColumnMap = array(
		<?php if ( $dbMapContainer !== NULL ): ?>'container'         => '<?=$dbMapContainer?>',<?php endif ?>
		<?php if ( $dbMapAuthor !== NULL ): ?>'author'            => '<?=$dbMapAuthor?>',<?php endif ?>
		<?php if ( $dbMapViews !== NULL ): ?>'views'             => '<?=$dbMapViews?>',<?php endif ?>
		<?php if ( $dbMapTitle !== NULL ): ?>'title'             => '<?=$dbMapTitle?>',<?php endif ?>
		<?php if ( $dbMapContent !== NULL ): ?>'content'           => '<?=$dbMapContent?>',<?php endif ?>
		<?php if ( $dbMapNumComments !== NULL ): ?>'num_comments'      => '<?=$dbMapNumComments?>',<?php endif ?>
		<?php if ( $dbMapLastComment !== NULL ): ?>'last_comment'      => '<?=$dbMapLastComment?>',
		<?php if ( $dbMapLastCommentBy !== NULL ): ?>'last_comment_by'   => '<?=$dbMapLastCommentBy?>',<?php endif ?>
		<?php if ( $dbMapLastCommentName !== NULL ): ?>'last_comment_name' => '<?=$dbMapLastCommentName?>',<?php endif ?>
		<?php if ( $dbMapLastReview !== NULL ): ?>'last_review'       => '<?=$dbMapLastReview?>',<?php endif ?>
		<?php if ( $dbMapDate !== NULL ): ?>'date'              => '<?=$dbMapDate?>',<?php endif ?>
		<?php if ( $dbMapUpdated !== NULL ): ?>'updated'           => '<?=$dbMapUpdated?>',<?php endif ?>
		<?php if ( $dbMapApproved !== NULL ): ?>'approved'          => '<?=$dbMapApproved?>',<?php endif ?>
		<?php if ( $dbMapApprovedBy !== NULL ): ?>'approved_by'       => '<?=$dbMapApprovedBy?>',<?php endif ?>
		<?php if ( $dbMapApprovedDate !== NULL ): ?>'approved_date'     => '<?=$dbMapApprovedDate?>',<?php endif ?>
		<?php if ( $dbMapPinned !== NULL ): ?>'pinned'            => '<?=$dbMapPinned?>',<?php endif ?>
		<?php if ( $dbMapFeatured !== NULL ): ?>'featured'          => '<?=$dbMapFeatured?>',<?php endif ?>
		<?php if ( $dbMapLocked !== NULL ): ?>'locked'            => '<?=$dbMapLocked?>',<?php endif ?>
		<?php if ( $dbMapIpAddress !== NULL ): ?>'ip_address'        => '<?=$dbMapIpAddress?>'<?php endif ?>
	);
<?php endif ?>
	/**
	 * @brief   Title
	 */
	public static $title = '<?=$title?>';

	/**
	 * @brief   Icon
	 */
	public static $icon = '<?=$icon?>';

	/**
	 * @brief	[Content]	Key for hide reasons
	 */
	public static $hideLogKey = '<?=$hideLogKey?>';

	/**
	 * @brief   Form Lang Prefix
	 */
	public static $formLangPrefix = '<?=$formLangPrefix?>';

	/**
	 * @brief	Reputation Type
	 */
	public static $reputationType = '<?=$reputationType?>';
}
