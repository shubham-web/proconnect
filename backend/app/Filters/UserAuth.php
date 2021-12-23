<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class UserAuth implements FilterInterface
{
    /**
     * Do whatever processing this filter needs to do.
     * By default it should not return anything during
     * normal execution. However, when an abnormal state
     * is found, it should return an instance of
     * CodeIgniter\HTTP\Response. If it does, script
     * execution will end and that Response will be
     * sent back to the client, allowing for error pages,
     * redirects, etc.
     *
     * @param RequestInterface $request
     * @param array|null       $arguments
     *
     * @return mixed
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        $response = service("response");
        $userModel = model(\App\Models\Users::class);
        $accessTokensModel = model(\App\Models\AccessTokensModel::class);

        if (is_null($arguments)) {
            return $response->setStatusCode(401)->setJSON([
                "message" => "Access role is not specified in filter for this route.",
            ]);
        }

        $authHeader = $request->header("Authorization");

        if (is_null($authHeader)) {
            $response->setStatusCode(403);
            return $response->setJSON([
                "message" => "Authorization token is required.",
            ]);
        }
        $headerValue = $authHeader->getValue();
        $token = trim(str_replace("Bearer", "", $headerValue));


        $potentialUser = $accessTokensModel->getUserIdFromToken($token);

        if (isset($potentialUser["error"])) {
            return $response->setStatusCode(403)->setJSON([
                "message" => $potentialUser["error"]
            ]);
        }

        $targetUser = $userModel->getActiveUser($potentialUser["userId"]);
        if (isset($targetUser["error"])) {
            return $response->setStatusCode(403)->setJSON([
                "message" => $targetUser["error"]
            ]);
        }

        if (!in_array($targetUser["user"]["role"], $arguments)) {
            return $response->setStatusCode(403)->setJSON([
                "message" => "You don't have required " . implode("and", $arguments) . " privileges.",
            ]);
        }

        $request->setHeader("pc_user", json_encode($targetUser["user"]));
        $request->setHeader("pc_user_id", $targetUser["user"]["id"]);

        return $request;
    }

    /**
     * Allows After filters to inspect and modify the response
     * object as needed. This method does not allow any way
     * to stop execution of other after filters, short of
     * throwing an Exception or Error.
     *
     * @param RequestInterface  $request
     * @param ResponseInterface $response
     * @param array|null        $arguments
     *
     * @return mixed
     */
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        //
    }
}
