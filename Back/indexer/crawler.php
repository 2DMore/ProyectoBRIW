<?php


include "robotsParser.php";

class Crawler{
    public string $baseUrl;
    private RobotsParser $robot;
    public array $pages;
    private array $visitedUrls;
    public string $path;



    public function __construct(string $url)
    {
        $this->baseUrl = $url;
        $this->robot = new RobotsParser($url);
        $this->visitedUrls = [];
        $this->pages= [];
        $base = parse_url($this->baseUrl);
        $path = "pages/".$base['host']. ".json";
        $this->path = $path;
    }

    public function  startCrawl(int $depth,int $lenght, string $url){
        if($depth < 0) return;
        echo "$url, Profundidad: $depth";
        echo "<br>";
        if (!in_array($url, $this->visitedUrls)) {
            //Crear pagina y añadirla al resulado 
            try{
                $page = new Pagina($url);
                $this->pages[] = $page->data;
            //Añadir las urls ya visitadas
                $this->visitedUrls[] = $url;
            //Obtener las url a visita
                $depUrls =  $page->getUrls();
            }catch(Exception $e){
                echo "Not visitde: $url";
                echo "<br>";
                $depUrls = [];
            }
            $depUrls = array_slice($depUrls,0,$lenght);
            $depUrls = $this->robot->prune($depUrls);
            foreach($depUrls as $actualUrl){
                $this->startCrawl($depth-1,$lenght,$actualUrl);
            }
        }
    }
    public function printResults(){
        $data = json_encode($this->pages);
        $file = fopen($this->path,"w");
        fwrite($file,$data);
        fclose($file);
        return utils::indexContentToSolr($this->path);

    }
}

$urls = [
    "https://www.xataka.com.mx/"
];

foreach($urls as $url){
    $tremendoCrawler = new Crawler($url);
    //2 de profundidad
    //10 enlaces por sitio
    //Maximo de 100 paginas por sitio, 
    $tremendoCrawler->startCrawl(2,10,$url);
    echo "<br>";
    echo $tremendoCrawler->printResults();
    utils::savePageIndex($tremendoCrawler->path);
}






?>