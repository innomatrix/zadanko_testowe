<?php

namespace App\Controller;

use App\Entity\Api;
use App\Entity\Hydrators\ApiHydrator;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

class SummaryController extends Controller
{
    /**
     * @Route("summary/{page}/{limit}", defaults={"page"=1, "limit"=10}, requirements={"page"="\d+","limit"="\d+"})
     */
    public function indexAction($page, $limit)
    {
        $repository = $this->getDoctrine()
            ->getRepository(Api::class);

        $query = $repository->createQueryBuilder('last')
            ->orderBy('last.id', 'DESC')
            ->setFirstResult(($page-1) * $limit)
            ->setMaxResults($limit)
            ->getQuery();

        // tu uzyjemy wlasnego HYDRATORA zeby splaszczyc obiekt DateTime z kolumy 'time' do STRING w wybranym formacie ("2019-07-31 15:03:19 (UTC)")
        $last_requests = $query->getResult('ApiHydrator');

        $query = $repository->createQueryBuilder('stat')
            ->select(
                'COUNT(stat.id) AS total_items',
                'MAX(stat.maxtemp) AS max_maxtemp',
                'MIN(stat.maxtemp) AS min_maxtemp',
                'avg(stat.maxtemp) AS avg_maxtemp',
                'MAX(stat.mintemp) AS max_mintemp',
                'MIN(stat.mintemp) AS min_mintemp',
                'AVG(stat.mintemp) AS avg_mintemp'
            )
            ->getQuery();

        $common_stat = $query->getResult()[0];

        $query = $repository->createQueryBuilder('city')
            ->select('city.city, COUNT(city.id) most_used')
            ->groupBy('city.city')
            ->orderby('most_used', 'DESC')
            ->setMaxResults(1)
            ->getQuery();

        $most_used_city = $query->getResult();

        if (!empty($most_used_city)) {
            $most_used_city = $most_used_city[0];
        }

        $stats = array_merge($common_stat, $most_used_city);

        return new JsonResponse(
            array(
                'status' => true,
                'response' => [
                    'last_requests' => $last_requests,
                    'statistic' => $stats
                ]
            )
        );
    }
}