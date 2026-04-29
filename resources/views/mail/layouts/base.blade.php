<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"></head>
<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 20px;">
<div style="max-width: 600px; margin: 0 auto; background: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
    <div style="background-color: #4f46e5; padding: 20px; text-align: center;"><h1 style="color: #ffffff; margin: 0; font-size: 24px;">{{ setting('site_title', config('app.name')) }}</h1></div>
    <div style="padding: 30px;">@yield('content')</div>
    <div style="background-color: #f9fafb; padding: 15px; text-align: center; font-size: 12px; color: #6b7280;">
        <p>&copy; {{ date('Y') }} {{ setting('site_title', config('app.name')) }}.</p>
    </div>
</div>
</body>
</html>
