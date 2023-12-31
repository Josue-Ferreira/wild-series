<?php

namespace App\DataFixtures;

use App\Entity\Program;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ProgramFixtures extends Fixture implements DependentFixtureInterface
{
    const PROGRAMS = [
        ['title' => 'Foundation', 'synopsis' => 'Voyage stellaire', 'poster' => 'interstellar', 'category' => 'category_Science-Fiction'],
        ['title' => 'Indiana Jones', 'synopsis' => 'Archéologie', 'poster' => 'indiana', 'category' => 'category_Aventure'],
        ['title' => 'One Piece', 'synopsis' => 'Piraterie', 'poster' => 'onePiece', 'category' => 'category_Animation']
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

            $this->addReference('program_'.$programInfos['poster'], $program);

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