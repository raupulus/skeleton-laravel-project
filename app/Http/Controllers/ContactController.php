<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use App\Mail\ContactMail;
use App\Http\Requests\ContactoRequest;
use Illuminate\Support\Facades\Log;
use function config;
use Exception;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Lunaweb\RecaptchaV3\Facades\RecaptchaV3;
use function dd;
use function view;

/**
 * Class ContactController
 * Controlador para las acciones de contacto.
 *
 * @package App\Http\Controllers
 */
class ContactController extends Controller
{

    /**
     * Devuelve la vista de contacto.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function view()
    {
        return view('contact.view');
    }

    /**
     * Envía el mensaje y además lo almacena en la db y envía a la api.
     *
     * @param \App\Http\Requests\ContactRequest $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|void
     * @throws \ReflectionException
     */
    public function send(ContactRequest $request)
    {
        ## Validación del captcha
        $score = RecaptchaV3::verify($request->get('g-recaptcha-response'), 'contact');

        if($score > 0.7) {
            // Perfecto
        } elseif($score > 0.3) {
            // TODO → Pedir confirmación adicional por email antes de enviar
        } else {
            //return abort(400, 'You are most likely a bot');
            return view('contact.after_send')->with([
                'message' => 'El mensaje no se ha enviado, tienes una puntuación de spam elevada según google. Si crees que es un error contacta con el administrador del sitio',
            ]);
        }

        $validar = Validator::make(Input::all(), [
            ## Valido el score de la petición con puntuación mínima de 0.3
            'g-recaptcha-response' => 'required|recaptchav3:contacto,0.3'
        ]);


        $data = [
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'phone' => $request->get('phone'),
            'message' => $request->get('message'),
            'privacity' => $request->get('privacity'),
            'contactme' => $request->get('contactme'),
            'server_ip' => $request->ip(),  // Ip del servidor
            'client_ip' => $request->getClientIp(),  // Ip del cliente
            'subject' => 'Formulario de contacto en ' . config('app.name'),
        ];

        $contact = new ContactMail($data);

        return $contact->render();
        try {
            Mail::send($contact);
        } catch (Exception $e) {
            Log::error(['Intentando enviar email de contacto: ' . $e]);
        }

        $this->dbStore($data);
        $this->apiStore($data);

        dd('final');
        return view('contact.after_send')->with([
            'message' => 'El mensaje ha sido enviado correctamente',
        ]);
    }

    /**
     * Almacena el mensaje enviado en la base de datos.
     *
     * @param array $data
     */
    private function dbStore(array $data)
    {

    }

    /**
     * Envía a la API el mensaje para ser almacenado ahí.
     *
     * @param array $data
     */
    private function apiStore(array $data)
    {
        // TODO → La API esperará: to, from, message, created_at
        // TODO → Crear política para que solo pueda ejecutarse si hay api
        // configurada
    }
}
