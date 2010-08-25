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
		$categoriesField = new CheckboxSetField("BlogMenus", "Menu", DataObject::get('BlogMenu'));

		$fields->addFieldToTab("Root.Content.Menu", $categoriesField);
	}

}