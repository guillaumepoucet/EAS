<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Session;
use App\Repository\CourseRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/admin/course", name="course_")
 */
class AdminCourseController extends AbstractController
{
    /**
     * @Route("/delete/{id}", name="delete")
     */

    public function deleteCourse(CourseRepository $courseRepo, $id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $course = $courseRepo->find($id);
        $entityManager->remove($course);
        $entityManager->flush();
        return $this->redirectToRoute('sessions_management');
    }
}
