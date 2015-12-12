<?php

namespace PowerTools\Console;

use PowerTools\Parsers\ClassNamespace;
use PowerTools\Template\Template;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Process\Exception\InvalidArgumentException;

class GenerateCommand extends Command
{
	public $classNamespace;
	public $className;

	public $appDir;
	public $parentClassName;

	/**
	 * Assign the attributes of a namespace to the local generator class
	 *
	 * @param   ClassNamespace  $namespace
	 */
	protected function assignNamespaceAttributes( ClassNamespace $namespace )
	{
		$this->classNamespace = $namespace->classNamespace;
		$this->className = $namespace->className;

		$this->appDir = $namespace->appDir;
		$this->parentClassName = $namespace->parentClassName;
	}

	/**
	 * Return a literal NULL if input is NULL, otherwise wrap the value in single quotes (escaping if needed)
	 *
	 * @param   string  $value
	 * @return  string
	 */
	protected function quoteOrNull( $value )
	{
		return !is_null( $value ) ? "'" . str_replace( "'", "\\'", $value ) . "'" : 'NULL';
	}

	/**
	 * Generate and return a PHP template
	 *
	 * @return  string
	 */
	protected function generateTemplate( $templatePath )
	{
		$template = new Template();

		foreach ( get_object_vars( $this ) as $key => $value )
		{
			if ( !in_array( $key, [ 'classNamespace', 'className', 'appDir', 'module' ] ) )
			{
				$value = $this->quoteOrNull( $value );
			}

			$template->{$key} = $value;
		}

		return $template->render( "phar://ptools.phar/templates/{$templatePath}" );
	}

	/**
	 * Write a template file
	 *
	 * @param   string  $template
	 */
	protected function writeTemplate( $template )
	{
		// Make sure our application directory has been defined
		if ( !$this->appDir )
		{
			throw new \UnexpectedValueException( '$appDir must be defined before attempting to write a template' );
		}

		// Make sure the application directory actually exists
		$appPath = join( \DIRECTORY_SEPARATOR, [ getcwd(), 'applications', $this->appDir ] );
		if ( !is_dir( $appPath ) )
		{
			throw new InvalidArgumentException( 'Application directory does not exist: ' + $this->appDir );
		}

		// Construct our source path
		$sourcePath = join( \DIRECTORY_SEPARATOR, [ $appPath, 'sources' ] );
		$sourcePath = $this->parentClassName
				? join( \DIRECTORY_SEPARATOR, [ $sourcePath, $this->parentClassName ] )
				: join( \DIRECTORY_SEPARATOR, [ $sourcePath, $this->className ] );

		// Make sure the directory exists
		if ( !is_dir( $sourcePath ) )
		{
			mkdir( $sourcePath, 0777, TRUE );
		}

		// Construct the path to our class file and write our template to it
		$classPath = join( \DIRECTORY_SEPARATOR, [ $sourcePath, $this->className . '.php' ] );
		file_put_contents( $classPath, $template );
	}
}