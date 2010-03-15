<?php
class BlogHolderEditingTest extends SapphireTest {
	
	public function testBlogTreeCreation() {
		$blogTree = new BlogTree(); 
		
		// Hidden from navigation menus by default
		$this->assertFalse($blogTree->ShowInMenus);
	}
	
	public function testBlogHolderCreation() {
		$blogHolder = new BlogHolder(); 
		
		// Hidden from navigation menus by default
		$this->assertFalse($blogHolder->ShowInMenus);
	}
	
}