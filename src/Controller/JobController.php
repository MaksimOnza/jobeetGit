<?php
namespace App\Controller;

use App\Entity\Job;
use App\Entity\Category;
use App\Form\JobType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;


class JobController extends AbstractController
{
    /**
     * @Route("/job", name="job.list")
     *
     * @return Response
    */
    public function list(EntityManagerInterface $em) : Response
    {

        $categories = $em->getRepository(Category::class)->findWithActiveJobs();

        return $this->render('job/list.html.twig', [
            'categories' => $categories,
        ]);
    }

    /**
     * Finds and displays a job entity.
     *
     * @Route("job/{id}", name="job.show", methods="GET", requirements={"id" = "\d+"})
     *
     * @Entity("job", expr="repository.findActiveJob(id)")
     *
     * @param Job $job
     *
     * @return Response
     */
    public function show(Job $job) : Response
    {
        return $this->render('job/show.html.twig', [
            'job' => $job,
        ]);
    }

    /**
     * Creates a new job entity.
     *
     * @Route("/job/create", name="job.create", methods="GET")
     *
     * @return Response
     */
    public function create() : Response
    {
        $job = new Job();
        $form = $this->createForm(JobType::class, $job);

        return $this->render('job/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }



}