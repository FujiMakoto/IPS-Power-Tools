<?php


namespace PowerTools\Parsers;

use Symfony\Component\Console\Exception\InvalidArgumentException;

class ClassNamespace
{
	public $classNamespace;

	public $appDir;
	public $parentClassName;
	public $className;

	/**
	 * ClassNamespace constructor.
	 *
	 * @param   string  $classNamespace
	 */
	public function __construct( $classNamespace )
	{
		$this->classNamespace = $classNamespace;
		$this->parseNamespaceParts();
	}

	/**
	 * Parse components from a namespace.
	 */
	protected function parseNamespaceParts()
	{
		// Try and match a namespace pattern with a parent directory first
		$match = preg_match(
			'/^\\\\?IPS\\\\(?P<appdir>\w+)\\\\(?P<subdir>\w+)\\\\(?P<classname>\w+)$/', $this->classNamespace, $matches
		);

		// If that didn't work, try and match a root level namespace pattern
		if ( !$match )
		{
			$match = preg_match(
				'/^\\\\?IPS\\\\(?P<appdir>\w+)\\\\(?P<classname>\w+)$/', $this->classNamespace, $matches
			);
		}

		// If we still didn't get a match, we have an invalid namespace
		if ( !$match )
		{
			throw new InvalidArgumentException( 'Invalid namespace provided' );
		}

		// If we're still here, parse our namespace parts
		$this->appDir          = $matches['appdir'];
		$this->parentClassName = isset( $matches['subdir'] ) ? $matches['subdir'] : '';
		$this->className       = $matches['classname'];

		// Adjust our actual namespace (if necessary)
		if ( $this->parentClassName )
		{
			$this->classNamespace = substr(
					$this->classNamespace, 0, strrpos( $this->classNamespace, '\\' . $this->className )
			);
		}
	}
}