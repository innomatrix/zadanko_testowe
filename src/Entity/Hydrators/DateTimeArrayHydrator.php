<?php

namespace App\Entity\Hydrators;

use Doctrine\ORM\Internal\Hydration\ArrayHydrator;

class DateTimeArrayHydrator extends ArrayHydrator
{
    /**
     * {@inheritdoc}
     */
    protected function hydrateRowData(array $data, array &$result)
    {
        $hydrated_result = array();
        parent::hydrateRowData($data, $hydrated_result);

        $row = $hydrated_result[0];

        foreach ($row as $key => $value) {
            if (is_a($value, 'DateTime')) {
                $row[$key] = $value->format('Y-m-d H:i:s (e)');
            }
        }
        $result[] = $row;
    }
}
