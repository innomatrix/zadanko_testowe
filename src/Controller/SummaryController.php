<?php

namespace App\Controller;

use App\Entity\Api;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Doctrine\ORM\Query;

class SummaryController extends Controller
{
    /**
     * @Route("summary/{page}", defaults={"page"=1}, requirements={"page"="\d+"})
     */
    public function indexAction()
    {

        //get repository of Api table
        $repository = $this->getDoctrine()
            ->getRepository(Api::class);

        //prepare query for requesting last entries
        $query = $repository->createQueryBuilder('last')
            ->orderBy('last.id', 'DESC')
            ->setMaxResults(10)
            ->getQuery();

        //get last entries
       $last_requests = $query->getResult(Query::HYDRATE_ARRAY);

        //prepare query for common statistic
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

        //get entry of common results
        $common_stat = $query->getResult()[0];

        //prepare query for most used city from DB
        $query = $repository->createQueryBuilder('city')
            ->select('city.city, COUNT(city.id) most_used')
            ->groupBy('city.city')
            ->orderby('most_used', 'DESC')
            ->setMaxResults(1)
            ->getQuery();

        //get entry of the most used city from DB
        $most_used_city = $query->getResult();

        if (!empty($most_used_city)) {
            $most_used_city = $most_used_city[0];
        }

        //merge statistics array
        $stats = array_merge($common_stat, $most_used_city);

        //return JSON response for JS handling
        return new JsonResponse(
            array(
                'status' => true,
                'response' => [
                    'last_requests' => $last_requests,
                    'statistic' => $stats
                ]
            )
        );

        // //render results to view
        // return $this->render('@App/Summary/index.html.twig', array(
        //     'last_requests' => $last_requests,
        //     'statistic' => $stats
        // ));
    }
}