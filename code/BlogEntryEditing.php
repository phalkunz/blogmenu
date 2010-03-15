<?php 
class BlogEntryEditing extends DataObjectDecorator {
	
	static $blog_menu_class = "BlogMenu";

	function extraStatics() {
		return array(
			'belongs_many_many' => array(
				'BlogMenus' => self::$blog_menu_class
			)
		);
	}
	
	function updateCMSFields(&$fields) {	
		$categoriesField = new TreeMultiselectField("Menu", "Menu", self::$blog_menu_class);
		$categoriesField->setFilterFunction(array($this, "setCustomMarkingFilter"));

		$fields->addFieldToTab("Root.Content.Menu", $categoriesField);
	}
	
	/**
	 * Show only BlogMenu page type in TreeMultiselectField
	 */
	function setCustomMarkingFilter($node) {
		if($node->ClassName ==  self::$blog_menu_class) {
			return true;
		}
		
		return false;
	}

}