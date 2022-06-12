<?php

/**
 * Event fixtures.
 */

namespace App\DataFixtures;

use App\Entity\Event;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
/**
 * Class EventFixtures.
 */
class EventFixtures extends AbstractBaseFixtures
{
    /**
     * Load data.
     */
    public function loadData(): void
    {
        for ($i = 0; $i < 50; ++$i) {
            $event = new Event();
            $event->setTitle($this->faker->sentence);
            $event->setDurationFrom(
                 $this->faker->dateTimeBetween('-100 days', '-1 days')
            );
            $event->setDurationTo(
                 $this->faker->dateTimeBetween('-100 days', '-1 days')
            );
            $event->setDescription($this->faker->sentence);

            $this->manager->persist($event);
        }

        $this->manager->flush();
    }
}
