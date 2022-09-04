<?php

/**
 * Event type.
 */

namespace App\Form\Type;

use App\Entity\Category;
use App\Entity\Event;
use App\Form\DataTransformer\TagsDataTransformer;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class EventType.
 */
class EventType extends AbstractType
{
    /**
     * Tags data transformer.
     *
     * @var TagsDataTransformer Data transformer
     */
    private TagsDataTransformer $tagsDataTransformer;

    /**
     * Constructor.
     *
     * @param TagsDataTransformer $tagsDataTransformer Tags data transformer
     */
    public function __construct(TagsDataTransformer $tagsDataTransformer)
    {
        $this->tagsDataTransformer = $tagsDataTransformer;
    }

    /**
     * Builds the form.
     *
     * This method is called for each type in the hierarchy starting from the
     * top most type. Type extensions can further modify the form.
     *
     * @param FormBuilderInterface $builder Form Builder
     * @param array<string, mixed> $options Options
     *
     * @see FormTypeExtensionInterface::buildForm()
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add(
            'title',
            TextType::class,
            [
                'label' => 'label.title',
                'required' => true,
                'attr' => ['max_length' => 255],
            ]
        );

        $builder->add(
            'date_from',
            DateType::class,
            [
                'label' => 'label.date_from',
                'required' => true,
                'widget' => 'single_text',
                'input_format' => 'd-m-Y',
            ]
        );
        $builder->add(
            'time_from',
            TimeType::class,
            [
                'label' => 'label.time_from',
                'required' => true,
                'widget' => 'single_text',
                'input_format' => 'H:i',
            ]
        );

        $builder->add(
            'date_to',
            DateType::class,
            [
                'label' => 'label.date_to',
                'required' => true,
                'widget' => 'single_text',
                'input_format' => 'd-m-Y',
            ]
        );

        $builder->add(
            'time_to',
            TimeType::class,
            [
                'label' => 'label.time_to',
                'required' => true,
                'widget' => 'single_text',
                'input_format' => 'H:i',
            ]
        );

        $builder->add(
            'category',
            EntityType::class,
            [
                'class' => Category::class,
                'choice_label' => function ($category): string {
                    return $category->getTitle();
                },
                'label' => 'label.category',
                'required' => true,
                'placeholder' => false,
            ]
        );

        $builder->add(
            'tags',
            TextType::class,
            [
                'label' => 'label.tags',
                'required' => false,
                'attr' => ['max_length' => 128],
            ]
        );

        $builder->get('tags')->addModelTransformer(
            $this->tagsDataTransformer
        );

        $builder->add(
            'description',
            TextareaType::class,
            [
                'label' => 'label.description',
                'required' => false,
            ]
        );
    }

    /**
     * Configures the options for this type.
     *
     * @param OptionsResolver $resolver OptionsResolver
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(['data_class' => Event::class]);
    }

    /**
     * Returns the prefix of the template block name for this type.
     *
     * The block prefix defaults to the underscored short class name with
     * the "Type" suffix removed (e.g. "UserProfileType" => "user_profile").
     *
     * @return string Prefix
     */
    public function getBlockPrefix(): string
    {
        return 'event';
    }
}
