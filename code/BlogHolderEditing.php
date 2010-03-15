<?php
/**
 * Decorates BlogHolder and BlogTree to hide (ShowInMenus = false) by default 
 */ 
class BlogHolderEditing extends DataObjectDecorator {
	
	function extraStatics() {
		return array(
			'defaults' => array(
				'ShowInMenus' => false
			)
		);
	}
	
}