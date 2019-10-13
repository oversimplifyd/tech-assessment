<?php

use HelloFresh\Recipe\Validator\Validator;
use PHPUnit\Framework\TestCase;

/**
 * @author Arotimmi Busayo <arotimi.busayo@gmail.com>
 *
 * Class ValidatorTest
 * @package Test\Unit
 */
class ValidatorTest extends TestCase
{

    /**
     * @author Arotimi Busayo <arotimi.busayo@gmail.com>
     */
    public function testCreateRecipeValidator()
    {
        $recipeData = [
            'name' => 'Sample Recipe><?',
            'prep_time' => 200,
            'difficulty' => 3,
            'vegetarian' => 'wrong'
        ];

        $this->assertEquals(2, count(Validator::createRecipeValidator($recipeData)));
    }

    /**
     * @author Arotimi Busayo <arotimi.busayo@gmail.com>
     */
    public function testUpdateRecipeValidator()
    {
        $recipeData = [
            'prep_time' => 200,
            'difficulty' => 3,
            'vegetarian' => 'wrong'
        ];

        $this->assertEquals(1, count(Validator::updateRecipeValidator($recipeData)));
    }

    /**
     * @author Arotimi Busayo <arotimi.busayo@gmail.com>
     */
    public function testCreateRatingValidator()
    {
        $ratingData = [
            'rating' => 3,
        ];

        $this->assertEquals(0, count(Validator::updateRecipeValidator($ratingData)));
    }

    /**
     * @author Arotimi Busayo <arotimi.busayo@gmail.com>
     */
    public function testCreateSearchValidator()
    {
        $searchData = ['name' => '<script></script>script>'];

        $this->assertEquals(1, count(Validator::updateRecipeValidator($searchData)));
    }
}
