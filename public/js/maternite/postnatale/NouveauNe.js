
function ajoutNouveauNe(nbEnfants){
	
	
	$('#tabNouveauNe').html('');
	var elem='<div id="tabsNouveauNe"> <ul>';
	var cont ='';
	
	for(var i=1; i<= nbEnfants; i++){
		 var ong=('<li ><a href="#nv_onglet-'+i+'">Nouveau N&eacute;'+i+'</a></li>');	 
		
		  cont +=( '<div id="nv_onglet-'+i+'">'+
				 '<table id="styleNv">'+  
			       '<tr >'+
			          '<td  class="antecedent_go">'+ 
			                  '<div  class="nvDiv1">'+
			                      '<label  class="nvDiv1label">Vivant et bien portant&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <select id="viv_bien_portant_'+i+'"><option value="Oui">oui</option><option value="Non">Non</option></select></label>'+
			                   '</div>'+ 
			                  
			                   '<div class="nvDiv2">'+
			                       '<label class="nvDiv2label"> Note</label>'+
		                        ' </div>'+	
		                         '<div class="nvDiv3">'+
			                         '<label class="nvDiv3label"><input id="n_viv_bien_'+i+'" type="text"></input> </label>'+
		                         '</div>'+         
			          '</td>'+
			       '</tr>'+
			       '<tr >'+
			       '<td  class="antecedent_go">'+ 
	                  '<div  class="nvDiv1">'+
	                      '<label  class="nvDiv1label">Vivant avec mal formation&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <select id="viv_mal_form_'+i+'"><option value="Oui">oui</option><option value="Non">Non</option></select></label>'+
	                   '</div>'+ 
	                  
	                   '<div class="nvDiv2">'+
	                       '<label class="nvDiv2label"> Note</label>'+
                     ' </div>'+	
                      '<div class="nvDiv3">'+
	                         '<label class="nvDiv3label"><input id="n_mal_form_'+i+'" type="text"></input> </label>'+
                      '</div>'+         
	          '</td>'+
			       '</tr>'+			     			       
			       '</tr>'+
			       '<tr >'+
			       '<td  class="antecedent_go">'+ 
	                  '<div  class="nvDiv1">'+
	                      '<label  class="nvDiv1label">Malade&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <select id="malade_'+i+'"><option value="Oui">oui</option><option value="Non">Non</option></select></label>'+
	                   '</div>'+ 
	                  
	                   '<div class="nvDiv2">'+
	                       '<label class="nvDiv2label"> Note</label>'+
                     ' </div>'+	
                      '<div class="nvDiv3">'+
	                         '<label class="nvDiv3label"><input id="n_malade_'+i+'" type="text"></input> </label>'+
                      '</div>'+         
	          '</td>'+
			       '</tr>'+
		     
			       '<tr >'+
			          '<td  class="antecedent_go">'+
			          '<div class="nvDiv1" >'+
				       '<label  class="nvDiv1label">D&eacute;ced&eacute;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <select id="decede_'+i+'"><option value="Oui">oui</option><option value="Non">Non</option></select></label>'+
			       '</div>'+
	        
			       '<div class=" nvDateDiv1" >'+
				       '<label class="nvDateLabel1">Date</label>'+
			       '</div>'+
			      ' <div class="nvDateDiv2">'+
				       '<label class="nvDateLabel2"> <input id="date_dece_'+i+'" type="text"></input>  </label>'+
			      
			       '</div>'+
			   '<div class=" nvHeureDiv1">'+
				       '<label class=" nvHeureDiv1label">Heure</label>'+
			       '</div>'+
			       '<div class=" nvHeureDiv2">'+
				       '<label class=" nvHeureDiv2label" > <input id="heure_dece_'+i+'" type="Time"></input>  </label>'+
			       '</div>'+
			        '<div class="nvCauseDiv">'+
				       '<label class="nvCauseLabel" >cause <input id="cause_dece_'+i+'" type="text"></input> </label>'+
			       '</div> '+
			          '</td>'+
			       '</tr>'+
			       
			 
		          
	         
		     
			    ' </table>'+
			   
	    '</div>'
		);	
		 
		 
		elem+=ong;
	}
	elem+="</ul>"+cont+" </div>  <script> $('#tabsNouveauNe').tabs(); </script>";
	
	
	$('#tabNouveauNe').html(elems);
	


}

$('.BbAttendu').toggle(false);



setimeout($('#date_dece_').datepicker(
		$.datepicker.regional['fr'] = {
				closeText: 'Fermer',
				changeYear: true,
				yearRange: 'c-80:c',
				prevText: '&#x3c;Préc',
				nextText: 'Suiv&#x3e;',
				currentText: 'Courant',
				monthNames: ['Janvier','Fevrier','Mars','Avril','Mai','Juin',
				'Juillet','Aout','Septembre','Octobre','Novembre','Decembre'],
				monthNamesShort: ['Jan','Fev','Mar','Avr','Mai','Juin',
				'Jul','Aout','Sep','Oct','Nov','Dec'],
				dayNames: ['Dimanche','Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi'],
				dayNamesShort: ['Dim','Lun','Mar','Mer','Jeu','Ven','Sam'],
				dayNamesMin: ['Di','Lu','Ma','Me','Je','Ve','Sa'],
				weekHeader: 'Sm',
				dateFormat: 'dd/mm/yy',
				firstDay: 1,
				isRTL: false,
				showMonthAfterYear: false,
				yearRange: '1900:2050',
				showAnim : 'bounce',
				changeMonth: true,
				changeYear: true,
				yearSuffix: '',
				maxDate: 0
		}
));
























