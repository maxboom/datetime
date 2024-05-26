<?php

namespace App\Controller;

use App\Entity\DateTime;
use App\Form\DateTimeType;
use DateTime as BaseDateTime;
use DateTimeZone;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DateTimeController extends AbstractController
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/datetime", name="app_datetime_create", methods={"GET"})
     */
    public function create(): Response
    {
        $form = $this->createForm(DateTimeType::class);

        return $this->render('date_time/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/datetime", name="app_datetime_save", methods={"POST"})
     */
    public function save(Request $request): Response
    {
        $dateTime = new DateTime();
        $form = $this->createForm(DateTimeType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $dateTime = $form->getData();

            $this->entityManager->persist($dateTime);
            $this->entityManager->flush();

            return $this->redirectToRoute('app_datetime_show', ['id' => $dateTime->getId()]);
        }

        return $this->render('date_time/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/datetime/{id}", name="app_datetime_show", methods={"GET"})
     *
     * @throws Exception
     */
    public function show(int $id): Response
    {
        $dateTime = $this->entityManager->getRepository(DateTime::class)->find($id);

        $utcTimeZone = new DateTimeZone('UTC');
        $timezone = new DateTimeZone($dateTime->getTimezone());

        $utcDate = new BaseDateTime('now', $utcTimeZone);
        $date = new BaseDateTime('now noon', $timezone);

        // another variant of different
        // $differentInSeconds = $utcDate->getOffset() -  $date->getOffset();
        $differentInSeconds = $utcDate->getTimestamp() - ($date->getTimestamp() + $date->getOffset());

        $differentInMinutes = intdiv($differentInSeconds, 60);

        $februaryDate = new BaseDateTime($dateTime->getDate()->format('Y') . '-02-01');
        $daysInFebruary = $februaryDate->format('t');

        $monthName = $dateTime->getDate()->format('F');
        $daysInMonth = $dateTime->getDate()->format('t');

        return $this->render('date_time/show.html.twig', [
            'timezone' => $dateTime->getTimezone(),
            'differentInMinutes' => $differentInMinutes,
            'daysInFebruary' => $daysInFebruary,
            'monthName' => $monthName,
            'daysInMonth' => $daysInMonth
        ]);
    }
}
