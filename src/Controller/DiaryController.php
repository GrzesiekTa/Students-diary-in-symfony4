<?php

namespace App\Controller;

use App\Entity\Diary;
use App\Repository\DiaryRepository;
use App\Repository\StatusRepository;
use App\Repository\StudentRepository;
use App\Service\Calendar;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/diary")
 */
class DiaryController extends Controller
{
    /**
     * @Route("/", name="diary")
     */
    public function index(StudentRepository $students, StatusRepository $statuses, Calendar $calendar)
    {

        $daysInMonth = $calendar->daysInMonth();

        return $this->render('diary/index.html.twig', [
            'students' => $students->findAll(),
            'statuses' => $statuses->findAll(),
            'daysInMonth' => $daysInMonth,
            'calendar' => $calendar,
        ]);
    }

    /**
     *requirements month(1-12),year (1900-2099)
     * @Route("/{year}/{month}", name="diary_by_data", methods="GET",
    requirements={"month"="^([1-9]|[0-1][0-2])$","year"="^(19|20)\d{2}$"} )
     */
    public function diaryByDate(int $year, int $month, StudentRepository $students, StatusRepository $statuses, DiaryRepository $diaryRepository, Calendar $calendar)
    {

        $daysInMonth = $calendar->daysInMonth($month, $year);

        return $this->render('diary/index.html.twig', [
            'students' => $students->findAll(),
            'statuses' => $statuses->findAll(),
            'daysInMonth' => $daysInMonth,
            'calendar' => $calendar,
        ]);

    }

    /**
     * @Route("/edit", name="edit_diary", methods="POST")
     */
    public function edit(Request $request, DiaryRepository $diaryRepository)
    {

        $params = json_decode($request->getContent(), true);
        $diaryRepository = $diaryRepository->editDiary($params['student'], $params['year'], $params['month'], $params['day'], $params['status']);
        return new JsonResponse([$diaryRepository]);
    }

    /**
     * @Route("/get-data/{year}/{month}", name="get_diary_data", methods="GET")
     */

    public function getDiaryDataByMonthYear($year, $month, DiaryRepository $diaryRepository)
    {

        $dataByMonthYear = $diaryRepository->findByMonthYear($year, $month)->getResult();

        $data = $this->get('serializer')->serialize(array('result' => $dataByMonthYear), 'json');
        $response = new JsonResponse();
        $response->setContent($data);

        return $response;

    }

}
