<?php
/**
 * Event controller.
 */

namespace App\Controller;

use App\Entity\Event;
use App\Form\Type\EventType;
use App\Service\EventServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Class EventController.
 */
#[Route('/event')]
class EventController extends AbstractController
{
    /**
     * Event service.
     */
    private EventServiceInterface $eventService;

    /**
     * Constructor.
     */
    public function __construct(EventServiceInterface $eventService, TranslatorInterface $translation)
    {
        $this->eventService = $eventService;
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
        name: 'event_index', methods: 'GET'
    )]
    public function index(Request $request): Response
    {

        $currentDate = new \DateTime('now');

        $paginationActive = $this->eventService->getEventsByDate(
            $request->query->getInt('page', 1),
            $this->getUser(),
            $currentDate
        );

        $upcoming = $this->eventService->getUpcomingEvents(
            $request->query->getInt('upcoming_page', 1),
            $this->getUser(),
            $currentDate
        );

        return $this->render(
            'event/index.html.twig',
            [
                'pagination' => $paginationActive,
                'upcoming' => $upcoming
            ]
        );
    }

    /**
     * List action.
     *
     * @param Request $request HTTP Request
     *
     * @return Response HTTP response
     */
    #[Route(
        '/list', name: 'event_list', methods: 'GET'
    )]
    public function list(Request $request): Response
    {
        $pagination = $this->eventService->getPaginatedList(
            $request->query->getInt('page', 1),
            $this->getUser()
        );

        return $this->render(
            'event/list.html.twig',
            [
                'pagination' => $pagination,
            ]
        );
    }

    #[Route(
        '/{id}', name: 'event_show', requirements: ['id' => '[1-9]\d*'], methods: 'GET'
    )]
    public function show(Event $event): Response
    {
        if ($event->getAuthor() !== $this->getUser()) {
            $this->addFlash(
                'warning',
                $this->translator->trans('message.record_not_found')
            );

            return $this->redirectToRoute('event_index');
        }

        return $this->render('event/show.html.twig', ['event' => $event]);
    }

    #[Route(
         '/create', name: 'event_create', methods: 'GET|POST',
    )]
    public function create(Request $request): Response
    {
        $user = $this->getUser();
        $event = new Event();
        $event->setAuthor($user);
        $form = $this->CreateForm(
            EventType::class,
            $event,
            ['action' => $this->generateUrl('event_create')]
        );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->eventService->save($event);

            $this->addFlash(
                'success',
                $this->translator->trans('message.created_successfully')
            );
        }

        return $this->render(
            'event/create.html.twig', ['form' => $form->createView()]
        );
    }

    /**
     * Edit action.
     *
     * @param Request  $request  HTTP request
     * @param Event $event Event entity
     *
     * @return Response HTTP response
     */
    #[Route(
        '/{id}/edit', name: 'event_edit', requirements: ['id' => '[1-9]\d*'], methods: 'GET|PUT'
    )]
    public function edit(Request $request, Event $event): Response
    {
        $form = $this->createForm(
            EventType::class,
            $event,
            [
                'method' => 'PUT',
                'action' => $this->generateUrl('event_edit', ['id' => $event->getId()]),
            ]
        );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->eventService->save($event);

            $this->addFlash(
                'success',
                $this->translator->trans('message.created_successfully')
            );

            return $this->redirectToRoute('event_index');
        }

        return $this->render(
            'event/edit.html.twig', ['form' => $form->createView(), 'event' => $event]
        );
    }

    #[Route(
        '/{id}/delete', name: 'event_delete', requirements: ['id' => '[1-9]\d*'], methods: 'GET|DELETE'
    )]
    public function delete(Request $request, Event $event): Response
    {
        $form = $this->createForm(
            EventType::class,
            $event,
            [
                'method' => 'DELETE',
                'action' => $this->generateUrl('event_delete', ['id' => $event->getId()]),
            ]
        );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->eventService->delete($event);

            $this->addFlash(
                'success',
                $this->translator->trans('message.deleted_successfully')
            );

            return $this->redirectToRoute('event_index');
        }

        return $this->render(
            'event/delete.html.twig', ['form' => $form->createView(), 'event' => $event]
        );
    }
}
