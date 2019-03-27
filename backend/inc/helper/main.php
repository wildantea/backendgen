<?php
function session_check()
{
  if (empty($_SESSION['login'])) {
    echo "die";
    exit();
  }
}

function session_check_end() {
    if (empty($_SESSION['login'])) {
    echo "<script>alert('Sessio Anda Telah Habis'); window.location = '".base_url()."';</script>";
    exit();
  }
}

function session_check_json()
{
 if (empty($_SESSION['login'])) {
    $json_response = array();
    $status['status'] = "die";
    array_push($json_response, $status);
    echo json_encode($json_response);
    exit();
  }
}

    //url parsing
    function parse_path()
    {
        $path = array();
        if (isset($_SERVER['REQUEST_URI'])) {
            $request_path = explode('?', $_SERVER['REQUEST_URI']);
            
            $path['base']      = rtrim(dirname($_SERVER['SCRIPT_NAME']), '\/');
            $path['call_utf8'] = substr(urldecode($request_path[0]), strlen($path['base']) + 1);
            $path['call']      = utf8_decode($path['call_utf8']);
            if ($path['call'] == basename($_SERVER['PHP_SELF'])) {
                $path['call'] = '';
            }
            $path['call_parts'] = explode('/', $path['call']);
            
            
            if ($request_path[1] = '') {
                $path['query_utf8'] = urldecode($request_path[1]);
                $path['query']      = utf8_decode(urldecode($request_path[1]));
                $vars               = explode('&', $path['query']);
                foreach ($vars as $var) {
                    $t                         = explode('=', $var);
                    $path['query_vars'][$t[0]] = $t[1];
                }
            }
        }
        return $path;
    }

function uri_segment($segment)
{
    //url path
    $path = parse_path();
    if (isset($path['call_parts'][$segment])) {
        return $path['call_parts'][$segment];
    }
}


//submit form action json response 
function action_response($error_message,$custom_response=array()) {
    $json_response = array();
    if ($error_message=='') {
        $status['status'] = "good";
        if (!empty($custom_response)) {
       foreach ($custom_response as $key => $value) {
          $status[$key] = $value;
       }

      }

     } else {
        $status['status'] = "error";
        $status['error_message'] = $error_message;
     }
    array_push($json_response, $status);
    echo json_encode($json_response);
    exit();
}
//for admin only
function session_check_adm()
{
  if ($_SESSION['group_level']!='root') {
  exit();
  }
}
//redirection 
function redirect($var)
{
  header("location:".$var);
}


//root directory web
function base_url()
{
  $root='';
  $protocol = isset($_SERVER["HTTPS"]) ? 'https://' : 'http://';
  $root = $protocol.$_SERVER['HTTP_HOST'];
  //$root .= dirname($_SERVER['SCRIPT_NAME']);
  $root .= DIR_MAIN."/";
  return $root;
}

//root url api
function base_url_api()
{
  $root='';
  $protocol = isset($_SERVER["HTTPS"]) ? 'https://' : 'http://';
  $root = $protocol.$_SERVER['HTTP_HOST'];
  //$root .= dirname($_SERVER['SCRIPT_NAME']);
  $root .= "/".DIR_API."/";
  return $root;
}


//base admin is url until admin dir, ex:http://localhost/backend/admina
function base_admin()
{
  $root='';
  $protocol = isset($_SERVER["HTTPS"]) ? 'https://' : 'http://';
  $root = $protocol.$_SERVER['HTTP_HOST'];
  $root .= "/".DIR_ADMIN."/";
  return $root;
}

//base admin is url until index.php, ex:http://localhost/backend/admina/index.php
function base_index()
{
  $root='';
   $protocol = isset($_SERVER["HTTPS"]) ? 'https://' : 'http://';
  $root = $protocol.$_SERVER['HTTP_HOST'];
  //$root .= str_replace(basename($_SERVER['SCRIPT_NAME']),"",$_SERVER['SCRIPT_NAME']);
   $root .= "/".DIR_ADMIN."/";
  //$root .='index.php/';
  return $root;
}

function validateDate($date, $format = 'Y-m-d')
{
    $d = DateTime::createFromFormat($format, $date);
    // The Y ( 4 digits year ) returns TRUE for any integer with any number of digits so changing the comparison from == to === fixes the issue.
    return $d && $d->format($format) === $date;
}

function validateDateTime($date, $format = 'Y-m-d H:i:s')
{
    $d = DateTime::createFromFormat($format, $date);
    // The Y ( 4 digits year ) returns TRUE for any integer with any number of digits so changing the comparison from == to === fixes the issue.
    return $d && $d->format($format) === $date;
}
/**
 * return indonesian date format 
 * @param  text $date date text 2019-07-02
 * @return text       indonesian format 2 januari 2019
 */
function tgl_indo($date) { // fungsi atau method untuk mengubah tanggal ke format indonesia
  if (validateDate($date)) {
       // variabel BulanIndo merupakan variabel array yang menyimpan nama-nama bulan
      $BulanIndo = array("Januari", "Februari", "Maret",
                 "April", "Mei", "Juni",
                 "Juli", "Agustus", "September",
                 "Oktober", "November", "Desember");
    
      $tahun = substr($date, 0, 4); // memisahkan format tahun menggunakan substring
      $bulan = substr($date, 5, 2); // memisahkan format bulan menggunakan substring
      $tgl   = substr($date, 8, 2); // memisahkan format tanggal menggunakan substring
      
      $result = $tgl . " " . $BulanIndo[(int)$bulan-1] . " ". $tahun;
      return($result);
  } else {
    return '';
  }

}


function tgl_time($date) { // fungsi atau method untuk mengubah tanggal ke format indonesia
  if (validateDateTime($date)) {
       // variabel BulanIndo merupakan variabel array yang menyimpan nama-nama bulan
      $BulanIndo = array("Januari", "Februari", "Maret",
                 "April", "Mei", "Juni",
                 "Juli", "Agustus", "September",
                 "Oktober", "November", "Desember");
    
      $tahun = substr($date, 0, 4); // memisahkan format tahun menggunakan substring
      $bulan = substr($date, 5, 2); // memisahkan format bulan menggunakan substring
      $tgl   = substr($date, 8, 2); // memisahkan format tanggal menggunakan substring
      $time = substr($date, -8);
      
      $result = $tgl . " " . $BulanIndo[(int)$bulan-1] . " ". $tahun.' '.$time;
      return($result);
  } else {
    return '';
  }

}

/**
 * [trimmer trim for import excel
 *
 * @param  [type] $excel column value
 * @return [type]  trimmed value
 */
function trimmer($value)
{
    $result = preg_replace('/[^[:print:]]/', '', filter_var($value, FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_LOW|FILTER_FLAG_STRIP_HIGH));
    return addslashes(trim($result));
}


/*function diff_array($array_first,$array_second) {
  if (count($array_first)>count($array_second)) {
  //delete 
  $data = array_map('unserialize', array_diff(array_map('sortAndSerialize', $array_first), array_map('sortAndSerialize', $array_second)));
  return  array('status' => 'del','data' => $data);
  } else {
  $data = array_map('unserialize', array_diff(array_map('sortAndSerialize', $array_second), array_map('sortAndSerialize', $array_first)));
  return  array('status' => 'add','data' => $data);
  }

}*/
?>