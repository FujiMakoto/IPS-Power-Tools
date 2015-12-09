<?php

/**
 * @brief       A simple, custom vanilla PHP template engine, inspired from http://chadminick.com
 * @author      Makoto Fujimoto <makoto@makoto.io>
 * @copyright   (c) 2015 Makoto Fujimoto
 * @license     <a href='http://opensource.org/licenses/MIT'>MIT License</a>
 * @since       08 Dec 2015
 */

class Template
{
	private $vars = [ ];

	public function __get( $name )
	{
		return $this->vars[ $name ];
	}

	public function __set( $name, $value )
	{
		if ( $name == 'view_template_file' )
		{
			throw new Exception( "Cannot bind variable named 'view_template_file'" );
		}
		$this->vars[ $name ] = $value;
	}

	public function render( $view_template_file )
	{
		if ( array_key_exists( 'view_template_file', $this->vars ) )
		{
			throw new Exception( "Cannot bind variable called 'view_template_file'" );
		}
		extract( $this->vars );
		ob_start();
		include( $view_template_file );

		return ob_get_clean();
	}
}