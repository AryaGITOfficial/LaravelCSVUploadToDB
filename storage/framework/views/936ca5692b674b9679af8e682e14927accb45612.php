<!doctype html>
<html>
  <head>
    <title>Import CSV Data to MySQL database with Laravel</title>
  </head>
  <body>
     <!-- Message -->
     <?php if(Session::has('message')): ?>
        <p ><?php echo e(Session::get('message')); ?></p>
     <?php endif; ?>

     <!-- Form -->
     <form method='post' action='/uploadFile' enctype='multipart/form-data' >
       <?php echo e(csrf_field()); ?>

       <input type='file' name='file' >
       <input type='submit' name='submit' value='Import'>
     </form>
  </body>
</html><?php /**PATH /var/www/html/Project_CSV_Upload/resources/views/index.blade.php ENDPATH**/ ?>