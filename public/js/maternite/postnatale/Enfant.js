function ajoutEnfant(nbEnfant){
	
	
	$('#tabEnfants').html('');
	var element='<div id="tabsEnfants" class="tabsEnfants"> <ul>';
	var contenu ='';
	
	for(var i=1; i<= nbEnfant; i++){
		 var onglet=('<li ><a href="#onglet-'+i+'">Enfant'+i+'</a></li>');	 
		
		  contenu +=( '<div id="onglet-'+i+'">'+
				 '<table id="styleEnf">'+  
			       '<tr >'+
			     
			          '<td  class="antecedent_go">'+
		              '<div   class="styleEnfDiv4">'+
		                 '<label 	 class="styleLabel4">Poids(kgs)</label>'+
		              '</div>'+   
		              '<div  class="styleEnfDiv5">'+
		                 '<label class="styleLabel5"><input type="number" min=0 id="poids_'+i+'"></input></label>'+
		              '</div>'+ 
		              '<div   class="styleEnfDiv6">'+
		                 '<label  class="styleLabel5">Note <input id="n_poids_'+i+'" type="text"></input></label>'+
		              '</div>'+ 
		             
		      '</td>'+
		      '<td  class="antecedent_go">'+
              '<div   class="styleEnfDiv4">'+
                 '<label 	 class="styleLabel4">Taille(cm)</label>'+
              '</div>'+   
              '<div  class="styleEnfDiv5">'+
                 '<label class="styleLabel5"><input type="number" min=0 id="taille_'+i+'"></input></label>'+
              '</div>'+ 
              '<div   class="styleEnfDiv6">'+
                 '<label  class="styleLabel6">Note <input id="n_taille_'+i+'" type="text"></input></label>'+
              '</div>'+ 
      '</td>'+
			       '</tr>'+
			    
			       
			       
			       '</tr>'+
			
			       '<tr >'+
			          '<td  class="antecedent_go">'+
			                  '<div class="styleEnfDiv1">'+
			                     '<label  class="styleLabel1" title="">BCG</label>'+
			                  '</div>'+   
			                  '<div  class="styleEnfDiv4">'+
			                     '<label   class="styleLabel4" ><select id="bcg_'+i+'"><option value="Non">Non</option><option value="Oui">Oui</option></select></label>'+
			                  '</div>'+ 
			                  '<div  class="styleEnfDiv6">'+
			                     '<label  class="styleLabel5">Note <input id="n_bcg_'+i+'" type="text"></input></label>'+
			                  '</div>'+ 
			          '</td>'+
			          '<td  class="antecedent_go">'+
		              '<div   class="styleEnfDiv4">'+
		                 '<label 	 class="styleLabel4" title="Infection">Infection</label>'+
		              '</div>'+   
		              '<div  class="styleEnfDiv5">'+
		                 '<label class="styleLabel5"><select id="anti_hepa_'+i+'"><option value="Non">Non</option><option value="Oui">Oui</option></select></label>'+
		              '</div>'+ 
		              '<div   class="styleEnfDiv6">'+
		                 '<label  class="styleLabel6">Note <input id="n_anti_hepa_'+i+'" type="text"></input></label>'+
		              '</div>'+ 
		      '</td>'+
			       '</tr>'+
			       
			       
		         '<tr >'+
		          '<td  class="antecedent_go">'+
		                    
		                  '<div  class="div3">'+
		                     '<label   class="label3" title="Perimetre Cranien">Temperature</label>'+
		                  '</div>'+ 
		                  '<div  class="div5">'+
		                     '<label   class="label5" ><input type="number" min=36 id="cranien_'+i+'"></input></label>'+
		                  '</div>'+ 
		                  '<div   class="styleEnfDiv6">'+
			                 '<label  class="styleLabel5">Note <input id="n_anti_hepa_'+i+'" type="text"></input></label>'+
			              '</div>'+
		          '</td>'+
		          '<td  class="antecedent_go">'+
                  
                  '<div  class="div3">'+
                     '<label   class="label3" title="Perimetre Cranien">Cordon</label>'+
                  '</div>'+ 
                  '<div  class="styleEnfDiv5">'+
                  '<label   class="styleLabel5" ><select id="bcg_'+i+'"><option value="Normal">Normal</option><option value="Anormal">anormal</option></select></label>'+
               '</div>'+ 
               '<div   class="styleEnfDiv6">'+
               '<label  class="styleLabel6	">Note <input id="n_anti_hepa_'+i+'" type="text"></input></label>'+
            '</div>'+
          '</td>'+
		        
		    '</tr>'+
		         '<td  class="antecedent_go">'+
            
                   '<div  class="div3">'+
                     '<label   class="label3" title="Perimetre Cranien">Etat</label>'+
                   '</div>'+ 
                   '<div  class="styleEnfDiv5">'+
                     '<label   class="styleLabel5" ><select id="bcg_'+i+'"><option value="Normal">Normal</option><option value="Anormal">anormal</option></select></label>'+
                   '</div>'+ 
                   '<div   class="styleEnfDiv6">'+
                     '<label  class="styleLabel5	">Note <input id="n_anti_hepa_'+i+'" type="text"></input></label>'+
                   '</div>'+
               '</td>'+
	         '<tr >'+
	         
	         '</tr>'+
		     
	         
		     
			    ' </table>'+
			   
	    '</div>'
		);	
		 
		 
		element+=onglet;
	}
	element+="</ul>"+contenu+" </div>  <script> $('#tabsEnfants').tabs(); </script>";
	
	
	$('#tabEnfants').html(element);
	
	 // $(function() {
	   // $('#tabEnfants').tabs();
	//    $('#tabsEnfants').tabs();
	 // });
	//setTimeout("$('#tabsEnfants').tabs(), 3000");


}


//nouveau ne

function ajoutNouveauNe(nbEnfants){
	
	
	$('#tabNouveauNe').html('');
	var elem='<div id="tabsNouveauNe"    class="tabsNv"> <ul>';
	var cont ='';
	
	for(var i=1; i<= nbEnfants; i++){
		 var ong=('<li ><a href="#nv_onglet-'+i+'">Nouveau N&eacute;'+i+'</a></li>');	 
		
		  cont +=( '<div id="nv_onglet-'+i+'">'+
				 '<table id="styleNv">'+  
			       '<tr >'+
			          '<td  class="antecedent_go">'+ 
			                  '<div  class="nvDiv1">'+
			                      '<label  class="nvDiv1label">Vivant et bien portant&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <select id="viv_bien_portant_'+i+'"><option value="Non">Non</option><option value="Oui">Oui</option></select></label>'+
			                   '</div>'+ 
			                  
			                   '<div class="nvDiv2">'+
			                       '<label class="nvDiv2label"> Note</label>'+
		                        ' </div>'+	
		                         '<div class="nvDiv3">'+
			                         '<label class="nvDiv3label"><input id="n_viv_bien_portant_'+i+'" type="text"></input> </label>'+
		                         '</div>'+         
			          '</td>'+
			       '</tr>'+
			       '<tr >'+
			       '<td  class="antecedent_go">'+ 
	                  '<div  class="nvDiv1">'+
	                      '<label  class="nvDiv1label">Vivant avec mal formation&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <select id="viv_mal_form_'+i+'"><option value="Non">Non</option><option value="Oui">Oui</option></select></label>'+
	                   '</div>'+ 
	                  
	                   '<div class="nvDiv2">'+
	                       '<label class="nvDiv2label"> Note</label>'+
                     ' </div>'+	
                      '<div class="nvDiv3">'+
	                         '<label class="nvDiv3label"><input id="n_viv_mal_form_'+i+'" type="text"></input> </label>'+
                      '</div>'+         
	          '</td>'+
			       '</tr>'+			     			       
			       '</tr>'+
			       '<tr >'+
			       '<td  class="antecedent_go">'+ 
	                  '<div  class="nvDiv1">'+
	                      '<label  class="nvDiv1label">Malade&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <select id="malade_'+i+'"><option value="Non">Non</option><option value="Oui">Oui</option></select></label>'+
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
				       '<label  class="nvDiv1label">D&eacute;ced&eacute;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <select id="decede_'+i+'"><option value="Non">Non</option><option value="Oui">Oui</option></select></label>'+
			       '</div>'+
	        
			       '<div class=" nvDateDiv1" >'+
				       '<label class="nvDateLabel1">Date</label>'+
			       '</div>'+
			      ' <div class="nvDateDiv2 ">'+
				       '<label class="nvDateLabel2 "> <input class="dateCalendar" id="date_deces_'+i+'" type="text"></input>  </label>'+
			      
			       '</div>'+
			   '<div class=" nvHeureDiv1">'+
				       '<label class=" nvHeureDiv1label">Heure</label>'+
			       '</div>'+
			       '<div class=" nvHeureDiv2">'+
				       '<label class=" nvHeureDiv2label" > <input class="heure_dece" id="heure_deces_'+i+'" type="text"></input>  </label>'+
			       '</div>'+
			        '<div class="nvCauseDiv">'+
				       '<label class="nvCauseLabel" >cause <input id="cause_deces_'+i+'" type="text"></input> </label>'+
			       '</div> '+
			          '</td>'+
			       '</tr>'+		     
			    ' </table>'+
			   
	    '</div>'
		);	
		 
		 
		elem+=ong;
	}
	elem+="</ul>"+cont+" </div>  <script> $('#tabsNouveauNe').tabs();$('.heure_dece').chungTimePicker({});$('.dateCalendar').datepicker(" +
			"$.datepicker.regional['fr'] = {" +
			"closeText: 'Fermer'," +
			"changeYear: true," +
			"	yearRange: 'c-80:c'," +
			"prevText: '&#x3c;Préc'," +
			"nextText: 'Suiv&#x3e;'," +
			"currentText: 'Courant'," +
			"monthNames: ['Janvier','Fevrier','Mars','Avril','Mai','Juin'," +
			"'Juillet','Aout','Septembre','Octobre','Novembre','Decembre']," +
	        "monthNamesShort: ['Jan','Fev','Mar','Avr','Mai','Juin'," +
			"'Jul','Aout','Sep','Oct','Nov','Dec']," +
			"dayNames: ['Dimanche','Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi']," +
			"dayNamesShort: ['Dim','Lun','Mar','Mer','Jeu','Ven','Sam']," +
			"dayNamesMin: ['Di','Lu','Ma','Me','Je','Ve','Sa']," +
	         "weekHeader: 'Sm'," +
			"dateFormat: 'dd/mm/yy',"+
			"firstDay: 1,"+
			"isRTL: false,"+
			"showMonthAfterYear: false,"+
			"yearRange: '1900:2050',"+
			"showAnim : 'bounce',"+
			"changeMonth: true,"+
			"changeYear: true,"+
			"	yearSuffix: '',"+
			"maxDate: 0"+
			"}"+
			");</script>";


	$('#tabNouveauNe').html(elem);
	


}


//$('.BbAttendu').toggle(false);
function getBbAttendu(val){ 

	if(val=='0'){
		
		$('.BbAttendu').fadeIn();
		ajoutEnfant( $('#nombre_bb').val()); 
		ajoutNouveauNe( $('#nombre_bb').val());
		$('#nombre_bb').keyup(function () {
			ajoutEnfant( $('#nombre_bb').val()); 
			ajoutNouveauNe( $('#nombre_bb').val()); 
		}).change(function () {
			ajoutEnfant( $('#nombre_bb').val());  
			ajoutNouveauNe( $('#nombre_bb').val()); 
		});	
		
	}	
	else
	{
		$('.BbAttendu').fadeOut();
		ajoutEnfant( val);
		ajoutNouveauNe( val);
	}
		
}



function getEnf(nombre_bb){
	  var indice=1;
	  for(indice=1;indice<=nombre_bb;indice++){
	   //alert(tempArray['sexe_1']);
	   $('.tabsEnfants #sexe_'+indice).val(tempArray['sexe_'+indice]);
	   $('.tabsEnfants #n_sexe_'+indice).val(tempArray['n_sexe_'+indice]);
	   $('.tabsEnfants #poids_'+indice).val(tempArray['poids_'+indice]);
	   $('.tabsEnfants #n_poids_'+indice).val(tempArray['n_poids_'+indice]);
	   $('.tabsEnfants #cri_'+indice).val(tempArray['cri_'+indice]);
	   $('.tabsEnfants #n_cri_'+indice).val(tempArray['n_cri_'+indice]);
	   $('.tabsEnfants #taille_'+indice).val(tempArray['taille_'+indice]);
	   $('.tabsEnfants #n_taille_'+indice).val(tempArray['n_taille_'+indice]);
	   $('.tabsEnfants #malf_'+indice).val(tempArray['malf_'+indice]);
	   $('.tabsEnfants #n_malf_'+indice).val(tempArray['n_malf_'+indice]);
	   $('.tabsEnfants #sat_'+indice).val(tempArray['sat_'+indice]);
	   $('.tabsEnfants #n_sat_'+indice).val(tempArray['n_sat_'+indice]);
	   $('.tabsEnfants #vitk_'+indice).val(tempArray['vitk_'+indice]);
	   $('.tabsEnfants #n_vitk_'+indice).val(tempArray['n_vitk_'+indice]);
	   $('.tabsEnfants #mt_'+indice).val(tempArray['mt_'+indice]);
	   $('.tabsEnfants #n_mt_'+indice).val(tempArray['n_mt_'+indice]);
	   $('.tabsEnfants #msp_'+indice).val(tempArray['msp_'+indice]);
	   $('.tabsEnfants #n_msp_'+indice).val(tempArray['n_msp_'+indice]);
	   $('.tabsEnfants #sc_'+indice).val(tempArray['sc_'+indice]);
	   $('.tabsEnfants #n_sc_'+indice).val(tempArray['n_sc_'+indice]);
	   $('.tabsEnfants #reanim_'+indice).val(tempArray['reanim_'+indice]);
	   $('.tabsEnfants #n_reanim_'+indice).val(tempArray['n_reanim_'+indice]);
	   $('.tabsEnfants #collyre_'+indice).val(tempArray['collyre_'+indice]);
	   $('.tabsEnfants #n_collyre_'+indice).val(tempArray['n_collyre_'+indice]);
	   $('.tabsEnfants #vpo_'+indice).val(tempArray['vpo_'+indice]);
	   $('.tabsEnfants #n_vpo_'+indice).val(tempArray['n_vpo_'+indice]);
	   $('.tabsEnfants #antiT_'+indice).val(tempArray['antiT_'+indice]);
	   $('.tabsEnfants #n_antiT_'+indice).val(tempArray['n_antiT_'+indice]);
	   $('.tabsEnfants #bcg_'+indice).val(tempArray['bcg_'+indice]);
	   $('.tabsEnfants #n_bcg_'+indice).val(tempArray['n_bcg_'+indice]);
	   $('.tabsEnfants #anti_hepa_'+indice).val(tempArray['anti_hepa_'+indice]);
	   $('.tabsEnfants #n_anti_hepa_'+indice).val(tempArray['n_anti_hepa_'+indice]);
	   $('.tabsEnfants #autre_vacc_'+indice).val(tempArray['autre_vacc_'+indice]);
	   $('.tabsEnfants #type_autre_vacc_'+indice).val(tempArray['type_autre_vacc_'+indice]);
	   $('.tabsEnfants #n_autre_vacc_'+indice).val(tempArray['n_autre_vacc_'+indice]);
	   $('.tabsEnfants #cranien_'+indice).val(tempArray['cranien_'+indice]);
	   $('.tabsEnfants #cephalique_'+indice).val(tempArray['cephalique_'+indice]);
	   $('.tabsEnfants #brachial_'+indice).val(tempArray['brachial_'+indice]);
	   $('.tabsEnfants #n_perim_'+indice).val(tempArray['n_perim_'+indice]);
	   $('.tabsEnfants #apgar1_'+indice).val(tempArray['apgar1_'+indice]);
	   $('.tabsEnfants #apgar5_'+indice).val(tempArray['apgar5_'+indice]);
	   $('.tabsEnfants #n_apgar_'+indice).val(tempArray['n_apgar_'+indice]);
	   $('.tabsEnfants #consj1j2_'+indice).val(tempArray['consj1j2_'+indice]);
	   
	   

	   
	   
        }
}


function getnv(nombr){
	  var ind=1;
	  for(ind=1;ind<=nombr;ind++){
	   //alert(tempArray['sexe_1']);
	  
	   
	   
	   
	   $('.tabsNv #viv_bien_portant_'+ind).val(nvArray['viv_bien_portant_'+ind]);
	   $('.tabsNv #n_viv_bien_portant_'+ind).val(nvArray['n_viv_bien_portant_'+ind]);
	   $('.tabsNv #viv_mal_form_'+ind).val(nvArray['viv_mal_form_'+ind]);
	   $('.tabsNv #n_viv_mal_form_'+ind).val(nvArray['n_viv_mal_form_'+ind]);
	   $('.tabsNv #malade_'+ind).val(nvArray['malade_'+ind]);
	   $('.tabsNv #n_malade_'+ind).val(nvArray['n_malade_'+ind]);
	   $('.tabsNv #decede_'+ind).val(nvArray['decede_'+ind]);
	   $('.tabsNv #date_deces_'+ind).val(nvArray['date_deces_'+ind]);
	   $('.tabsNv #heure_deces_'+ind).val(nvArray['heure_deces_'+ind]);
	   $('.tabsNv #cause_deces_'+ind).val(nvArray['cause_deces_'+ind]);
   
	   
      }
}
