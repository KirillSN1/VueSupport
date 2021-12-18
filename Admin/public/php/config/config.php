<?

use GrahamCampbell\ResultType\Result;

$dotenv = Dotenv\Dotenv::createImmutable(dirname($_SERVER["DOCUMENT_ROOT"],1));
    $dotenv->load();
    function dd(...$any){
        $result = "";
        foreach($any as $item){
            $json = json_encode($item);
            $result = $result."<p>$json</p>";
        }
        echo($result);
    }
    function return_error($message){
        header('HTTP/1.1 500 Internal Server Error');
        header('Content-Type: application/json; charset=UTF-8');
        echo(json_encode([ 'message'=>$message, 'code'=>500 ]));
        exit; 
    }
    function env($name,$default=null){
        if(isset($_ENV[$name])) return $_ENV[$name];
        else return $default;
    }