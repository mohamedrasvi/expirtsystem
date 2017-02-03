<?php 

/**
 * 
 * Search Facebook Open Graph
 * 
 * Search will retuen public results only,
 * To get better results use an Access Token with your request
 * @author Roy
 *
 */
class facebookSearcher
{
	
	protected	$_access_token;
	protected	$_query;
	/**
	 * 
	 * @var string
	 * Used types are: event, place, post, page, group, checkin
	 */
	protected	$_type;
	protected	$_limit;
	protected	$_nextPage;
	protected	$_previousPage;
	
	/**
	 * 
	 * Setters
	 */
	public function setAccessToken($value) {
		$this->_access_token = $value; return $this;
	}
	public function setQuery($value) {
		$this->_query = $value; return $this;
	}
	public function setLimit($value) {
		$this->_limit = $value; return $this;
	}
	public function setType($value) {
		$this->_type = $value; return $this;
	}
	
	/**
	 * 
	 * Get a link to the Previous results page
	 */
	public function getPreviousPage() {
		return $this->_previousPage;
	}
	
	/**
	 * 
	 * Get a link to the Next results page
	 */
	public function getNextPage() {
		return $this->_nextPage;
	}
	
	/**
	 * 
	 * Build Graph Qurey
	 * @return string Graph-URL
	 */
	protected function buildQueryUrl()
	{
		//Validate
		if(empty($this->_query)) throw new Exception("Query Not Set");
		
		//Build URL
		$graphURL = "https://graph.facebook.com/search?q=".urlencode($this->_query);
		if(isset($this->_type)) $graphURL .= "&type={$this->_type}";
		if(isset($this->_limit)) $graphURL .= "&limit={$this->_limit}";
		$graphURL .= "&access_token=".$this->_access_token;
		return $graphURL;
	}
	
	/**
	 * 
	 * Fetch Query Results
	 * @return Object
	 */
	public function fetchResults()
	{
		$result = json_decode(file_get_contents( $this->buildQueryUrl() ));
		//Load Previous and Next Pages
		$this->_nextPage = $result->paging->next;
		$this->_previousPage = $result->paging->previous;
		
		return $result;
	} 
		
	
}//EOC


?>