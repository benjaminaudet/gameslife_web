<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/fr_FR/sdk.js#xfbml=1&version=v2.0";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
     <!-- Footer
      ================================================== -->
      <footer id="footer">
      
        <!-- Top -->
        <div class="top">
        
          <!-- Container -->
          <div class="container">
          
            <!-- Row -->
            <div class="row">

              <!-- Column -->
              <div class="col-sm-3 col-md-4">
			  
			    <h5>Statistiques</h5>
                <p>     

                  <strong>Membres inscrits</strong> :<br>
                  <?php echo inscrit_today($bdd);?> aujourd'hui / <?php echo inscrit($bdd);?> totals<br><br>

                  <strong>Visites</strong> :<br>
                  <?php echo statistique_jour($bdd); ?> aujourd'hui / <?php echo statistique_all($bdd); ?> totals

              </p>

              </div>
              <!-- Column /END -->
            
              <!-- Column -->
              <div class="col-sm-3 col-md-4">
                <h5>Nous contacter</h5>
                <div id="footer-tweets">E-mail : <strong><a href="mailto:<?php echo $contactmail; ?>"><?php echo $contactmail; ?></a></strong></div>
              </div>
              <!-- Column /END -->
            
              <!-- Column -->
              <div class="col-sm-3 col-md-4">
                <h5>Liens</h5>
                <ul class="links underline">
                  <li><a href="../accueil/">Accueil</a></li>
                  <li><a href="../boutique/">Boutique</a></li>
                  <li><a href="#">Forum</a></li>
                  <li><a href="../voter/">Voter</a></li>
                </ul>
              </div>
              <!-- Column /END -->
              
            </div>
            <!-- /Row -->
          
          </div>
          <!-- /Container -->
          
        </div>
        <!-- /Top -->
        
        <!-- Bottom -->
        <div class="bottom">
        
          <!-- Container -->
          <div class="container">
          
            <ul class="social-buttons colored-bg-on-hover round clearfix">
							<li><a href="<?php echo $lienfb; ?>"><i class="fa fa-facebook"></i></a></li>
							<li><a href="<?php echo $lienskype; ?>"><i class="fa fa-skype"></i></a></li>
							<li><a href="<?php echo $lientwitter; ?>"><i class="fa fa-twitter"></i></a></li>
							<li><a href="<?php echo $liengoogleplus; ?>"><i class="fa fa-google-plus"></i></a></li>
						</ul>
            
            <span class="copy-text"><?php echo SITE; ?> 2014 &copy; - Copyright - Tous droits r&eacute;serv&eacute;s par <a href="http://samantcms.fr/">SamantCMS</a>. Th&egrave;me by <a href="http://crayzeur.fr/">CrayzeurFR</a> .</span>
            
          </div>
          <!-- /Container -->
          
        </div>
        <!-- /Bottom -->

      </footer>
      <!-- /Footer
      ================================================== -->

    </div>	
    <!-- /Page Wrapper
    ================================================== -->
    
    <!-- JavaScript
    ================================================== -->
    <script src="../js/jquery-1.8.3.min.js"></script>
    <script src="../bootstrap/js/bootstrap.min.js"></script>
    <script src="../js/jquery.bxslider-rahisified.js"></script>
    <script src="../js/jquery.prettyPhoto.js"></script>
    <script src="../js/jflickrfeed.custom.js"></script>
    <script src="../js/tweetable.jquery.js"></script>
    <script src="../js/jquery.timeago.js"></script>
    <script src="../js/template.js"></script>
	<script src="../ajax/query.js"></script>

    <!-- /JavaScript
    ================================================== -->
  </body>
</html>