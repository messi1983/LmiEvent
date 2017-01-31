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
//	$("form input.datepicker").datepicker({
//		showOn: "both",
//		buttonImage: 'http://jqueryui.com/resources/demos/datepicker/images/calendar.gif',
//		buttonImageOnly: true,
//		dateFormat: 'dd-mm-yy',
//		defaultDate:null,
//		changeYear:true,
//		yearRange: '-20:+1',
////		buttonText: "Vignette calendrier"
//		firstDay:1
//	});//.attr("readonly","readonly");
	
	$('.datetimepicker').datetimepicker({
		language: 'fr',
		format: 'yyyy/MM/dd hh:mm'
	});
	
	// Gestion centralisee des checkboxes d'un tableau
	$('.all').click(function() {
        var c = this.checked;
		var cases = $(this).closest('form').find(':checkbox');
		cases.prop('checked', c);		
    });
	
	// Gestion du click sur une checkbox 
	$(':checkbox').click(function() {
		var allCases = $(this).closest('form').find('.all');
        var c = this.checked;
        
        if(!c) {
        	allCases.prop('checked', false);
        } else {
        	var cbxChecked = $(this).closest('form').find(':checkbox:checked').length;
        	var cbx = $(this).closest('form').find(':checkbox').length;
        	
        	if(cbxChecked === cbx - 1) {
        		$(this).closest('form').find('.all').prop('checked', true);
        	}
        }
    });
	
	// Allow to kwnow if at least one checkbox has ben checked
	function checkIfAtLeastOneCheckBoxChecked(button) {
		var cbxChecked = button.closest('form').find(':checkbox:checked').length;
		
		return cbxChecked !== 0;
	}
	
	// Gestion centralis�e du bouton "supprimer"
	$('.suppress').click(function() {
		var result = checkIfAtLeastOneCheckBoxChecked($(this));
		if(result) { 
			$("#action").val('SUPPRESS');
		} else {
			var self = $(this), content = $('.content'); 
			$('#dialog-message').bPopup({
				modalClose: false,
				opacity: 0.6,
				positionStyle: 'fixed',
				onOpen: function() {
					content.show();
				},
				onClose: function() {
					content.hide();
				}
			});
			return false;
		}
		return true;		
    });
	
	// Gestion centralisee du bouton "nouveau"
	$('.new').click(function() {
		$('#dialog-message').bPopup({
			content:'html',
			contentContainer:'.content',
			loadUrl: $(this).attr("href")
		});
		return false;		
    });
	
	$('#publish').click(function() {
		var result = checkIfAtLeastOneCheckBoxChecked($(this));
		if(result) { 
			$("#action" ).val('PUBLISH');
		} else {
			alert('Pas bon aussi');
			return false;
		}
		return true;
    });
	
	$('#unpublish').click(function() {
		var result = true;//checkIfAtLeastOneCheckBoxChecked($(this));
		if(result) { 
			$("#action").val('UNPUBLISH');
		} else {
			alert('Pas bon aussi');
			return false;
		}
		return true;
    });
	
	$(':file').change(function() {
		$(this).parent().find('div').remove();
    });
	
});