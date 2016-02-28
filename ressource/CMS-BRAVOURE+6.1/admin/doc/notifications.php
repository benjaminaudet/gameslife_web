				<script language="javascript">
				function request(url,cadre) {
					var XHR = null;

					if(window.XMLHttpRequest) // Firefox
						XHR = new XMLHttpRequest();
					else if(window.ActiveXObject) // Internet Explorer
						XHR = new ActiveXObject("Microsoft.XMLHTTP");
					else { 
						alert("Votre navigateur ne supporte pas les objets XMLHTTPRequest...");
						return;
					}
					XHR.open("GET",url, true);

					XHR.onreadystatechange = function attente() {

					if(XHR.readyState == 4)     {

					document.getElementById(cadre).innerHTML = XHR.responseText;
				   }
					}
					XHR.send(null);		
					return;
				}
				</script>
				<span id="activity" class="activity-dropdown"> 
					<i class="fa fa-user"></i>
				</span>

				<div class="ajax-dropdown">

					<!-- the ID links are fetched via AJAX to the ajax container "ajax-notifications" -->
					
					<div class="btn-group btn-group-justified" data-toggle="buttons">
						<label class="btn btn-default">
							<input type="radio" name="activity" onclick="request('notifications.php?show=1','xmlhttp');return(false)">
							Achats</label>
						<label class="btn btn-default">
							<input type="radio" name="activity" onclick="request('notifications.php?show=2','xmlhttp');return(false)">
							News </label>
					</div>

					<!-- notification content -->
					<div class="ajax-notifications custom-scroll" id="xmlhttp">

						<div class="alert alert-transparent">
							<h4>Cliquez sur l'un des boutons ci-dessus</h4>
							
						</div>

						<i class="fa fa-lock fa-4x fa-border"></i>

					</div>
					<!-- end notification content -->

					<!-- footer: refresh area -->
					<span> <?php echo date ('d/m/Y - H:i', time());?>
						<button type="button" data-loading-text="<i class='fa fa-refresh fa-spin'></i> Loading..." class="btn btn-xs btn-default pull-right">
							<i class="fa fa-refresh"></i>
						</button> </span>
					<!-- end footer -->

				</div>