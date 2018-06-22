<?php


namespace PostcodeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class PostcodeController
 *
 *
 */
class PostcodeController extends Controller
{
    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function fetchAction(Request $request)
    {
        try {
            $postcode    = $request->get('postcode');
            $houseNumber = $request->get('nummer');

            $address = $this->get('app.postcode.client')->getAddress($postcode, $houseNumber);

            return new JsonResponse($address->toArray());
        } catch (\Exception $exception) {
            return new JsonResponse(['message' => $exception->getMessage()], Response::HTTP_SERVICE_UNAVAILABLE);
        }
    }
}
