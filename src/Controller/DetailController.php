<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Movie;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Http\Message\{ResponseInterface, ServerRequestInterface};
use Slim\Exception\{HttpBadRequestException, HttpNotFoundException};
use Slim\Interfaces\RouteCollectorInterface;
use Twig\Environment;
use App\Support\NotFoundHandler;

/**
 * Class DetailController.
 */
class DetailController
{
    /**
     * @var RouteCollectorInterface
     */
    private $routeCollector;

    /**
     * @var Environment
     */
    private $twig;

    /**
     * @var EntityManagerInterface
     */
    private $em;
    
    /**
     * @var ServerRequestInterface
     */
    private $request;

    /**
     * DetailController constructor.
     *
     * @param RouteCollectorInterface $routeCollector
     * @param Environment             $twig
     * @param EntityManagerInterface  $em
     */
    public function __construct(RouteCollectorInterface $routeCollector, Environment $twig, EntityManagerInterface $em)
    {
        $this->routeCollector = $routeCollector;
        $this->twig = $twig;
        $this->em = $em;
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface      $response
     *
     * @return ResponseInterface
     *
     * @throws HttpBadRequestException
     */
    public function index(ServerRequestInterface $request, ResponseInterface $response, $args): ResponseInterface
    {
        $this->request = $request;

        try {
            $data = $this->twig->render('detail/index.html.twig', [
                'detail' => $this->fetchData($args['id']),
            ]);
        } catch (\Exception $e) {
            throw new HttpBadRequestException($request, $e->getMessage(), $e);
        }

        $response->getBody()->write($data);

        return $response;
    }

    /**
     * @return Object
     * @throws HttpNotFoundException
     */
    protected function fetchData($id) : Object
    {
        $data = $this->em->getRepository(Movie::class)
                ->findOneBy(['id' => $id]);

        if (empty($data)) {
            throw new HttpNotFoundException($this->request);
        }

        return $data;
    }
}
