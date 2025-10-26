<?php
  $page_description = "Page de profil" ;
  $costum_css= "projets.css";
  //$page_content=  include "inc/content_profil.php";
 ?>

 <!-- SECTION ABOUT-->
 <section id="aPropos">
     <div class="container">
         <div class="row">

           <div class="m-3 auto text-center" id= "mail">
               <div class=" m-0 auto bg alert alert-danger  ">
                 <div class=" col-8">
                   Mail : <?= $utilisateur['mail'] ?> <br>
                   login: <?= $utilisateur['login']?> <br>
                   role: <?= $_SESSION['profil']['role'] ?>
                 </div>
                 <div class=" col-4 w-100px">
                   <img src="<?= URL; ?>public/Assets/images/<?= $utilisateur['image'] ?>" width="100px"  alt="photo de profil" />
                 </div>
                 <form class=" m-2 auto" action="<?= URL ?>compte/validation_modificationImage" enctype="multipart/form-data" method="post">
                   <label for="image">Changer l'image de profil</label> <br>
                   <input type="file" name="image" class="form-control-file" id="image" onchange="submit();" value="">
                 </form>
               </div>
           </div>

           <div class="traitement_mail rounded">
             <!--1-invite de modification du mail------------------------->
              <div class="btn btn-primary" id="mail">
                Modification mail : <?= $utilisateur['mail'] ?>
                <button class="btn btn-primary" id="btnModifMail" type="button" name="button">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
    <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
    <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
  </svg>
                </button>
              </div>

              <!--2-champs de modification mail------------------------------>
              <div class="d-none bg bg-gradient-primary" id="modificationMail">
                <form class=""  method="post" action="<?= URL; ?>compte/validation_modificationMail">
                  <div class="row mt-2   ">
                    <label for="mail" class=" btn btn-primary col-3 col-form-label">Entrer votre Nouveau mail :</label>
                    <div class="col-7">
                      <input type="mail" class="form-control" name="mail" value="<?= $utilisateur['mail'] ?>" />
                    </div>
                    <div class="col-2">
                      <button type="btn btn-success" id=btnValidModifMail >
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check2-all" viewBox="0 0 16 16">
    <path d="M12.354 4.354a.5.5 0 0 0-.708-.708L5 10.293 1.854 7.146a.5.5 0 1 0-.708.708l3.5 3.5a.5.5 0 0 0 .708 0l7-7zm-4.208 7-.896-.897.707-.707.543.543 6.646-6.647a.5.5 0 0 1 .708.708l-7 7a.5.5 0 0 1-.708 0z"/>
    <path d="m5.354 7.146.896.897-.707.707-.897-.896a.5.5 0 1 1 .708-.708z"/>
  </svg>
                      </button>

                    </div>
                  </div>
                </form>
              </div> <br><br>
           </div>

             <!--Bouton qui modifie le mdp ----------------------------------------------->
             <div class="mt-2">
               <a href="<?= URL ?>compte/modificationPassword" class="btn btn-warning"> Changer le mot de passe</a>
             </div>

             <div class=" mt-2">
               <button id="btnSupCompte" class="btn btn-danger">Supprimer son compte</button>
             </div>

             <!-- Bouton qui supprime le compte ------------------------------------------->
             <div id="suppressionCompte" class="d-none m-2">
               <div class="alert alert-danger">
                 Veuillez confirmer la suppression du compte.
                 <br />
                 <a href="<?= URL ?>compte/suppressionCompte" class="btn btn-danger"> Je veux supprimer défénitivement mon compte</a>
               </div>
             </div>
             <!-- Formulaire -->

           </div>
       </div>
   </section>
