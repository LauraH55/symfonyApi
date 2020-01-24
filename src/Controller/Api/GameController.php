<?php

namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


use App\Entity\Game;

class GameController extends AbstractController
{
  /**
   * @Route("/game", name="game")
   */

  public function index()
  {
    $games =$this->getDoctrine() // requête BDD pour afficher le résultat
    ->getRepository(Game::class)
    ->findAll();

    $response = [];

    foreach ($games as $game) { // boucle les éditeurs
      $response[] = [ // passe les données qu'on veut qui sortent en tableau
        'id' => $game->getId(),
        'name' => $game->getName(),

      ];
    }

    return $this->json($response);
  }

  /**
   * @Route("/game/{id}", name="game_detail", requirements={"id"="\d+"})
   */

   public function game($id)
   {
      $game = $this->getDoctrine()
      ->getRepository(Game::class)
      ->find($id);

      if (!$game) {
        throw new NotFoundHttpException("Le jeu n'existe pas !");
      }

      $editor = $game->getEditor();

      $response = [
          'id' => $game->getId(),
          'name' => $game->getName(),
          'description' => $game->getDescription(),
          'date' => $game->getDate(),
          'classification' => $game->getClassification(),
          'cover' => $game->getCover(),
          'review' => $game->getReview(),
          'link' => $game->getLink(),
          'editor' => [
              'id' => $editor->getId(),
              'name' => $editor->getName(),
          ]

      ];

     return $this->json($response);
   }
}
