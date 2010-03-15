<?php
/**
 * This class represents the navigation menu for blog entries.
 * A blog entry can appear anywhere in BlogMenu by attaching blog menus to the entry.
 */ 
class BlogMenu extends BlogTree {
	
	/**
	 * This is used for construct a join table name 
	 * It should be overwritten by its subclass
	 */
	private static $class_name = "BlogMenu";
	
	static $many_many = array(
		'MenuEntries' => 'BlogEntry'
	);
	
	static $allowed_children = array(
		'BlogMenu'
	);
	
	/**
	 * Get all blog menus from this menu.
	 * @return DataObjectSet
	 */
	function Entries($limit = '', $tag = '', $date = '', $retrieveCallback = null, $filter = '') {
		return parent::Entries($limit, $tag, $date, array($this, "customEntries"), $filter);
	}
	
	/**
	 * Custom query of blog entries {@see BlogMenu::Entries()}
	 * @return BlogEntries
	 */
	function customEntries($class, $filter = '', $limit = '', $order = '') {
		$join = $this->buildJoinClause();
						
		$filterOp = '';
		$extraFilter = $this->buildWhereClause();
		if(!empty($filter) && !empty($extraFilter)) {
			$filterOp = 'AND';
		}
		$filter .= " {$filterOp} {$extraFilter} ";
						
		return DataObject::get($class, $filter, $order, $join, $limit);
		
	}
	
	/**
	 * Get blog holders' ID of the entries that belong to this menu.
	 * @return 	array
	 */
	public function BlogHolderIDs() {
		$join = $this->buildJoinClause();
		$filter = $this->buildWhereClause(); 
		
		$entries = DataObject::get('BlogEntry', $filter, '', $join);
		
		if(!$entries) return array();
		
		$holderIDs = $entries->map('ID', 'ParentID');
		$holderIDs = array_values($holderIDs);
		$holderIDs = array_unique($holderIDs);
		
		return $holderIDs;
	}
	
	/**
	 * Get this menu's ID and which of its descendants
	 * @return array 
	 */
	public function getAllIDs() {
		$ids = array();
		$ids = $this->getDescendantIDs();
		$ids[] = $this->ID;
		
		return $ids;
	}
	
	/**
	 * Get all decscendent categories' IDs
	 * @return array 
	 */
	public function getDescendantIDs() {
		$ids = array();
		$allChildren = $this->AllChildren();
		
		if($allChildren->Count() > 0) {
			foreach($allChildren as $child) {
				// Do not take object which its class is not a decendant of this class into account
				if (!in_array(self::$class_name, ClassInfo::ancestry($child))) continue;
				
				$ids[] = $child->ID;
				$tempIDs = $child->getDescendantIDs();
				$ids = array_merge($ids, $tempIDs);
			}
		}

		return $ids;
	}
	
	/**
	 * Build JOIN sql clause for querying blog entries
	 * @return 	string
	 */
	protected function buildJoinClause () { 
		$stageSuffix = $this->getStageSuffix(); 
		
		$joinTable = self::$class_name . "_MenuEntries";
		return "LEFT JOIN {$joinTable} ON SiteTree{$stageSuffix}.ID = {$joinTable}.BlogEntryID";
	}
	
	/**
	 * Build WHERE clause for querying blog entries
	 * @return 	string
	 */
	protected function buildWhereClause () {
		$filter = '';
		$joinTable = self::$class_name . "_MenuEntries";
		$catIDs = $this->getAllIDs();
		
		if(!empty($catIDs)) {	
			$catIDString = implode(",", $catIDs);
			$filter = "{$joinTable}.BlogMenuID IN ({$catIDString})";
		}
		
		return $filter;
	}
	
	/**
	 * Get site's current stage suffix 
	 * @return 	string - "_Live" or ""
	 */ 
	private function getStageSuffix() {
		$suffix = '';
		if(Versioned::current_stage() == 'Live') {
			$suffix = "_Live";
		}
		
		return $suffix;
	}
}

class BlogMenu_Controller extends BlogTree_Controller {

}
