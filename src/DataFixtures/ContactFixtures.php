<?php

/**
 * Contact fixtures.
 */

namespace App\DataFixtures;

use App\Entity\Contact;
use App\Entity\Category;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

/**
 * Class ContactFixtures.
 */
class ContactFixtures extends AbstractBaseFixtures implements DependentFixtureInterface
{
    /**
     * Load data.
     */
    public function loadData(): void
    {
        if (null === $this->manager || null === $this->faker) {
            return;
        }
        $this->createMany(7, 'contacts', function (int $i) {
            $contact = new Contact();
            $contact->setName($this->faker->firstName);
            $contact->setSurname($this->faker->lastName);
            $contact->setBirthdate($this->faker->dateTime);
            $contact->setTelephone($this->faker->phoneNumber());
            $contact->setEmail($this->faker->email);
            $contact->setNote($this->faker->text(250));

            $category = $this->getRandomReference('categories');
            $contact->setCategory($category);

            $author = $this->getRandomReference('users');
            $contact->setAuthor($author);


            $this->manager->persist($contact);

            return $contact;
        });

        $this->manager->flush();
    }

    public function getDependencies(): array
    {
        return [CategoryFixtures::class];
    }
}
