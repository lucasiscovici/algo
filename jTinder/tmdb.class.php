<?
  /** A PHP class to access MySQL database with convenient methods
    * in an object oriented way, and with a powerful debug system.\n
    * Licence:  LGPL \n
    * Web site: http://slaout.linux62.org/
    * @version  1.0
    * @author   S&eacute;bastien Lao&ucirc;t (slaout@linux62.org)
    */
  include "usefull.php";
  class TMDB
  {
    // variables
  
    var $api_key;
    var $api_url;
    var $api_version;
    var $language;
    var $paged;

  public $debug = false;

    /** Connect to a MySQL database to be able to use the methods below.
      */
    function TMDB()
    {
      $this->api_key="6d45b0e8affb0f8d61d4e0dbe4ebdc27";
      $this->api_url = "https://api.themoviedb.org";
      $this->api_version = "3";
      $this->language = 'fr';
      $this->paged = true;
        
    }
  
 function send_request($method, $params = array(), $data = array()) {

    $params = $this->params_merge($params);

    $query = http_build_query($params);

    $url = $this->api_url . '/' . $this->api_version . '/' . $method . '?' . $query;
    $ch = curl_init();

    if ($ch) {
      curl_setopt_array($ch, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HEADER => false,
        CURLOPT_FAILONERROR => true,
        CURLOPT_HTTPHEADER => array(
          'Accept: application/json',
          'Content-type: application/json'
        ) ,
      ));
      if ($this->debug) {
        error_log("DEBUG: Calling URL: {$url}");
      }
      if (!empty($data) && is_array($data)) {
        if ($this->debug) {
          error_log("DEBUG: POSTDATA: " . var_export($data, true));
        }
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
      }
      $results = curl_exec($ch);
      $response->headers = curl_getinfo($ch);
      if ($results) {
        $response->data = json_decode($results);
        if (!$this->paged && isset($response->data->total_pages) && $response->data->page < $response->data->total_pages) {
          $paged_response = $this->send_request($method, $params + array(
            'page' => $response->data->page + 1
          ));
          if (!$paged_response->error) {
            $response->data->page = 1;
            $response->data->results = array_merge($response->data->results, $paged_response->data->results);
            $response->data->total_pages = 1;
          } else {
            $results = array();
            $this->error = $response->error;
            curl_close($ch);
            return $results;
          }
        }
        $response->error = false;
      } else {
        $response->data = false;
        $response->error = array(
          'code' => curl_errno($ch) ,
          'message' => curl_error($ch)
        );
      }
      curl_close($ch);
    } else {
      $response->error = array(
        'code' => - 1,
        'message' => 'Failed to init CURL'
      );
    }
    $this->response = $response;
    return $response;
  
 }
function find($list,$field,$text,$n="name"){
  // print_r($list);
  $d=array();
  foreach ($list as $key => $value) {
        // print_r($key."\n");
  
    if ($value->job==$text) {
      
      array_push($d,$value->$n); 
    }

  }
  return $d;
}
 public function info($type, $id, $method = false, $params = array()) {
    $result = array();
    if ($method) {
      $response = $this->send_request($type . '/' . $id . '/' . $method, $params);
    } else {
      $response = $this->send_request($type . '/' . $id, $params);
    }
    if (!$response->error) {
      $result = $response->data;
    } else {
      $this->error = $response->error;
    }
    return $result;
  }
   public function info_credits($type,$value){
     if (Type($value) == 'array'){
      $value=$value["tmdb_id"];
    }
      return $GLOBALS["TMDB"]->info($type,$value,"credits");

 }
     public function people_crew($type,$value){
       if (Type($value) == 'array'){
      $value=$value["tmdb_id"];
    }
      return $GLOBALS["TMDB"]->info($type,$value,"movie_credits")->crew;

 } 
 public function people_cast($type,$value){
       if (Type($value) == 'array'){
      $value=$value["tmdb_id"];
    }
      return $GLOBALS["TMDB"]->info($type,$value,"movie_credits")->cast;

 }
    public function info_cast($type,$value){
       if (Type($value) == 'array'){
      $value=$value["tmdb_id"];
    }
      return $GLOBALS["TMDB"]->info($type,$value,"credits")->cast;

 }
 public function info_real($type,$value){
       if (Type($value) == 'array'){
      $value=$value["tmdb_id"];
    }
      return $GLOBALS["TMDB"]->people_crew($type,$value);

 }
 public function info_images($type,$value){
  // print_r($value);
      return $GLOBALS["TMDB"]->info($type,$value,"images");

 }
 public function info_posters($type,$value){
  $images=$GLOBALS["TMDB"]->info_images($type,$value);
      return $images->posters;

 }
  public function info_genres($type,$value=0,$info=0){
    if (Type($value) == 'array'){
      $value=$value["tmdb_id"];
    }
    // print_r("\n".$info." ".$value."\n");

    if ($info==0 && $value != -1) {
// print_r("la");
      return $GLOBALS["TMDB"]->info($type,$value)->genres;
    }else{
      return $type->genres;

    }

 }
 
  public function search($type, $params, $expand = false) {
    $results = array();
    // print_r($params);
    $response = $this->send_request('search/' . $type, $params);
    
    return $response;
  }
  function info_title($info){
    return  $info->title;
  }
  function info_id($info){
    return  $info->id;
  }
  function info_href($id){
    global $type;
    $info=$GLOBALS["TMDB"]->info_posters($type,$id);
    // print_r($info);
    $url="http://image.tmdb.org/t/p/w780";
    $ij=$info[0]->file_path;
    $url=$url.$ij;
    return $url;
  }
 function params_merge($params) {
    $defaults = $defaults = array(
      'api_key' => $this->api_key,
      'language' => $this->language,
    );
    $result = $defaults;
    foreach ($params as $key => $value) {
      if (!is_null($value)) { // overwrite all values in array1 with array2, except when its null (array_merge or + does not do this)
        $result[$key] = $value;
      }
    }
    // Filter out empty string keys
    foreach ($result as $key => $value) {
      if ($value == '') {
        unset($result[$key]);
      }
    }
    return $result;
  }


    /** Query the database.
      * @param $query The query.
      * @param $debug If true, it output the query and the resulting table.
      * @return The result of the query, to use with fetchNextObject().
 */
  } $GLOBALS["TMDB"] = new TMDB();

?>
