<!-- resources/views/support.blade.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Support Page</title>
    <style>
        /* Basic styling for the form */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
        }

        .container {
            width: 90%;
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background-color: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        h1 {
            text-align: center;
            font-size: 24px;
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="email"],
        textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 12px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        textarea {
            resize: vertical;
            height: 150px;
        }

        .error {
            color: red;
            font-size: 12px;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background-color: #45a049;
        }

        /* Responsive Design */
        @media (max-width: 600px) {
            .container {
                width: 95%;
                padding: 15px;
            }

            h1 {
                font-size: 20px;
            }

            input[type="text"],
            input[type="email"],
            textarea {
                font-size: 14px;
            }

            button {
                font-size: 14px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Contact Support</h1>

        <form action="<?php echo e(route('support.submit')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <!-- Name input field -->
            <label for="name">Your Name:</label>
            <input type="text" name="name" id="name" value="<?php echo e(old('name')); ?>">
            <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <div class="error"><?php echo e($message); ?></div>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

            <!-- Email input field -->
            <label for="email">Your Email:</label>
            <input type="email" name="email" id="email" value="<?php echo e(old('email')); ?>">
            <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <div class="error"><?php echo e($message); ?></div>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

            <!-- Message textarea -->
            <label for="message">Your Message:</label>
            <textarea name="message" id="message"><?php echo e(old('message')); ?></textarea>
            <?php $__errorArgs = ['message'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <div class="error"><?php echo e($message); ?></div>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

            <button type="submit">Submit</button>
        </form>
    </div>
</body>

</html>
<?php /**PATH D:\Users\Sania\matrimonial\bright-metromonial\resources\views/support.blade.php ENDPATH**/ ?>