<?php

namespace App\DataFixtures;

use App\Entity\Episode;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class EpisodeFixtures extends Fixture implements DependentFixtureInterface
{
    const PROGRAMS = [
        ['title' => 'Foundation', 'synopsis' => 'Voyage stellaire', 'poster' => 'interstellar', 'category' => 'category_Science-Fiction'],
        ['title' => 'Indiana Jones', 'synopsis' => 'Archéologie', 'poster' => 'indiana', 'category' => 'category_Aventure'],
        ['title' => 'One Piece', 'synopsis' => 'Piraterie', 'poster' => 'onePiece', 'category' => 'category_Animation']
    ];

    public function load(ObjectManager $manager)
    {
        foreach (self::PROGRAMS as $programInfos) {
            for ($i=1; $i <4 ; $i++) { 
                $episode = new Episode();
                $episode->setNumber($i);
                $episode->setTitle('Episode '.$i);

                $season = $this->getReference('season_1_'.$programInfos['poster']);
                $episode->setSeason($season);

                $manager->persist($episode);
            }
            $manager->flush();
        }
    }

    public function getDependencies()
    {
        return [
            SeasonFixtures::class
        ];
    }
}