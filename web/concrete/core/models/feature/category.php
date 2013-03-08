<?
defined('C5_EXECUTE') or die("Access Denied.");
abstract class Concrete5_Model_FeatureCategory extends Object {

	abstract public function assignmentIsInUse(FeatureAssignment $fa);
	
	public static function getByID($fcID) {
		$db = Loader::db();
		$row = $db->GetRow('select fcID, fcHandle, pkgID from FeatureCategories where fcID = ?', array($fcID));
		if (isset($row['fcID'])) {
			$class = Loader::helper('text')->camelcase($row['fcHandle']) . 'FeatureCategory';
			$fe = new $class();
			$fe->setPropertiesFromArray($row);
			return $fe;
		}
	}
	
	public static function getByHandle($fcHandle) {
		$db = Loader::db();
		$row = $db->GetRow('select fcID, fcHandle, pkgID from FeatureCategories where fcHandle = ?', array($fcHandle));
		if (isset($row['fcID'])) {
			$class = Loader::helper('text')->camelcase($row['fcHandle']) . 'FeatureCategory';
			$fe = new $class();
			$fe->setPropertiesFromArray($row);
			return $fe;
		}
	}

	public static function getListByPackage($pkg) {
		$db = Loader::db();
		$list = array();
		$r = $db->Execute('select fcID from FeatureCategories where pkgID = ? order by fcID asc', array($pkg->getPackageID()));
		while ($row = $r->FetchRow()) {
			$fe = FeatureCategory::getByID($row['fcID']);
			if (is_object($fe)) {
				$list[] = $fe;
			}
		}
		$r->Close();
		return $list;
	}	

	public static function getList() {
		$db = Loader::db();
		$list = array();
		$r = $db->Execute('select fcID from FeatureCategories order by fcID asc');
		while ($row = $r->FetchRow()) {
			$fe = FeatureCategory::getByID($row['fcID']);
			if (is_object($fe)) {
				$list[] = $fe;
			}
		}
		$r->Close();
		return $list;
	}	
	
	public function getFeatureCategoryID() {return $this->fcID;}
	public function getFeatureCategoryHandle() {return $this->fcHandle;}
	public function getPackageID() {return $this->pkgID;}
	public function getPackageHandle() {return PackageList::getHandle($this->pkgID);}

	public static function add($fcHandle, $pkg = false) {
		$db = Loader::db();
		$pkgID = 0;
		if (is_object($pkg)) {
			$pkgID = $pkg->getPackageID();
		}
	
		$db->Execute('insert into FeatureCategories (fcHandle, pkgID) values (?, ?)', array($fcHandle, $pkgID));
		$id = $db->Insert_ID();
		
		$fe = FeatureCategory::getByID($id);
		return $fe;
	}


	public function export($fxml) {
		$fe = $fxml->addChild('featurecategory');
		$fe->addAttribute('handle',$this->getFeatureCategoryHandle());
		$fe->addAttribute('package', $this->getPackageHandle());
		return $fe;
	}

	public static function exportList($xml) {
		$fxml = $xml->addChild('featurecategories');
		$db = Loader::db();
		$r = $db->Execute('select fcID from FeatureCategories order by fcID asc');
		$list = array();
		while ($row = $r->FetchRow()) {
			$fe = FeatureCategory::getByID($row['fcID']);
			if (is_object($fe)) {
				$list[] = $fe;
			}
		}
		foreach($list as $fe) {
			$fe->export($fxml);
		}
	}

	public function delete() {
		$db = Loader::db();
		$db->Execute('delete from FeatureCategories where fcID = ?', array($this->fcID));
	}
	
		
}
