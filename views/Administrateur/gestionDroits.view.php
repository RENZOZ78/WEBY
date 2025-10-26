

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
                 <td>
                   <?php if($utilisateur['role']=== "administrateur" || $utilisateur['role']=== "superAdministrateur" ) :?>
                      <?= $utilisateur['role'] ?>
                   <?php else: ?>
                      <form method="POST" action="<?= URL ?>administration/validation_modificationRole" >
                        <input type="hidden" name="login" value="<?= $utilisateur['login'] ?> ">
                        <select class="form-select" name="role" onchange="confirm('confirmez vous la modification ? ') ? submit() : document.location.reload()">
                          <option value="utilisateur"<?= $utilisateur['role'] === "utilisateur"? "selected" : ""?>>Utilisateur</option>
                          <option value="administrateur"<?= $utilisateur['role'] === "administrateur"? "selected" : ""?> >Administrateur</option>
                          <option value="superAdministrateur"<?= $utilisateur['role'] === "superAdministrateur"? "selected" : "" ?>>Super Administrateur</option>
                        </select>
                      </form>
                   <?php endif; ?>
                 </td>
               </tr>
             <?php endforeach; ?>
           </thead>
        </table>


           </div>
       </div>
   </section>
