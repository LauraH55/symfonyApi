<?php

namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Editor; // charge l'entité

class EditorController extends AbstractController
{
    /**
     * @Route("/editor", name="editor")
     */
    public function index()
    {
        $editors =$this->getDoctrine() // requête BDD pour afficher le résultat
        ->getRepository(Editor::class)
        ->findAll();

        $response = []; // prépare la réponse

        foreach ($editors as $editor) { // boucle les éditeurs
          $response[] = [ // passe les données qu'on veut qui sortent en tableau
            'id' => $editor->getId(),
            'name' => $editor->getName(),
          ];
        }

        return $this->json($response);
    }

    /**
     * @Route("/editor/{id}", name="editor_detail", requirements={"id"="\d+"})
     */

     public function editor($id) // contient la logique, prépare
     {
       $editor = $this->getDoctrine()
       ->getRepository(Editor::class)
       ->find($id);

       $games= []; // prépare un tableau

       foreach ($editor->getGames() as $game) { //editor getGames et on boucle dessus,
         $games[] = [
           'id' => $game->getId(),
           'name' => $game->getName(),
         ];
       }

       $response = [
         'id' => $editor->getId(),
         'name' => $editor->getName(),
         'game' => $games,
       ];

       return $this->json($response);
     }
}
