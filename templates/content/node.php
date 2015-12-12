<?="<?php"?>


namespace <?=$classNamespace?>;

/* To prevent PHP errors (extending class does not exist) revealing path */
if ( !defined( '\IPS\SUITE_UNIQUE_KEY' ) )
{
	header( ( isset( $_SERVER['SERVER_PROTOCOL'] ) ? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0' ) . ' 403 Forbidden' );
	exit;
}

class _<?=$className?> extends \IPS\Node\Model implements \IPS\Node\Permissions
{
	/**
	 * @brief   [ActiveRecord] Multiton Store
	 */
	protected static $multitons;

	/**
	 * @brief   [ActiveRecord] Database Table
	 */
	public static $databaseTable = <?=$databaseTable?>;

	/**
	 * @brief   [ActiveRecord] Database Prefix
	 */
	public static $databasePrefix = <?=$databasePrefix?>;

	/**
	 * @brief   [ActiveRecord] ID Database Column
	 */
	public static $databaseColumnId = <?=$databaseColumnId?>;

	/**
	 * @brief   [Node] Order Database Column
	 */
	public static $databaseColumnOrder = <?=$databaseColumnOrder?>;

	/**
	 * @brief   [Node] Parent ID Database Column
	 */
	public static $databaseColumnParent = <?=$databaseColumnParent?>;

	/**
	 * @brief   [Node] Node Title
	 */
	public static $nodeTitle = <?=$title?>;

	/**
	 * @brief   [Node] ACP Restrictions
	 * @code
	 	array(
	 		'app'		=> 'core',				// The application key which holds the restrictrions
	 		'module'	=> 'foo',				// The module key which holds the restrictions
	 		'map'		=> array(				// [Optional] The key for each restriction - can alternatively use "prefix"
	 			'add'			=> 'foo_add',
	 			'edit'			=> 'foo_edit',
	 			'permissions'	=> 'foo_perms',
	 			'delete'		=> 'foo_delete'
	 		),
	 		'all'		=> 'foo_manage',		// [Optional] The key to use for any restriction not provided in the map (only needed if not providing all 4)
	 		'prefix'	=> 'foo_',				// [Optional] Rather than specifying each  key in the map, you can specify a prefix, and it will automatically look for restrictions with the key "[prefix]_add/edit/permissions/delete"
	 * @endcode
	 */
	protected static $restrictions = array(
		'app'       => '<?=$appDir?>',
		'module'    => '<?=$appDir?>',
		'prefix'    => 'categories_'
	);

	/**
	 * @brief   [Node] App for permission index
	 */
	public static $permApp = '<?=$appDir?>';

	/**
	 * @brief   [Node] Type for permission index
	 */
	public static $permType = 'category';

	/**
	 * @brief   The map of permission columns
	 */
	public static $permissionMap = array(
		'view'          => 'view',
		'read'          => 2,
		'add'           => 3,
		'download'      => 4,
		'reply'         => 5,
		'review'        => 6
	);

	/**
	 * @brief   Bitwise values
	 */
	public static $bitOptions = array();

	/**
	 * @brief   [Node] Title prefix.  If specified, will look for a language key with "{$key}_title" as the key
	 */
	public static $titleLangPrefix = '<?=$appDir?>_category_';

	/**
	 * @brief   [Node] Description suffix.  If specified, will look for a language key with "{$titleLangPrefix}_{$id}_{$descriptionLangSuffix}" as the key
	 */
	public static $descriptionLangSuffix = '_desc';

	/**
	 * @brief   [Node] Moderator Permission
	 */
	public static $modPerm = '<?=$appDir?>_categories';

	/**
	 * @brief   Content Item Class
	 */
	public static $contentItemClass = <?=$itemClass?>;

	/**
	 * @brief   [Node] Prefix string that is automatically prepended to permission matrix language strings
	 */
	public static $permissionLangPrefix = 'perm_<?=$appDir?>_';

	/**
	 * @brief   [Node] Enabled/Disabled Column
	 */
	public static $databaseColumnEnabledDisabled = 'enabled';

	/**
	 * @brief	Cached URL
	 */
	protected $_url	= NULL;

	/**
	 * @brief	URL Base
	 */
	public static $urlBase = 'app=<?=$appDir?>&module=<?=$appDir?>&controller=browse&id=';

	/**
	 * @brief	URL Base
	 */
	public static $urlTemplate = '<?=$appDir?>_cat';

	/**
	 * @brief	SEO Title Column
	 */
	public static $seoTitleColumn = 'name_furl';

	/**
	 * Get SEO name
	 *
	 * @return	string
	 */
	public function get_name_furl()
	{
		if( !$this->_data['name_furl'] )
		{
			$this->name_furl = \IPS\Http\Url::seoTitle( \IPS\Lang::load( \IPS\Lang::defaultLanguage() )->get( '<?=$appDir?>_category_' . $this->id ) );
			$this->save();
		}

		return $this->_data['name_furl'] ?: \IPS\Http\Url::seoTitle( \IPS\Lang::load( \IPS\Lang::defaultLanguage() )->get( '<?=$appDir?>_category_' . $this->id ) );
	}

	/**
	 * [Node] Add/Edit Form
	 *
	 * @param	\IPS\Helpers\Form	$form	The form
	 * @return	void
	 */
	public function form( &$form )
	{
		// ...
	}

	/**
	 * [Node] Format form values from add/edit form for save
	 *
	 * @param	array	$values	Values from the form
	 * @return	array
	 */
	public function formatFormValues( $values )
	{
		// ...

		/* Send to parent */
		return $values;
	}
}