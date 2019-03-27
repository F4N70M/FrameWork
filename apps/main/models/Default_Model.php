<?php
	/**
	 * @author: KONARD
	 * @version: 1.0
	 */
	
	namespace apps\main\models;
	
	
	use fw\App\Controller;
	use fw\DI\DI;
	
	class Default_Model extends Controller
	{
		public function __construct(DI $DI, array $route)
		{
			parent::__construct($DI, $route);
		}
	}