<?

use GrahamCampbell\ResultType\Result;

$dotenv = Dotenv\Dotenv::createImmutable($_SERVER["DOCUMENT_ROOT"]);
    $dotenv->load();
    function dd(...$any){
        $result = "";
        foreach($any as $item){
            $json = json_encode($item);
            $result = $result."<p>$json</p>";
        }
        echo($result);
    }
    function env($name,$default=null){
        $var = $_ENV[$name];
        return isset($var)?$var:$default;
    }