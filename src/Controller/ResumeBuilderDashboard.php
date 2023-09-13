<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;


class ResumeBuilderDashboard
{
    #[Route('/app/resume/content')]
    public function dashboard()
    {
        return new Response('Dashboard');
    }

}
