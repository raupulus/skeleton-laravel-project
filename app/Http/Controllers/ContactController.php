<?php

namespace App\Http\Controllers;

use App\Email;
use App\Http\Requests\ContactRequest;
use App\Mail\ContactMail;
use App\Http\Requests\ContactoRequest;
use ReCaptcha\ReCaptcha;
use function back;
use Illuminate\Support\Facades\Log;
use function config;
use Exception;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use function env;
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
     */
    public function send(ContactRequest $request)
    {
        ## Validación del captcha
        $score = 0;
        //$score = ReCaptcha::verify($request->get('g-recaptcha-response'), 'contact');

        /*
        if ($score > 0.7) {
            // Perfecto
        } elseif($score > 0.3) {
            // TODO → Pedir confirmación adicional por email antes de enviar
        } else {
            return view('contact.view')->with([
                'message' => [
                    'danger' => [
                        'El mensaje no se ha enviado, tienes una puntuación de spam elevada según google. Si crees que es un error contacta con el administrador del sitio y/o con google'
                    ],
                ],
            ]);
        }
        */

        // NUEVO RECAPTCHA

        //https://medium.com/swlh/laravel-recaptcha-v3-the-easy-way-1e395083201b
        /*
        $googleRecaptcha = (new \ReCaptcha\ReCaptcha(config('constant.google_recaptcha_secret')))
            ->setExpectedAction('contact_form')
            ->verify($request->input('_recaptcha'), $request->ip());

        if (!$response->isSuccess()) {
            abort();
        }    if ($response->getScore() < 0.6) {
        return response()->view('challenge');
           }
        */





        $validar = Validator::make($request->all(), [
            ## Valido el score de la petición con puntuación mínima de 0.3
            //'g-recaptcha-response' => 'required|recaptchav3:contact,0.3'
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
            'recaptcha_score' => $score,
            'app_name' => config('app.name'),
        ];

        $contact = new ContactMail($data);

        // Para testear resultado de email
        //return $contact->render();

        try {
            Mail::send($contact);
        } catch (Exception $e) {
            Log::error(['Intentando enviar email de contacto: ' . $e]);
        }

        $email = $this->dbStore($data);
        $api_response = $this->apiStore($data);

        return view('contact.after_send')->with([
            'message' => 'El mensaje ha sido enviado correctamente',
            'email' => $contact->render(),
        ]);
    }

    /**
     * Almacena el mensaje enviado en la base de datos.
     *
     * @param array $data
     *
     * @return \App\Email
     */
    private function dbStore(array $data)
    {
        $email = new Email($data);
        if (! $email->save()) {
            Log::error('Ha fallado al guardar email de contacto');
            return null;
        }

        return $email;
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

        return null;
    }
}
