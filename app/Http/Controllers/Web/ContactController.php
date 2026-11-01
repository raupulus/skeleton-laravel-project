<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\ContactRequest;
use App\Mail\ContactMail;
use App\Services\EmailService;
use App\Services\SeoService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

/**
 * Controlador para el formulario de contacto público del sitio.
 * Gestiona la visualización del formulario y el envío del mensaje.
 */
class ContactController extends Controller
{
    /**
     * Muestra el formulario de contacto.
     *
     * @param  SeoService  $seo  Servicio para gestión de meta tags SEO
     * @return View Vista del formulario de contacto
     */
    public function show(SeoService $seo): View
    {
        $seo->setTitle(__('messages.contact').' - '.setting('site_title', config('app.name')))
            ->setDescription(__('messages.contact_seo_description'))
            ->setUrl(route('contact'))
            ->setBreadcrumbs([
                ['name' => __('messages.home'), 'url' => route('home')],
                ['name' => __('messages.contact'), 'url' => route('contact')],
            ]);

        return view('contact', compact('seo'));
    }

    /**
     * Procesa el envío del formulario de contacto.
     * Valida los datos, envía el email (registrándolo en sent_emails) y redirige con confirmación.
     *
     * @param  ContactRequest  $request  La petición validada del formulario
     * @param  EmailService  $emailService  Servicio de envío de emails
     * @return RedirectResponse Redirección con mensaje de éxito
     */
    public function send(ContactRequest $request, EmailService $emailService): RedirectResponse
    {
        $data = $request->validated();

        // Enviar email al destinatario configurado y registrarlo en sent_emails automáticamente
        $emailService->send(
            new ContactMail($data),
            setting('contact_email', config('mail.from.address')),
            'Contacto: '.$data['subject']
        );

        return redirect()->route('contact')->with('success', __('messages.contact_success'));
    }
}
