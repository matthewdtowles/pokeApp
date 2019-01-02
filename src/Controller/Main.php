<?php
/**
 * Created by PhpStorm.
 * User: matt
 * Date: 12/28/18
 * Time: 11:02 PM
 */

namespace App\Controller;

use GuzzleHttp\Client;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

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

        $request = Request::createFromGlobals();

        $this->type = $request->get('type');
        $this->query = $request->get('query');
        $this->client = new Client(['base_uri' => self::POKEAPI_BASE]);

        try {
            // send request: base + type + query
            $response = $this->client->request(
                'GET',
                $this->type . self::DS . $this->query);

            $responseArr = json_decode($response->getBody(), true);

            echo '<pre>';
            //return new Response($response->getBody());

            return $this->render('pokemon.html.twig', $responseArr);
        } catch (\GuzzleHttp\Exception\GuzzleException $e) {
            return new Response($e->getMessage());
        }

    }


    public function pokemon(){}

    public function type(){}

    public function ability(){}
}