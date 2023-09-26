<?php

namespace App\DataFixtures;

use App\Entity\Program;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ProgramFixtures extends Fixture implements DependentFixtureInterface
{
    const PROGRAMS = [
        ['title' => 'Interstellar', 'synopsis' => 'Voyage stellaire', 'poster' => 'interstellar', 'category' => 'category_Science-Fiction'],
        ['title' => 'Inception', 'synopsis' => 'Subconscient', 'poster' => 'inception', 'category' => 'category_Action'],
        ['title' => 'Indiana Jones', 'synopsis' => 'Archéologie', 'poster' => 'indiana', 'category' => 'category_Aventure'],
        ['title' => 'Le Roi Lion', 'synopsis' => 'Disney', 'poster' => 'roiLion', 'category' => 'category_Animation'],
        ['title' => 'One Piece', 'synopsis' => 'Piraterie', 'poster' => 'onePiece', 'category' => 'category_Fantastique']
    ];
    
    public function load(ObjectManager $manager)
    {
        foreach(self::PROGRAMS as $programInfos){
            $program = new Program();
            $program->setTitle($programInfos['title']);
            $program->setSynopsis($programInfos['synopsis']);
            $program->setPoster($programInfos['poster']);
            $category = $this->getReference($programInfos['category']);
            $program->setCategory($category);

            $manager->persist($program);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            CategoryFixtures::class,
        ];
    }
}