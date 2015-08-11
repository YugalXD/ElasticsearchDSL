<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ElasticsearchDSL\Tests\Unit\DSL\Aggregation;

use ONGR\ElasticsearchDSL\Aggregation\AbstractAggregation;
use ONGR\ElasticsearchDSL\Aggregation\GlobalAggregation;

class GlobalAggregationTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Data provider for testToArray().
     *
     * @return array
     */
    public function getToArrayData()
    {
        $out = [];

        // Case #0 global aggregation.
        $aggregation = new GlobalAggregation('test_agg');

        $result = [
            AbstractAggregation::PREFIX.'test_agg' => [
                'global' => new \stdClass(),
            ],
        ];

        $out[] = [
            $aggregation,
            $result,
        ];

        // Case #1 nested global aggregation.
        $aggregation = new GlobalAggregation('test_agg');
        $aggregation2 = new GlobalAggregation('test_agg_2');
        $aggregation->addAggregation($aggregation2);

        $result = [
            AbstractAggregation::PREFIX.'test_agg' => [
                'global' => new \stdClass(),
                'aggregations' => [
                    AbstractAggregation::PREFIX.'test_agg_2' => [
                        'global' => new \stdClass(),
                    ],
                ],
            ],
        ];

        $out[] = [
            $aggregation,
            $result,
        ];

        return $out;
    }

    /**
     * Test for global aggregation toArray() method.
     *
     * @param GlobalAggregation $aggregation
     * @param array             $expectedResult
     *
     * @dataProvider getToArrayData
     */
    public function testToArray($aggregation, $expectedResult)
    {
        $this->assertEquals($expectedResult, $aggregation->toArray());
    }

    /**
     * Test for setField method on global aggregation.
     *
     * @expectedException \LogicException
     */
    public function testSetField()
    {
        $aggregation = new GlobalAggregation('test_agg');
        $aggregation->setField('test_field');
    }
}
