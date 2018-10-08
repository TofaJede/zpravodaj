<?php
/**
 * Created by PhpStorm.
 * User: krystofkosut
 * Date: 10.09.18
 * Time: 20:52
 */

namespace App\controller;


use App\model\rssChannel;
use DOMDocument;
use Genkgo\Xsl\XsltProcessor;
use Exception;
use DateTime;
use App\model\weather;

class update {
    private $hash;
    private $rssModel;

    public function __construct(){
        $this->hash = time();
        $this->rssModel = new rssChannel();
    }

    public function All($active = 1){
        $rss = $this->rssModel->getAll($active = 1);

        if ($this->proceedRSS($rss)){
            return "ok";
        } else {
            return 'Error';
        }
    }

    public function One($name){
        $rss[] = $this->rssModel->getOne($name);
        if ($this->proceedRSS($rss)){
            return "ok";
        } else {
            return 'Error';
        }
    }

    public function routes($active = 1){
        $rssModel = new rssChannel();
        $route = $rssModel->getRoutes($active);
        $return = file_put_contents('json/routes.json', json_encode($route));
        return $return;
    }

    public function weather($type = "my"){

        $weather    = new weather();

        if ($type == 'now'){
            $jsonData   = $weather->currentData();
        } elseif($type=='forecast') { // ($type == 'forecast')
            $jsonData   = $weather->forecastData();
        } elseif($type == 'my') {
            $jsonData   = $weather->currentData();
        } else {
            return "error, bad type";
        }
        $return     = file_put_contents('json/weather'.$type.'.json', $jsonData);
        return $return;
    }

    /**
     * This function changes formated time to timestamp
     * @param string $zpicenej_cas
     * @param string $format
     * @return bool|timestamp
     */
    private function changeTime($zpicenej_cas, $format = DATE_RFC822){

        var_dump($format.' '.$zpicenej_cas);

        $dt = DateTime::createFromFormat($format, $zpicenej_cas);
        if($dt == false){
            var_dump(DateTime::getLastErrors());
            return false;
        }
        return $dt->getTimestamp();
    }

    private function proceedRSS($rss){
        foreach($rss as $channel){
            $dom = new DOMDocument();
            $dom->load($channel->url);
            $filename = $channel->name.$this->hash.'.xml';
            $dom->save('xml/'.$filename);
            $this->rssModel->update(['file' => $filename], ' id ='.$channel->id);

            $xml = new DOMDocument();
            $xml->load('xml/'.$filename);

            $xsl = new DOMDocument;
            //  $xsl->substituteEntities = TRUE;
            $xsl->load('xsl/'.$channel->name.'.xsl');

            $proc = new XSLTProcessor();
            $proc->importStyleSheet($xsl);

            file_put_contents('transformed/'.$filename, $proc->transformToXML($xml));

            $fileContents   = file_get_contents('transformed/'.$filename);
            // $fileContents   = trim(str_replace('xmlns:g="http://base.google.com/ns/1.0"', "", $fileContents));
            $fileContents   = trim(str_replace('"', "'", $fileContents));

            $simpleXml      = simplexml_load_string($fileContents, "SimpleXMLElement",LIBXML_HTML_NOIMPLIED);
            $matches        = $simpleXml->xpath('//pubDate');

            var_dump($channel->name);
            foreach($matches as $match){
                $match[0] = $this->changeTime($match[0], $channel->timeFormat);
                // $match = $this->changeTime($time, $channel->timeFormat);
                // $simpleXml = str_replace($time, $this->changeTime($time, $channel->timeFormat), $simpleXml);
            }
            // TODO: Handle errors...
            file_put_contents('json/'.$channel->name.'.json', json_encode($simpleXml, JSON_UNESCAPED_UNICODE));
        }
        return true;
    }
}