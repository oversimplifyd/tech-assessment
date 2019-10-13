<?php

namespace HelloFresh\Recipe\Controller;

use HelloFresh\Exception\ApiError;
use HelloFresh\Recipe\Authenticator\Auth;
use HelloFresh\Recipe\Repositories\RecipeRepository;
use HelloFresh\Recipe\Validator\Validator;
use Symfony\Component\HttpFoundation\Request;

/**
 * @author Arotimi Busayo <arotimi.busayo@gmail.com>
 *
 * Class RecipeController
 * @package HelloFresh\Controller
 */
class RecipeController extends BaseController
{
    protected $recipeRepo;

    /**
     * @author Arotimi Busayo <arotimi.busayo@gmail.com>
     *
     * RecipeController constructor.
     */
    public function __construct()
    {
        $this->recipeRepo = new RecipeRepository();
    }

    /**
     * @author Arotimi Busayo <arotimi.busayo@gmail.com>
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function index(Request $request)
    {
        return $this->success($this->recipeRepo->paginate());
    }

    /**
     * @author Arotimi Busayo <arotimi.busayo@gmail.com>
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function create(Request $request)
    {
        Auth::secureBasic($request);

        if ($violations = Validator::createRecipeValidator($request->request->all())) {
            return $this->error(ApiError::VALIDATION_ERR(), $violations, 400);
        }

        return $this->success($this->recipeRepo->create($request->request->all()));
    }

    /**
     * @author Arotimi Busayo <arotimi.busayo@gmail.com>
     *
     * @param Request $request
     * @param int $recipeId
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function update(Request $request, int $recipeId)
    {
        Auth::secureBasic($request);

        if ($violations = Validator::updateRecipeValidator($request->request->all())) {
            return $this->error(ApiError::VALIDATION_ERR(), $violations, 400);
        }

        if ($this->recipeRepo->find($recipeId)) {
            $this->recipeRepo->update($request->request->all(), $recipeId);
            return $this->success($this->recipeRepo->find($recipeId));
        }

        return $this->error(ApiError::NO_RESOURCE(), 'No such Resource');
    }

    /**
     * @author Arotimi Busayo <arotimi.busayo@gmail.com>
     *
     * @param Request $request
     * @param int $recipeId
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function delete(Request $request, int $recipeId)
    {
        Auth::secureBasic($request);

        $this->recipeRepo->delete($recipeId);

        return $this->success('Recipe deleted successfully');
    }

    /**
     * @author Arotimi Busayo <arotimi.busayo@gmail.com>
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function search(Request $request)
    {
        $searchString = $request->query->get('name');

        if ($violations = Validator::createSearchValidator(['name' => $searchString])) {
            return $this->error(ApiError::VALIDATION_ERR(), $violations, 400);
        }

        return $this->success($this->recipeRepo->findBy('name', $searchString));
    }
}
