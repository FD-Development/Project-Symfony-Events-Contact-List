<?php

/**
 * Category fixtures.
 */

namespace App\DataFixtures;

use App\Entity\Category;

/**
 * Class CategoryFixtures.
 *
 * @psalm-suppress MissingConstructor
 */
class CategoryFixtures extends AbstractBaseFixtures
{
    /**
     * Load data.
     *
     * @psalm-suppress PossiblyNullReference
     * @psalm-suppress UnusedClosureParam
     */
    public function loadData(): void
    {
        $this->createMany(15, 'categories', function (int $i) {
            $category = new Category();
            $category->setTitle($this->faker->unique()->word);

            return $category;
        });

        $this->manager->flush();
    }
}
