<?php
class BlogMenuTest extends SapphireTest {
	static $fixture_file = 'blogmenu/tests/BlogMenuTest.yml';
	
	function testBuildJoinClause() {
		$blogMenu = new MockBlogMenu();
		$blogMenu->write();
		$joinClause = $blogMenu->buildJoinClause();
		
		$this->assertEquals("LEFT JOIN BlogMenu_MenuEntries ON SiteTree.ID = BlogMenu_MenuEntries.BlogEntryID", $joinClause);
	}
	
	function testBuildWhereClause() {
		$method = "buildWhereClause";
		
		$whereClause = $this->getObjectAndCall('MockBlogMenu', 'MenuOne', $method);
		$this->assertEquals("BlogMenu_MenuEntries.BlogMenuID IN (1)", $whereClause);
		
		$whereClause = $this->getObjectAndCall('MockBlogMenu', 'MenuTwo', $method);
		$this->assertEquals("BlogMenu_MenuEntries.BlogMenuID IN (4,5,7,8,6,2)", $whereClause);
		
		$whereClause = $this->getObjectAndCall('MockBlogMenu', 'MenuThree', $method);
		$this->assertEquals("BlogMenu_MenuEntries.BlogMenuID IN (9,10,3)", $whereClause);
	}
	
	function testGetDescendantIDs() {
		$method = "getDescendantIDs";
		
		$ids = $this->getObjectAndCall('MockBlogMenu', 'MenuOne', $method);
		$this->assertTrue(empty($ids));
		
		$ids = $this->getObjectAndCall('MockBlogMenu', 'MenuTwo', $method);
		$this->assertTrue($this->arrayEqual(array(4,5,6,7,8), $ids));
		
		$ids = $this->getObjectAndCall('MockBlogMenu', 'MenuThree', $method);
		$this->assertTrue($this->arrayEqual(array(9,10), $ids));
	}
	
	function testGetAllIDs() {
		$method = "getAllIDs";
		
		$ids = $this->getObjectAndCall('MockBlogMenu', 'MenuOne', $method);
		$this->assertTrue($this->arrayEqual(array(1), $ids));
		
		$ids = $this->getObjectAndCall('MockBlogMenu', 'MenuTwo', $method);
		$this->assertTrue($this->arrayEqual(array(2,4,5,6,7,8), $ids));
		
		$ids = $this->getObjectAndCall('MockBlogMenu', 'MenuThree', $method);
		$this->assertTrue($this->arrayEqual(array(3,9,10), $ids));
	}
	
	function testBlogHolderIDs() {
		$method = "BlogHolderIDs";
		
		$ids = $this->getObjectAndCall('MockBlogMenu', 'MenuOne', $method);
		$this->assertTrue($this->arrayEqual(array(101), $ids));
		
		$ids = $this->getObjectAndCall('MockBlogMenu', 'MenuTwo', $method);
		$this->assertTrue($this->arrayEqual(array(101, 102), $ids));
		
		$ids = $this->getObjectAndCall('MockBlogMenu', 'MenuTwoOne', $method);
		$this->assertTrue($this->arrayEqual(array(102), $ids));
		
		$ids = $this->getObjectAndCall('MockBlogMenu', 'MenuTwoTwo', $method);
		$this->assertTrue($this->arrayEqual(array(), $ids));
		
		$ids = $this->getObjectAndCall('MockBlogMenu', 'MenuTwoTwoOne', $method);
		$this->assertTrue($this->arrayEqual(array(), $ids));
		
		$ids = $this->getObjectAndCall('MockBlogMenu', 'MenuTwoTwoTwo', $method);
		$this->assertTrue($this->arrayEqual(array(101), $ids));
		
		$ids = $this->getObjectAndCall('MockBlogMenu', 'MenuThree', $method);
		$this->assertTrue($this->arrayEqual(array(102), $ids));
		
		$ids = $this->getObjectAndCall('MockBlogMenu', 'MenuThreeOne', $method);
		$this->assertTrue($this->arrayEqual(array(), $ids));
		
		$ids = $this->getObjectAndCall('MockBlogMenu', 'MenuThreeTwo', $method);
		$this->assertTrue($this->arrayEqual(array(102), $ids));
	}
	
	function testCustomEntries() {
		$method = "customEntries";
		$params = array('BlogEntry');
		
		$dos = $this->getObjectAndCall('MockBlogMenu', 'MenuOne', $method, $params);
		$titles = $dos->map();
		$this->assertTrue($this->arrayEqual(array("BlogEntry Two"), $titles));
		
		$dos = $this->getObjectAndCall('MockBlogMenu', 'MenuTwo', $method, $params);
		$titles = $dos->map();
		$this->assertTrue($this->arrayEqual(array("BlogEntry One", "BlogEntry Three", "BlogEntry Four"), $titles));
		
		$dos = $this->getObjectAndCall('MockBlogMenu', 'MenuThree', $method, $params);
		$titles = $dos->map();
		$this->assertTrue($this->arrayEqual(array("BlogEntry Four", "BlogEntry Five"), $titles));
	}
	
	/** 
	 * Test Helper function
	 * Compare 2 arrays. Return true when they are equals, have the elements and return false otherwise. 
	 * @return	array
	 */
	private function arrayEqual($array1, $array2) {
		$diff = array_diff($array1, $array2);
		if(empty($diff)) return true;
		
		return false;
	}
	
	/** 
	 * Get an object from the fixture, call the specified method (with params) and return the result
	 * @param	string
	 * @param	string
	 * @param	string
	 * @param	array 
	 * @return 	mixed 
	 */
	private function getObjectAndCall($class, $instance, $method, $params = array()) {
		$obj = $this->fixture->objFromFixture($class, $instance);
		return call_user_func_array (array($obj, $method), $params);
	}
}

/**
 * This is a Mock Object for BlogMenu class for testing private and protected methods 
 */ 
class MockBlogMenu extends BlogMenu {

	public function buildJoinClause() {
		return parent::buildJoinClause();
	}
	
	public function buildWhereClause() {
		return parent::buildWhereClause();
	}
	
}