<?php
class TcAjaxPager extends TcBase {

	function test_cleaning_page_size(){
		$controller = new Atk14Controller();
		$controller->params = new Dictionary();

		$ap = new AjaxPager($controller);
		$this->assertEquals(30,$ap->options["page_size"]);
		$this->assertEquals([30],$ap->options["page_size_possibilities"]);

		$ap = new AjaxPager($controller,[
			"page_size" => 20,
		]);
		$this->assertEquals(20,$ap->options["page_size"]);
		$this->assertEquals([20],$ap->options["page_size_possibilities"]);

		$ap = new AjaxPager($controller,[
			"page_size" => null
		]);
		$this->assertEquals(30,$ap->options["page_size"]);
		$this->assertEquals([30],$ap->options["page_size_possibilities"]);

		$ap = new AjaxPager($controller,[
			"page_size" => "nonsence"
		]);
		$this->assertEquals(30,$ap->options["page_size"]);
		$this->assertEquals([30],$ap->options["page_size_possibilities"]);


		$ap = new AjaxPager($controller,[
			"page_size_possibilities" => [11,22,33],
		]);
		$this->assertEquals(11,$ap->options["page_size"]);
		$this->assertEquals([11,22,33],$ap->options["page_size_possibilities"]);

		$ap = new AjaxPager($controller,[
			"page_size" => 22,
			"page_size_possibilities" => [11,22,33],
		]);
		$this->assertEquals(22,$ap->options["page_size"]);
		$this->assertEquals([11,22,33],$ap->options["page_size_possibilities"]);

		$ap = new AjaxPager($controller,[
			"page_size" => 999,
			"page_size_possibilities" => [11,22,33],
		]);
		$this->assertEquals(11,$ap->options["page_size"]);
		$this->assertEquals([11,22,33],$ap->options["page_size_possibilities"]);

		$ap = new AjaxPager($controller,[
			"page_size" => "nonsence",
			"page_size_possibilities" => [11,22,33],
		]);
		$this->assertEquals(11,$ap->options["page_size"]);
		$this->assertEquals([11,22,33],$ap->options["page_size_possibilities"]);

		// Getting page_size automatically from $controller->params
		$controller->params["page_size"] = "34";
		$ap = new AjaxPager($controller,[
			"page_size_possibilities" => [14,24,34],
		]);
		$this->assertEquals(34,$ap->options["page_size"]);
		$this->assertEquals([14,24,34],$ap->options["page_size_possibilities"]);

		$controller->params["page_size"] = "999";
		$ap = new AjaxPager($controller,[
			"page_size_possibilities" => [14,24,34],
		]);
		$this->assertEquals(14,$ap->options["page_size"]);
		$this->assertEquals([14,24,34],$ap->options["page_size_possibilities"]);

		$controller->params["page_size"] = "34";
		$ap = new AjaxPager($controller,[
			// page_size_possibilities is not set -> page_size couldn't be taken from $controller->params
		]);
		$this->assertEquals(30,$ap->options["page_size"]);
		$this->assertEquals([30],$ap->options["page_size_possibilities"]);
	}

	function test(){
		$controller = new Atk14Controller();
		$controller->params = new Dictionary();
		$controller->request = $GLOBALS["HTTP_REQUEST"];

		$sorting = new Atk14Sorting();
		$sorting->add("default", "created_at DESC, id DESC",[
			"title" => "Recommended",
		]);
		$sorting->add("price", "price DESC, id DESC",[
			"title" => "Price",
		]);
		$ap = new AjaxPager($controller,[
			"sorting" => $sorting,
			"page_size_possibilities" => [24,48,72],
		]);

		// --

		$sorting_possibilities = $ap->getSortingPossibilities();

		$this->assertEquals(2,sizeof($sorting_possibilities));

		$this->assertEquals("Recommended",$sorting_possibilities[0]->getTitle());
		$this->assertEquals(true,$sorting_possibilities[0]->isActive());

		$this->assertEquals("Price",$sorting_possibilities[1]->getTitle());
		$this->assertEquals(false,$sorting_possibilities[1]->isActive());

		$active_sorting = $ap->getActiveSorting();
		$this->assertEquals("Recommended",$active_sorting->getTitle());

		// --

		$page_size_possibilities = $ap->getPageSizePossibilities();

		$this->assertEquals(3,sizeof($page_size_possibilities));

		$this->assertEquals("24",$page_size_possibilities[0]->getTitle());
		$this->assertEquals(true,$page_size_possibilities[0]->isActive());

		$this->assertEquals("48",$page_size_possibilities[1]->getTitle());
		$this->assertEquals(false,$page_size_possibilities[1]->isActive());

		$this->assertEquals("72",$page_size_possibilities[2]->getTitle());
		$this->assertEquals(false,$page_size_possibilities[2]->isActive());

		$active_page_size = $ap->getActivePageSize();
		$this->assertEquals("24",$active_page_size->getTitle());
	}
}
