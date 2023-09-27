<?php
// src/Controller/ProgramController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ProgramRepository;

#[Route('/program', name: 'program_')]
class ProgramController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(ProgramRepository $programRepository): Response
    {
        $programs = $programRepository->findAll();   
        return $this->render(
            'program/index.html.twig',
            ['programs' => $programs]
        );

    }

    #[Route('/{id}', requirements: ['id' => '\d+'], methods: ['GET'], name: 'show')]
    public function show(int $id, ProgramRepository $programRepository): Response
    {
        $program = $programRepository->findOneBy(['id' => $id]);

        if(!$program){
            throw $this->createNotFoundException(
                'No program with id : '.$id.' found in programs'
            );
        }
        return $this->render('program/show.html.twig', [
            'program' => $program
        ]);
    } 

    #[Route('/{programId<\d+>}/season/{seasonId<\d+>}', name: 'season_show')]
    public function showSeason(int $programId, int $seasonId, ProgramRepository $programRepository)
    {
        $program = $programRepository->findOneBy(['id' => $programId]);

        if(!$program){
            throw $this->createNotFoundException(
                'No program with id : '.$id.' found in programs'
            );
        }

        $seasons = $program->getSeason();
        $seasonRequested = null;
        foreach ($seasons as $season) {
            if($season->getId() == $seasonId){
                $seasonRequested = $season;
                break;
            }
        }
        
        if(!$seasonRequested){
            throw $this->createNotFoundException(
                'No season with id : '.$seasonId.' found for that program'
            );
        }

        return $this->render('program/season_show.html.twig', [
            'program' => $program,
            'season' => $seasonRequested
        ]);
    }
}