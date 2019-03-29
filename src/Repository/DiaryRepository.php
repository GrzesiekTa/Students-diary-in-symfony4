<?php

namespace App\Repository;

use App\Entity\Diary;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Diary|null find($id, $lockMode = null, $lockVersion = null)
 * @method Diary|null findOneBy(array $criteria, array $orderBy = null)
 * @method Diary[]    findAll()
 * @method Diary[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DiaryRepository extends ServiceEntityRepository {

    /**
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry) {
        parent::__construct($registry, Diary::class);
    }

    /**
     * 
     * @param int $student
     * @param int $year
     * @param int $month
     * @param int $day
     * @param int $status
     * 
     * @return type
     */
    public function editDiary(int $student, int $year, int $month, int $day, int $status) {
        $date = \DateTime::createFromFormat('Y-m-d', "$year-$month-$day");

        $checkDiare = $this->findOneBy(array('student' => $student, 'date' => $date));

        $status = $this->getEntityManager()->getRepository('App\\Entity\\Status')->find($status);

        if ($checkDiare == null && ($status->getId() > 1)) {
            //insert if null and status not empty
            return $this->insertDiary($student, $status, $date);
        } elseif ($checkDiare && ($status->getId() > 1)) {
            //update if isset diary and statu not emmpty
            return $this->updateDiary($checkDiare, $status);
        } else {
            return $this->deleteDiary($checkDiare);
        }
    }

    /**
     * delete Diary
     * 
     * @param type $checkDiare
     * 
     * @return string
     */
    private function deleteDiary($checkDiare) {
        $em = $this->getEntityManager();
        $em->remove($checkDiare);
        $em->flush();

        return 'delete';
    }

    /**
     * @param type $checkDiare
     * @param type $status
     * @return type
     */
    private function updateDiary($checkDiare, $status) {
        $checkDiare->getId();
        $checkDiare->setStatus($status);
        $em = $this->getEntityManager();
        $em->flush();

        return 'update' . $checkDiare->getId();
    }

    /**
     * 
     * @param type $student
     * @param type $status
     * @param type $date
     * 
     * @return string
     */
    private function insertDiary($student, $status, $date) {
        $student = $this->getEntityManager()->getRepository('App\\Entity\\Student')->find($student);

        $diary = new Diary;
        $diary->setStudent($student);
        $diary->setDate($date);
        $diary->setStatus($status);

        $em = $this->getEntityManager();
        $em->persist($diary);
        $em->flush();

        return 'insert';
    }

    /**
     * find By Month Year
     * 
     * @param int $year
     * @param int $month
     * 
     * @return type
     */
    public function findByMonthYear(int $year = null, int $month = null) {

        if (!$month) {
            $month = date('m');
        }

        if (!$year) {
            $year = date('Y');
        }

        $startDate = new \DateTimeImmutable("$year-$month-01T00:00:00");
        $endDate = $startDate->modify('last day of this month')->setTime(23, 59, 59);

        $qb = $this->createQueryBuilder('p')
                ->where('p.date >= :fromTime')
                ->andWhere('p.date < :toTime')
                ->leftJoin('p.student', 'student')
                ->leftJoin('p.status', 'status')
                ->setParameter('fromTime', $startDate)
                ->setParameter('toTime', $endDate);

        return $qb->getQuery();
    }

}
