<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
		<title><?php echo e(config('adminlte.name', 'Bright Matrimony')); ?> <?php if(@$page_title): ?> - <?php echo e($page_title); ?> <?php endif; ?></title>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            <div class="content">
				<table>
					<p><?php echo e($template_data->message); ?></p>
				</table>
            </div>
        </div>
    </body>
</html>
<?php /**PATH D:\Users\Sania\matrimonial\bright-metromonial\resources\views/email-templates/support.blade.php ENDPATH**/ ?>