<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
		<title>{{ config('adminlte.name', 'Bright Matrimony') }} @if(@$page_title) - {{$page_title}} @endif</title>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            <div class="content">
				<table>
					<p>{{ $template_data->message }}</p>
				</table>
            </div>
        </div>
    </body>
</html>
