<?php

namespace App\DataFixtures;

use App\Entity\Season;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class SeasonFixtures extends Fixture implements DependentFixtureInterface
{
    const PROGRAMS = [
        ['title' => 'Foundation', 'synopsis' => 'Voyage stellaire', 'poster' => 'interstellar', 'category' => 'category_Science-Fiction'],
        ['title' => 'Indiana Jones', 'synopsis' => 'Archéologie', 'poster' => 'indiana', 'category' => 'category_Aventure'],
        ['title' => 'One Piece', 'synopsis' => 'Piraterie', 'poster' => 'onePiece', 'category' => 'category_Animation']
    ];

    public function load(ObjectManager $manager)
    {
        foreach(self::PROGRAMS as $programInfos){
            $season = new Season();
            $season->setNumber(1);
            
            $program = $this->getReference('program_'.$programInfos['poster']);
            $season->setProgram($program);

            $this->addReference('season_1_'.$programInfos['poster'], $season);
            $manager->persist($season);
        }
        $manager->flush();
    }

    public function getDependencies(){
        return [
            ProgramFixtures::class
        ];
    }
}