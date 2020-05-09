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
use function dd;
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

        // TODO → Guardar estos emails marcados como spam en la DB
        // TODO → Pedir validación por email antes de enviar este correo

        ## Validación del captcha
        $googleRecaptcha = (new \ReCaptcha\ReCaptcha(config('constant.google_recaptcha_secret')))
            ->setExpectedAction('contact')
            ->verify($request->get('g_recaptcha'), $request->ip());

        if (!$googleRecaptcha->isSuccess()) {
            return view('contact.view')->with([
                'message' => [
                    'danger' => [
                        'No se ha validado el captcha correctamente'
                    ],
                ],
            ]);
        }

        ## Almaceno la puntuación que le da google recaptcha v3
        $score = $googleRecaptcha->getScore();

        if ($score < 0.3) {
            return view('contact.view')->with([
                'message' => [
                    'danger' => [
                        'El mensaje no se ha enviado, tienes una puntuación de spam elevada según google. Si crees que es un error contacta con el administrador del sitio y/o con google'
                    ],
                ],
            ]);
        }

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
