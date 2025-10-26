

<?php
  $page_description = "Page de gestion des produits" ;
  $costum_css= "projets.css";
  //$page_content=  include "inc/content_profil.php";
  //phpinfo();
 ?>


 <!-- SECTION ABOUT-->
 <section id="aPropos">
     <div class="container">
         <div class="row">

         <table class="table">
           <thead>
             <tr>
               <th>Id produits</th>
               <th>Désignation</th>
               <th>Prix</th>
             </tr>
             <?php foreach ($produits as $produit) : ?>
               <tr>
                 <td><?= $produit['id'] ?></td>
                 <td><?= $produit['designation'] ?></td>
                 <td><?= $produit['prix'] ?></td>
               </tr>
             <?php endforeach; ?>
           </thead>
        </table>


           </div>
       </div>
   </section>
