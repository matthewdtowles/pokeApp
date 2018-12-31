<?php
/**
 * Created by PhpStorm.
 * User: matt
 * Date: 12/28/18
 * Time: 11:02 PM
 */

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use GuzzleHttp\Client;

class Main extends AbstractController
{
    private const POKEAPI_BASE = 'https://pokeapi.co/api/v2/';
    private const DS = '/';

    private $type;
    private $query;
    private $client;

    /**
     * @Route("/", name="main")
     */
    public function main()  {

        // todo: obv need to abstract $_POST
        // todo: also need to handle all this in other method
        $this->type = 'pokemon';//$_POST['type'];
        $this->query = 'mewtwo';//$_POST['query'];
        $this->client = new Client(['base_uri' => self::POKEAPI_BASE]);

        try {
            // send request: base + type + query
            $response = $this->client->request(
                'GET',
                $this->type . self::DS . $this->query);

            $responseArr = json_decode($response->getBody(), true);

            echo '<pre>';
            return new Response($response->getBody());

        } catch (\GuzzleHttp\Exception\GuzzleException $e) {
            return new Response($e->getMessage());
        }

    }
}