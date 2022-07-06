<?php
/**
 * Contact controller.
 */

namespace App\Controller;

use App\Entity\Contact;
use App\Form\Type\ContactType;
use App\Service\ContactServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Class ContactController.
 */
#[Route('/contact')]
class ContactController extends AbstractController
{
    /**
     * Contact service.
     */
    private ContactServiceInterface $contactService;

    /**
     * Constructor.
     */
    public function __construct(ContactServiceInterface $contactService, TranslatorInterface $translation)
    {
        $this->contactService = $contactService;
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
        name: 'contact_index', methods: 'GET'
    )]
    public function index(Request $request): Response
    {
        $pagination = $this->contactService->getPaginatedList(
            $request->query->getInt('page', 1)
        );

        return $this->render('contact/index.html.twig', ['pagination' => $pagination]);
    }

    #[Route(
        '/{id}', name: 'contact_show', requirements: ['id' => '[1-9]\d*'], methods: 'GET'
    )]
    public function show(Contact $contact): Response
    {
        return $this->render('contact/show.html.twig', ['contact' => $contact]);
    }

    #[Route(
         '/create', name: 'contact_create', methods: 'GET|POST',
    )]
    public function create(Request $request): Response
    {
        $user = $this->getUser();
        $contact = new Contact();
        $contact->setAuthor($user);
        $form = $this->CreateForm(
            ContactType::class,
            $contact,
            ['action' => $this->generateUrl('contact_create')]
        );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->contactService->save($contact);

            $this->addFlash(
                'success',
                $this->translator->trans('message.created_successfully')
            );
        }

        return $this->render(
            'contact/create.html.twig', ['form' => $form->createView()]
        );
    }

    /**
     * Edit action.
     *
     * @param Request  $request  HTTP request
     * @param Contact $contact Contact entity
     *
     * @return Response HTTP response
     */
    #[Route(
        '/{id}/edit', name: 'contact_edit', requirements: ['id' => '[1-9]\d*'], methods: 'GET|PUT'
    )]
    public function edit(Request $request, Contact $contact): Response
    {
        $form = $this->createForm(
            ContactType::class,
            $contact,
            [
                'method' => 'PUT',
                'action' => $this->generateUrl('contact_edit', ['id' => $contact->getId()]),
            ]
        );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->contactService->save($contact);

            $this->addFlash(
                'success',
                $this->translator->trans('message.created_successfully')
            );

            return $this->redirectToRoute('contact_index');
        }

        return $this->render(
            'contact/edit.html.twig', ['form' => $form->createView(), 'contact' => $contact]
        );
    }

    #[Route(
        '/{id}/delete', name: 'contact_delete', requirements: ['id' => '[1-9]\d*'], methods: 'GET|DELETE'
    )]
    public function delete(Request $request, Contact $contact): Response
    {
        $form = $this->createForm(
            ContactType::class,
            $contact,
            [
                'method' => 'DELETE',
                'action' => $this->generateUrl('contact_delete', ['id' => $contact->getId()]),
            ]
        );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->contactService->delete($contact);

            $this->addFlash(
                'success',
                $this->translator->trans('message.deleted_successfully')
            );

            return $this->redirectToRoute('contact_index');
        }

        return $this->render(
            'contact/delete.html.twig', ['form' => $form->createView(), 'contact' => $contact]
        );
    }
}
