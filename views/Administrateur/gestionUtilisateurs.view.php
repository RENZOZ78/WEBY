

<?php
  $page_description = "Page de gestion des droits" ;
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
               <th>Login</th>
               <th>Validation</th>
               <th>Rôle</th>
             </tr>
             <?php foreach ($utilisateurs as $utilisateur) : ?>
               <tr>
                 <td><?= $utilisateur['login'] ?></td>
                 <td><?= (int)$utilisateur['is_valid'] === 0 ? "non-validé" : "validé" ?></td>
                 <td><?= $utilisateur['role'] ?></td>
               </tr>
             <?php endforeach; ?>
           </thead>
        </table>


           </div>
       </div>
   </section>
