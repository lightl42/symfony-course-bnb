<?php

namespace App\Controller;

use App\Service\StatsService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AdminDashboardController extends AbstractController
{
    /**
     * @Route("/admin", name="admin_dashboard")
     */
    public function index(StatsService $statsService)
    {
        $stats = $statsService->getStats();
        $bestAds = $statsService->getAdsStats('DESC');
        $worstAds = $statsService->getAdsStats('ASC');

        return $this->render('admin/dashboard/index.html.twig', [
            'stats' => $stats,
            'bestAds' => $bestAds,
            'worstAds' => $worstAds
            /*'stats' => [
                'users' => $users,
                'ads' => $ads,
                'bookings' => $bookings,
                'comments' => $comments
            ]*/
        ]);
    }
}
