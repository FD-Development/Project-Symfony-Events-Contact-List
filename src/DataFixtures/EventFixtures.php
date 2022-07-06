<?php

/**
 * Event fixtures.
 */

namespace App\DataFixtures;

use App\Entity\Event;
use App\Entity\Category;
use App\Entity\Tag;
use App\Entity\User;
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
        $this->createMany(100, 'events', function (int $i) {
            $event = new Event();
            $event->setTitle($this->faker->sentence(3));
            $event->setDurationFrom(
                 $this->faker->dateTimeBetween('-50 days', '-20 days')
            );
            $event->setDurationTo(
                 $this->faker->dateTimeBetween('-19 days', '-1 days')
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

    public function getDependencies(): array
    {
        return [CategoryFixtures::class];
    }
}
