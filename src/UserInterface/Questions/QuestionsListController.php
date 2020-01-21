<?php


namespace App\UserInterface\Questions;


use App\Application\Questions\QuestionsListQuery;
use App\UserInterface\ApiControllerMethods;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class QuestionsListController extends AbstractController
{
    use ApiControllerMethods;

    /**
     * @var QuestionsListQuery
     */
    private $questionsListQuery;

    /**
     * QuestionsListController constructor.
     * @param QuestionsListQuery $questionsListQuery
     */
    public function __construct(QuestionsListQuery $questionsListQuery)
    {
        $this->questionsListQuery = $questionsListQuery;
    }

    /**
     * @return Response
     *
     * @Route("/questions", methods={"GET"})
     */
   public function handle(): Response
   {
        return $this->response($this->questionsListQuery->data());
   }
}

