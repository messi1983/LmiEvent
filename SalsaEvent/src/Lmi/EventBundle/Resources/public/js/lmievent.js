/* ===================================================
 * menu.js
 * ===================================================
 * Copyright 2013 Twitter, Inc.
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 * ========================================================== */


$(document).ready(function() {
	
	var panels_tab = {
		'.accueil_btn' : '#accueil_panel'
	};
	
	$.each(panels_tab, function(key, val) {
		$(key).click(function(){
			return activePanelFromButton(key);
		});
	});
	
	// active le paneau sous le bouton mentionn�
	function activePanelFromButton(button) {
		$.each(panels_tab, function(key, val) {
		   if(key === button) {
			   $(val).slideToggle("slow");
		   } else if($(val).css('display') != 'none') {
				   $(val).slideToggle("slow");
		   }
		});
		return false;
	}

});