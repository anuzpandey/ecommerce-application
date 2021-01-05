<?php

namespace App\Http\Controllers;

use App\Traits\FlashMessages;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;

class BaseController extends Controller
{
    use FlashMessages;

    protected $data = null;

    /**
     * Set the page title and subtitle
     * This function is taking two parameters $title and $subtitle. We use the view() helper function to attach them using share() method.
     * @param $title
     * @param $subTitle
     */
    protected function setPageTitle($title, $subTitle)
    {
        view()->share(['pageTitle' => $title, 'subTitle' => $subTitle]);
    }

    /**
     * Show error page with our custom message and type of error page we want to load.
     * We are loading an error view from errors folder based on the error type.
     * By default, it will be a 404 error page and passing the custom message to it using the $data property.
     * @param int $errorCode
     * @param null $message
     * @return Response
     */
    protected function showErrorPage($errorCode = 404, $message = null)
    {
        $data['message'] = $message;
        return response()->view('errors.' . $errorCode, $data, $errorCode);
    }

    /**
     * If we are using ajax or VueJs in our application, then we might need to send a JSON response,
     * so we will add the responseJson method like below.
     * @param bool $error
     * @param int $responseCode
     * @param array $message
     * @param null $data
     * @return JsonResponse
     */
    protected function responseJson($error = true, $responseCode = 200, $message = [], $data = null)
    {
        return response()->json([
            'error' => $error,
            'response_code' => $responseCode,
            'message' => $message,
            'data' => $data
        ]);
    }

    /**
     * Redirect to a page or route if the request is HTTP,
     * @param $route
     * @param $message
     * @param string $type
     * @param bool $error
     * @param bool $withOldInputWhenError
     * @return RedirectResponse
     */
    protected function responseRedirect($route, $message, $type = 'info', $error = false, $withOldInputWhenError = false)
    {
        $this->setFlashMessage($message, $type); // Setting the flash Message.
        $this->showFlashMessages();              // Showing the Flash message which are actually setting the messages to session.

        // If there is a error with input, return back Else, redirect to the route provided.
        return ($error && $withOldInputWhenError)
            ? redirect()->back()->withInput()
            : redirect()->route($route);
    }

    /**
     * Redirect the user to the previous page
     * @param $message
     * @param string $type
     * @param bool $error
     * @param bool $withOldInputWhenError
     * @return RedirectResponse
     */
    protected function responseRedirectBack($message, $type = 'info', $error = false, $withOldInputWhenError = false)
    {
        $this->setFlashMessage($message, $type);
        $this->showFlashMessages();

        return redirect()->back();
    }
}
