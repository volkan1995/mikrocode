<!DOCTYPE html>
<html lang="tr">
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="description" content="">
      <meta name="author" content="">
       <title>Sayfa Bulunamadı</title>
       <base href="<?=mt_tema?>"/>
      <link href="css/bootstrap.min.css" rel="stylesheet">
      <link href="css/style.css" rel="stylesheet">
      <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
   </head>
   <body>
      <section class="not-found">
         <div class="container">
            <div class="row">
               <div class="col-sm-6 col-sm-offset-3 text-center">
                  <div class="error-page">
                     <h1 class="error"> 404 </h1>
                     <h2>Opps</h2>
                     <div class="error-details">
                        Üzgünüz, aradığınız sayfa bulunamadı!
                     </div>
                     <form class="form-search" action="/markalar/tum-markalar/tum-modeller/">
                        <div class="form-group">
                           <input type="text" name="q" class="form-control found-search" placeholder="Yeniden arayın">
                        </div>
                         <button type="submit" class="btn btn-default btn-large btn-lg">Ara</button>
                        <a href="/" class="btn btn-default btn-large btn-lg">Anasayfa</a>
                     </form>
                  </div>
               </div>
            </div>
         </div>
      </section>
      <script src="js/jquery.js"></script>
   </body>
</html>