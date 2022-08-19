<?php

/**
 * Tag fixtures.
 */

namespace App\DataFixtures;

use App\Entity\Tag;

/**
 * Class TagFixtures.
 *
 * @psalm-suppress MissingConstructor
 */
class TagFixtures extends AbstractBaseFixtures
{
    /**
     * Load data.
     *
     * @psalm-suppress PossiblyNullReference
     * @psalm-suppress UnusedClosureParam
     */
    public function loadData(): void
    {
        $this->createMany(15, 'tags', function (int $i) {
            $tag = new Tag();
            $tag->setTitle($this->faker->unique()->word);

            return $tag;
        });

        $this->manager->flush();
    }
}
