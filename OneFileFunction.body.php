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
				
		/*
			https://
			http://
			ftp://
			if ($alt_name)
				$output = "[$file $alt_name]";
			else
				$output = $file;
			
			
			File:My File.pdf
			w:File:A File.pdf
			
			
			
			
			C:/User/document.doc
			C://User/document.doc
			C:\User\document.doc
			C:\\User\document.doc
		 */

		if ( strpos($file,"File:")===0 )
			return self::get_mediawiki_link($file, $alt_name);
		
		else if ( strpos($file,":File:")>0 )
			return self::get_interwiki_link($file, $alt_name);
			
		else if ( strpos($file,"http")===0 || strpos($file,"ftp")===0 )
			return self::get_web_link($file, $alt_name);
		
		else //is file system link??
			return self::get_file_system_link($file, $alt_name);
		
		
		return $output;
	}

	/**
	 *  Code to take the following two formats:
	 * 
	 *    (1)   File:A file.pdf
	 *    (2)   Wikipedia:File:A File.pdf
	 *
	 *  and replace it with either:
	 *
	 *    (1)   Media:A file.pdf
	 *    (2)   Wikipedia:Media:A file.pdf
	 */	
	// BROKEN! Wikipedia:Media:A file.pdf DOES NOT LINK DIRECTLY TO THE FILE!
	static function replace_file_with_media ($file) {
		return str_replace(":File:", ":Media:", $file);
	}
	
	static function get_mediawiki_link ($file, $alt_name=false, $show_file_info=true) {
	
		$media_name = self::replace_file_with_media($file);
		$alt_name = $alt_name ? $alt_name : $media_name;
		$file_info = $show_file_info ? self::get_superscript_file_info($file) : "";
	
		$output = "[[$media_name|$alt_name]]$file_info";
						
		return $output;

	}
	
	// unfortunately cannot easily directly link to a file of an interwiki...see above
	static function get_interwiki_link ($file, $alt_name=false) {
		
		if ( ! $alt_name ) {
			// strip interwiki label off the front?
		}
		
		// for now just use the same method as a local wikilink
		// until I figure out how to get a direct link to the file
		// on an interwiki
		return self::get_mediawiki_link($file, $alt_name, false);

	}
	
	static function get_superscript_file_info ($file) {
	
		// use leading colon (i.e. ":File:Filename.pdf") to force a link to the 
		// file's wikipage.
		$output = "<sup> <nowiki>[</nowiki>[[:$file|file info]]<nowiki>]</nowiki></sup>";

		return $output;
	}
	
}