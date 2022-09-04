<?php
/**
 * Tag controller.
 */

namespace App\Controller;

use App\Entity\Tag;
use App\Form\Type\TagType;
use App\Service\TagServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Class TagController.
 */
#[Route('/tag')]
class TagController extends AbstractController
{
    /**
     * TagServiceInterface.
     *
     * @var TagServiceInterface TagServiceInterface
     */
    private TagServiceInterface $tagService;

    /**
     * TagServiceInterface.
     *
     * @var TranslatorInterface TagServiceInterface
     */
    private TranslatorInterface $translator;

    /**
     * Constructor.
     *
     * @param TagServiceInterface $tagService  TagServiceInterface
     * @param TranslatorInterface $translation TranslatorInterface
     */
    public function __construct(TagServiceInterface $tagService, TranslatorInterface $translation)
    {
        $this->tagService = $tagService;
        $this->translator = $translation;
    }

    /**
     * Index action.
     *
     * @param Request $request HTTP Request
     *
     * @return Response HTTP response
     */
    #[Route(
        name: 'tag_index',
        methods: 'GET'
    )]
    public function index(Request $request): Response
    {
        $pagination = $this->tagService->getPaginatedList(
            $request->query->getInt('page', 1)
        );

        return $this->render('tag/index.html.twig', ['pagination' => $pagination]);
    }

    /**
     * Show action.
     *
     * @param Tag $tag Tag entity
     *
     * @return Response HTTP response
     */
    #[Route(
        '/{id}',
        name: 'tag_show',
        requirements: ['id' => '[1-9]\d*'],
        methods: 'GET'
    )]
    public function show(Tag $tag): Response
    {
        return $this->render('tag/show.html.twig', ['tag' => $tag]);
    }

    /**
     * Create action.
     *
     * @param Request $request HTTP request
     *
     * @return Response HTTP response
     */
    #[Route(
        '/create',
        name: 'tag_create',
        methods: 'GET|POST',
    )]
    public function create(Request $request): Response
    {
        $tag = new Tag();
        $form = $this->CreateForm(TagType::class, $tag);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->tagService->save($tag);

            $this->addFlash(
                'success',
                $this->translator->trans('message.created_successfully')
            );
        }

        return $this->render(
            'tag/create.html.twig',
            ['form' => $form->createView()]
        );
    }

    /**
     * Edit action.
     *
     * @param Request $request HTTP request
     * @param Tag     $tag     Tag entity
     *
     * @return Response HTTP response
     */
    #[Route(
        '/{id}/edit',
        name: 'tag_edit',
        requirements: ['id' => '[1-9]\d*'],
        methods: 'GET|PUT'
    )]
    public function edit(Request $request, Tag $tag): Response
    {
        $form = $this->createForm(
            TagType::class,
            $tag,
            [
                'method' => 'PUT',
                'action' => $this->generateUrl('tag_edit', ['id' => $tag->getId()]),
            ]
        );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->tagService->save($tag);

            $this->addFlash(
                'success',
                $this->translator->trans('message.edited_successfully')
            );

            return $this->redirectToRoute('tag_index');
        }

        return $this->render(
            'tag/edit.html.twig',
            ['form' => $form->createView(), 'tag' => $tag]
        );
    }

    /**
     * Delete action.
     *
     * @param Request $request HTTP request
     * @param Tag     $tag     Tag entity
     *
     * @return Response HTTP response
     */
    #[Route(
        '/{id}/delete',
        name: 'tag_delete',
        requirements: ['id' => '[1-9]\d*'],
        methods: 'GET|DELETE'
    )]
    public function delete(Request $request, Tag $tag): Response
    {
        if (!$this->tagService->canBeDeleted($tag)) {
            $this->addFlash(
                'warning',
                $this->translator->trans('message.tag_contains_events')
            );

            return $this->redirectToRoute('tag_index');
        }

        $form = $this->createForm(
            TagType::class,
            $tag,
            [
                'method' => 'DELETE',
                'action' => $this->generateUrl('tag_delete', ['id' => $tag->getId()]),
            ]
        );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->tagService->delete($tag);

            $this->addFlash(
                'success',
                $this->translator->trans('message.deleted_successfully')
            );

            return $this->redirectToRoute('tag_index');
        }

        return $this->render(
            'tag/delete.html.twig',
            ['form' => $form->createView(), 'tag' => $tag]
        );
    }
}
