<?php
/**
 * Creating a unified method of linking to files, no matter their location
 * 
 * Documentation: http://???
 * Support:       http://???
 * Source code:   http://???
 *
 * @file OneFileFunction.body.php
 * @addtogroup Extensions
 * @author James Montalvo
 * @copyright © 2013 by James Montalvo
 * @licence GNU GPL v3+
 */

class OneFileFunction
{

	static function setup ( &$parser ) {
		
		if ( defined( get_class( $parser ) . '::SFH_OBJECT_ARGS' ) ) {

			$parser->setFunctionHook( 

				'file', 

				array(
					'OneFileFunction',
					'renderOneFileFunctionObj' 
				), 

				SFH_OBJECT_ARGS 
			);

		// SFH_OBJECT_ARGS not defined. Basically the same as above, with a different
		// method used instead
		} else {
			
			$parser->setFunctionHook(
				'file',
				array(
					'OneFileFunction',
					'renderOneFileFunctionNonObj'
				) 
			);
		}

		return true;
		
	}

	static function renderOneFileFunctionNonObj (&$parser, $file, $alt_name=false) {
						
		return self::displayFile( $parser, $file, $alt_name );
		
	}
	
	static function renderOneFileFunctionObj ( &$parser, $frame, $args ) {
		
		$file = $frame->expand( $args[0] );
	
		if ( isset( $args[1] ) )
			$alt_name = trim( $frame->expand( $args[1] ) );
		else
			$alt_name = false;
	
		return self::displayFile( $parser, $file, $alt_name );
	
	}
	

	
	
	
	
	
	static function displayFile ( &$parser, $file, $alt_name=false ) {
				
		

				
		return $output;

	}
	
}