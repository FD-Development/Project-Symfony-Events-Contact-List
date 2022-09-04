<?php

/**
 * Event fixtures.
 */

namespace App\DataFixtures;

use App\Entity\Event;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

/**
 * Class EventFixtures.
 */
class EventFixtures extends AbstractBaseFixtures implements DependentFixtureInterface
{
    /**
     * Load data.
     */
    public function loadData(): void
    {
        if (null === $this->manager || null === $this->faker) {
            return;
        }
        $this->createMany(200, 'events', function (int $i) {
            $event = new Event();
            $event->setTitle($this->faker->sentence(3));

            $startDuration = $this->faker->dateTimeBetween('-4 days', '+11  days');
            $event->setDateFrom($startDuration);
            $event->setTimeFrom($startDuration);
            $event->setdateTo(
                $this->faker->dateTimeInInterval($startDuration, '+3 days')
            );
            $event->setTimeTo(
                $this->faker->dateTimeInInterval($startDuration, '+3 days')
            );
            $event->setDescription($this->faker->sentence);

            $category = $this->getRandomReference('categories');
            $event->setCategory($category);

            $tag = $this->getRandomReference('tags');
            $event->addTag($tag);

            $author = $this->getRandomReference('users');
            $event->setAuthor($author);

            $this->manager->persist($event);

            return $event;
        });

        $this->manager->flush();
    }

    /**
     * Gets Dependencies.
     *
     * @return string[] Dependencies
     */
    public function getDependencies(): array
    {
        return [CategoryFixtures::class];
    }
}
