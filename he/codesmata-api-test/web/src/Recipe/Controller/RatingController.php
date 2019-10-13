<?php

namespace HelloFresh\Recipe\Controller;

use HelloFresh\Exception\ApiError;
use HelloFresh\Recipe\Repositories\RatingRepository;
use HelloFresh\Recipe\Validator\Validator;
use Symfony\Component\HttpFoundation\Request;

/**
 * @author Arotimi Busayo <arotimi.busayo@gmail.com>
 *
 * Class RatingController
 * @package HelloFresh\Controller
 */
class RatingController extends BaseController
{
    protected $ratingRepo;

    /**
     * @author Arotimi Busayo <arotimi.busayo@gmail.com>
     *
     * RecipeController constructor.
     */
    public function __construct()
    {
        $this->ratingRepo = new RatingRepository();
    }

    /**
     * @author Arotimi Busayo <arotimi.busayo@gmail.com>
     *
     * @param Request $request
     * @param int $recipeId
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function rate(Request $request, int $recipeId)
    {
        if ($violations = Validator::createRatingValidator($request->request->all())) {
            return $this->error(ApiError::VALIDATION_ERR(), $violations, 400);
        }
        $request = $request->request->all();
        $request['recipe_id'] = $recipeId;

        return $this->success($this->ratingRepo->create($request));
    }
}
