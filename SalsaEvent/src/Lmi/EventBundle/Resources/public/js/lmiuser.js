/* ===================================================
 * form.js
 * ===================================================
 * Copyright 2013 Twitter, Inc.
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 * ========================================================== */

$(document).ready(function(){
	
	// Dedtail panels
	var toggle_pannels = {
		'.liste_cov_recus'     : '#cov_detail_panel_recus',
		'.liste_cov_emis'      : '#cov_detail_panel_emis',
		'.liste_heb'           : '#heb_detail_panel',
		'.notif'               : '#notif_panel',
		'.coordB'              : '#coordB_panel',
		'.profil'              : '#profil_panel',
		'.liste_grp'           : '#grp',
		'.carInfos'            : '#carInfos_panel',
		'.liste_contacts'      : '#contacts_detail_panel'
	};
	
	$.each(toggle_pannels, function(key, val) {
		$(key).click(function(){
			return unstackBlock(key);
		});
	});
	
	// unstack block under a button
	function unstackBlock(button) {
		$.each(toggle_pannels, function(key, val) {
		   if(key === button) {
			   $(val).slideToggle("slow");
		   }
		});
		return false;
	}
	
	// Dedtail panels
	var dash_panels = {
		'#mesCovs'             : '#userCarpooling',
		'#userEvent'           : '#userEvent',
		'#monProfil'           : '#userProfil',
		'#mesLocations'        : '#userAccomodation'
	};
	
	$.each(dash_panels, function(key, val) {
		$(key).click(function(){
			updateVisibility(key);
			echo('merde');
		});
	});
	
	// unstack block under a button
	function updateVisibility(button) {
		$.each(dash_panels, function(key, val) {
		   if(key === button) {
			   $(val).css('display', 'block');
		   } else {
			   $(val).css('display', 'none');
		   }
		});
		return false;
	}
		
	$('#identification').click(function() {
		$('#user-actions li > ul').css('display', 'block');
		return false;
    });
	
	$('#menu,#content').click(function() {
		$('#user-actions  li > ul').css('display', 'none');
	});
	
	
	// Gestion de la couleur de detail ("+" ou "-") lorsque la souris est dessus
	$(".detail").hover(
	  function() {
		if($(this).hasClass("plus")) {
			$(this).removeClass("plus");
		    $(this).addClass( "plus-rouge");  
		} else {
			$(this).removeClass("moins");
		    $(this).addClass( "moins-rouge");
		}
	  }, function() {
		if($(this).hasClass("plus-rouge")) {
			$(this).removeClass("plus-rouge");
		    $(this).addClass("plus");
		} else {
			$(this).removeClass("moins-rouge");
		    $(this).addClass("moins");
		}
	  }
	);
	
	// gestion des images de détail
	$(".detail").click(
	  function() { // remplace l'image "+" par l'image "-" et vice versa
		  if($(this).hasClass("plus-rouge")) {
			   $(this).removeClass("plus-rouge");
			   $(this).addClass("moins-rouge");
		   } else if($(".detail").hasClass("moins-rouge")) {
			   $(this).removeClass("moins-rouge");
			   $(this).addClass("plus-rouge");
		   }
	  }
	);
	
});