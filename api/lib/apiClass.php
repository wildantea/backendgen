<?php
namespace lib;
use \Respect\Validation\Validator as V;
use Respect\Validation\Exceptions\NestedValidationException;

class apiClass
{
    private $pdo;
    /**
     * List of customized messages
     *
     * @var array
     */
    protected $messages = [];

    /**
     * List of returned errors in case of a failing assertion
     *
     * @var array
     */
    protected $error = [];

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
        $this->customErrorMessage();
    }


    //url parsing
   public function parse_path() {
      $path = array();
      if (isset($_SERVER['REQUEST_URI'])) {
        $request_path = explode('?', $_SERVER['REQUEST_URI']);

        $path['base'] = rtrim(dirname($_SERVER['SCRIPT_NAME']), '\/');
        $path['call_utf8'] = substr(urldecode($request_path[0]), strlen($path['base']) + 1);
        $path['call'] = utf8_decode($path['call_utf8']);
        if ($path['call'] == basename($_SERVER['PHP_SELF'])) {
          $path['call'] = '';
        }
        $path['call_parts'] = explode('/', $path['call']);


        if ($request_path[1]='') {
          $path['query_utf8'] = urldecode($request_path[1]);
           $path['query'] = utf8_decode(urldecode($request_path[1]));
        $vars = explode('&', $path['query']);
        foreach ($vars as $var) {
          $t = explode('=', $var);
          $path['query_vars'][$t[0]] = $t[1];
        }
        }


      }
    return $path;
    }


    public function uri_segment($segment)
    {
        //url path
        $path = $this->parse_path();
        if (isset($path['call_parts'][$segment])) {
            return $path['call_parts'][$segment];
        }
    }


    
    /**
     * Set the user subscription constraints
     *
     * @return void
     */
    public function rules($rule,$attribute)
    {

    	$rules = array
    		(
    		//Validates alphanumeric characters from a-Z and 0-9.
    		'alnum' => V::alnum()->noWhitespace()->setName($attribute),
    		//alpha numeric with spaces
    		'alnumspace' => V::alnum()->setName($attribute),
    		//alphabet only
    		'alpha' => V::alpha()->noWhitespace()->setName($attribute),
    		//alphabet with spaces
    		'alphaspace' => V::alpha()->setName($attribute),
    		//required only
    		'notEmpty' => V::stringType()->notEmpty()->setName($attribute),
    		//email validation
    		'email' => V::email()->setName($attribute),
    		'numeric' => V::numeric()->setName($attribute),
    		
    		'date' => V::date()->setName($attribute),
    		'ip' => V::ip()->setName($attribute),
    		'url' => V::url()->setName($attribute),
    		'creditcard' => V::creditCard()->setName($attribute),
    		'image' => V::image()->setName($attribute)
    		);
    	return $rules[$rule];
    }

    public function validation_description()
    {
      $rules = array
        (
        //Validates alphanumeric characters from a-Z and 0-9.
        'alnum' => 'Required Alphanumeric without space from a-z and 0-9',
        //alpha numeric with spaces
        'alnumspace' => 'Required Alphanumeric and allow Space from a-z and 0-9',
        //alphabet only
        'alpha' => 'Required Alphabet characters without space from a-z',
        //alphabet with spaces
        'alphaspace' => 'Required Alphabet and allow space from a-z',
        //required only
        'notEmpty' => 'Required and allow All characters',
        //email validation
        'email' => 'Required email',
        'numeric' => 'Required Numeric',
        
        'date' => '',
        'ip' => V::ip()->setName($attribute),
        'url' => V::url()->setName($attribute),
        'creditcard' => V::creditCard()->setName($attribute),
        'image' => V::image()->setName($attribute)
        );
      return $rules[$rule];
    }

    /**
	 * Set user custom error messages
	 *
	 * @return void
	 */
	public function customErrorMessage()
	{
	    $this->messages = [
            'image'                 => 'Please choose the right image file for {{name}}',
	        'alpha'                 => '{{name}} must only contain alphabetic characters.',
	        'alnum'                 => '{{name}} must only contain alpha numeric characters and dashes.',
	        'notEmpty'				=> '{{name}} can not be empty',
	        'numeric'               => '{{name}} must only contain numeric characters.',
	        'noWhitespace'          => '{{name}} must not contain white spaces.',
	        'length'                => '{{name}} must length between {{minValue}} and {{maxValue}}.',
	        'email'                 => '{{name}} Please make sure you typed a correct email address.',
	        'creditCard'            => 'Please make sure you typed a valid card number.',
	        'date'                  => 'Make sure you typed a valid date for the {{name}} ({{format}}).',
        ];

	}


    /**
     * validate $file
     * @param  post file $attribute uploaded temp file
     * @param  string $extention string allowed file
     * @return obj validation rule object
     */
    public function validate_file($attribute,$extention)
    {
        $extention = explode("|", $extention);
        $extention = array_filter($extention);
       
        foreach ($extention as $key) {
            $validate_rule[]= v::extension($key)->setName($attribute);
        } 

        $rule = v::oneOf(
                $validate_rule
            );
        return $rule;
    }


	/**
	 * Assert validation rules.
	 *
	 * @param array $inputs
	 *   The inputs to validate.
	 * @return boolean
	 *   True on success; otherwise, false.
	 */
	public function assert(array $inputs)
	{
		foreach ($inputs as $key => $value) {

			try {

        if ($value['allownull']=='no') {

				if ($value['type']=='file') {
                     $this->messages[$key] = 'Make sure you choose file format '.$value['extention'].' for {{name}}';
                //     $this->messages = array_merge(array($key => 'ucing'),$this->messages);  
                	$this->validate_file($key,$value['extention'])->assert($value['value']);
                   
                } else {
                    $this->rules($value['type'],$value['alias'])->assert($value['value']);    
                }

                //print_r($this->messages);
            } elseif ($value['allownull']=='yes' && !empty($value['value']) && $value['type']!='none') {
                if ($value['type']=='file') {
                     $this->messages[$key] = 'Make sure you choose file format '.$value['extention'].' for {{name}}';
                //     $this->messages = array_merge(array($key => 'ucing'),$this->messages);  
                  $this->validate_file($key,$value['extention'])->assert($value['value']);
                   
                } else {
                    $this->rules($value['type'],$value['alias'])->assert($value['value']);    
                }
            }
	            
	        } catch (NestedValidationException $ex) {
                 //print_r($this->messages);
              
               $this->error = array_filter($ex->findMessages($this->messages));
	           }

		  }
    }
		
  /**
   * update restful data
   * @param  array $data         array of data update
   * @param  string $primary_key  primary key column name
   * @param  string $id           primary key value
   * @param  array $validation   array data of validation
   * @param  string $service_name restfull name
   * @param  string $format       output format (json,xml)
   * @return json               json response
   */
  public function update_data($data=null,$primary_key,$id,$validation=null,$service_name,$format)
  {
          if (!empty($data)) {
        if (!empty($validation)) {
          $val = $this->assert($validation);

          if (empty($this->errors())) {
            $up = $this->pdo->update('gambar',$data,"$primary_key",$id);

            if ($up==true) {
              $response['status']['code'] = 200;
                      $response['status']["message"] = ucwords($service_name)." Updated successfully";
                      echoResponse(200, $response,"$format");
            } else {
              $response['status']['code'] = 422;
              $response['status']['message'] = $this->pdo->getErrorMessage();
              echoResponse(422, $response,"$format");
            }
          } else {
              $response['status']['code'] = 422;
              foreach ($this->errors() as $error) {
                $response['status']['message'] = $error;  
              }
              echoResponse(422, $response,"$format");
          }
        } else {
            $up = $db->update('gambar',$data,"$primary_key",$id);

            if ($up==true) {
              $response['status']['code'] = 200;
                      $response['status']["message"] = ucwords($service_name)." Updated successfully";
                      echoResponse(200, $response,"$format");
            } else {
              $response['status']['code'] = 422;
              $response['status']['message'] = $this->pdo->getErrorMessage();
              echoResponse(422, $response,"$format");
            }
        }

      } else {
          $response['status']['code'] = 422;
                  $response['status']["message"] = "Unprocessable Entity";
                  echoResponse(422, $response,"$format");
      }
  }

	/**
	 * put every error we get here, keep segar
	 * @return void 
	 */
	public function errors()
	{
	    return $this->error;
	}


}