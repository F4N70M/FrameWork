<?php
/**
 * @author: KONARD
 * @version: 1.0
 */

namespace Fw\Helper;


class Common
{
	/**
	 */
	public static function print()
	{
		// массив переданных аргументов
		$args = func_get_args();

		echo /** @lang text */
		'<pre style="
			font-size: 1.2rem;
			width:calc(100% - 4rem);
			padding: 2rem;
			overflow:auto;
			background-color: rgb(241,241,241);
			color: rgb(0,0,0);
		">';

		foreach ($args as $key => $arg)
		{
			if ( is_object($arg) )
			{
				print_r($arg);
				continue;
			}
			
			$arg = self::tags_to_code($arg);
			
			//var_dump('ARG: ', $arg);

			if ( empty($arg) || $arg === true )
			{
				var_dump( $arg );
			}
			else
			{
				$arg = self::json([$arg],true);

				$arg = preg_replace('#([\:\[\,])(true|false)#', '$1"bool($2)"', $arg);
				$arg = preg_replace('#([\:\[\,])null#', '$1"NULL"', $arg);
				$arg = preg_replace('#([\:\[\,])\"\"#', '$1"sting(0) \"\""', $arg);

				$arg = self::json($arg,false)[0];

				print_r($arg);
			}

			if( $key < count($args) - 1 || ( $key == count($args) - 1 && ( !is_array($arg) && !is_object($arg) ) ) )
			{
				echo PHP_EOL;
			}
		}

		$debug = debug_backtrace();
		echo /** @lang text */
		"\r\n<span style=\"color: rgb(136, 136, 136);\">"
		. "0: " . str_replace('\\', '/', $debug[0]['file']) . " : " . $debug[0]['line'] . "\r\n";
		if ( isset($debug[1]['file']) )
		{
			echo /** @lang text */
			"1: " . str_replace('\\', '/', $debug[1]['file'] ) . " : " . $debug[1]['line'];
		}
		echo /** @lang text */
		"</span></pre>";
	}

	/**
	 * @param $string
	 * @return string
	 */
	public static function tags_to_code($string)
	{
		$objectAsArray = is_object( $string ) ? false : true;
		$string = [$string];
		$string = self::json($string,true);

		$string = str_replace('<', '&lt;', $string);
		$string = str_replace('>', '&gt;', $string);

		$string = self::json($string,false, $objectAsArray);
		$string = $string[0];

		return $string;
	}


	/**
	 * @param $string
	 * @return bool
	 */
	public static function is_json($string){
		return is_string($string) && is_array(json_decode($string, true)) ? true : false;
	}


	/**
	 * @param $json
	 * @param mixed $polus
	 * @param bool $objectAsArray
	 * @return false|mixed|string
	 */
	public static function json( $json, bool $polus=null, bool $objectAsArray=true )
	{
		$is_json = self::is_json( $json );

		//	Если ( Принудительно кодировать и Это уже json ) или ( Принудительно декодировать и Это не json )
		if ( ( $polus === true && $is_json ) || ( $polus === false && !$is_json ) )
		{
			return $json;
		}
		else
		{
			//	Декодировать
			if ( $is_json )
			{
				return json_decode( $json, $objectAsArray );
			}
			//	Кодировать
			else
			{
				//if ( in_array($json, ) )
				return json_encode( $json, JSON_UNESCAPED_UNICODE );
			}
		}
	}
}