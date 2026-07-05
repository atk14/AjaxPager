<?php
class AjaxPagerSortingPossibility {

	protected $key;
	protected $title;
	protected $active;
	protected $url_params;

	function __construct($options = []){
		$this->key = $options["key"];
		$this->title = $options["title"];
		$this->active = $options["active"];
		$this->url_params = $options["url_params"];
	}

	function getKey(){ return $this->key; }

	function getTitle(){ return $this->title; }

	function isActive(){ return $this->active; }

	function getUrl(){
		return Atk14Url::BuildLink($this->url_params);
	}

	/**
	 * URL do atributu action formulare #filter_form
	 *
	 * Je to URL bez filtracnich parametru a parametru strankovani.
	 */
	function getFilterFormAction(){
		$params = $this->url_params;
		$params = array_filter($params,function($k) { return substr($k,0,2) !== 'f_' && !in_array($k,["offset","count"]); }, ARRAY_FILTER_USE_KEY);
		return Atk14Url::BuildLink($params);
	}
}
