function creerLalisteComplication ($listeDesElements) {
    	var index = $("Complication").length; 
			        $liste = "<div id='Complication_"+(index+1)+"'>"+
				             "<Complication>"+
				             "<table class='table table-bordered' id='Cause' style='margin-bottom: 0px; width: 100%;'>"+
                             "<tr style='width: 100%;'>" +
                             
                             "<th style='width: 4%;'>"+
                             "<label style='width: 100%; margin-top: 10px; margin-left: 5px; font-weight: bold; font-family: police2; font-size: 14px;' >"+(index+1)+"<span id='element_label'></span></label>" +
                             "</th >"+
                             
                             "<th id='SelectComp_"+(index+1)+"' style='width: 28%;'>"+
                             "<select style='width: 100%; margin-top: 3px; margin-bottom: 0px; font-size: 13px;' name='comp_name_"+(index+1)+"' id='comp_name_"+(index+1)+"'>"+
			                 "<option value=''> -- S&eacute;l&eacute;ctionner une Cause-- </option>";
                             for(var i = 1 ; i < $listeDesElements.length ; i++){
                            	 if($listeDesElements[i]){
                    $liste +="<option value='"+i+"'>"+$listeDesElements[i]+"</option>";
                            	 }
                             }   
                    $liste +="</select>"+                           
                             "</th>"+
                             
                             "<th id='noteComp_"+(index+1)+"'  style='width: 59%;'  >"+
                             "<input name='noteComp_"+(index+1)+"' id='notesComp_"+(index+1)+"' type='text' style='width: 100%; margin-top: 3px; height: 30px; margin-bottom: 0px; font-size: 15px; padding-left: 10px;' >" +
                             "</th >"+
                             
                             "<th id='iconeComp_supp_vider' style='width: 9%;'  >"+
                             "<a id='supprimer_comp_selectionne_"+ (index+1) +"'  style='width:50%;' >"+
                             "<img class='supprimerComp' style='margin-left: 5px; margin-top: 10px; cursor: pointer;' src='../images/images/sup.png' title='supprimer' />"+
                             "</a>"+
                             
                             "<a id='vider_comp_selectionne_"+ (index+1) +"'  style='width:50%;' >"+
                             "<img class='viderComp' style='margin-left: 15px; margin-top: 10px; cursor: pointer;' src='../images_icons/gomme.png' title='vider' />"+
                             "</a>"+
                             "</th >"+
                             "</tr>" +
                             "</table>" +
                             "</Complication>" +
                             "</div>"+
                             
                             
                             "<script>"+
                                "$('#supprimer_comp_selectionne_"+ (index+1) +"').click(function(){ " +
                                		"supprimer_comp_selectionne("+ (index+1) +"); });" +
                                				
                                "$('#vider_comp_selectionne_"+ (index+1) +"').click(function(){ " +
                                		"vider_comp_selectionne("+ (index+1) +"); });" +
                             "</script>";
                    
                    //AJOUTER ELEMENT SUIVANT
                    $("#Complication_"+index).after($liste);
                    
                    //CACHER L'ICONE AJOUT QUAND ON A CINQ LISTES
                    if((index+1) == 6){
                    	$("#ajouter_comp").toggle(false);
                    }
                    
                    //AFFICHER L'ICONE SUPPRIMER QUAND ON A DEUX LISTES ET PLUS
                    if((index+1) == 2){
                    	$("#supprimer_comp").toggle(true);
                    }
}

//NOMBRE DE LISTE AFFICHEES
function nbListeComp () {
	return $("Complication").length;
}


//SUPPRIMER LE DERNIER ELEMENT
$(function () {
	//Au début on cache la suppression
	$("#supprimer_comp").click(function(){
		//ON PEUT SUPPRIMER QUAND C'EST PLUS DE DEUX LISTE
		if(nbListeComp () >  1){$("#Complication_"+nbListeComp ()).remove();}
		//ON CACHE L'ICONE SUPPRIMER QUAND ON A UNE LIGNE
		if(nbListeComp () == 1) {
			$("#supprimer_comp").toggle(false);
			$(".supprimerComp" ).replaceWith(
			  "<img class='supprimerComp' style='margin-left: 5px; margin-top: 10px;' src='../images/images/sup2.png' />"
			);
		}
		//Afficher L'ICONE AJOUT QUAND ON A CINQ LIGNES
		if((nbListeComp()+1) == 6){
			$("#ajouter_comp").toggle(true);
		}    
		Event.stopPropagation();
	});
});


//FONCTION INITIALISATION (Par défaut)
function partDefautComplication (Liste, n) { 
	var i = 0;
	for( i ; i < n ; i++){
		creerLalisteComplication(Liste);
	}
	if(n == 1){
		$(".supprimerComp" ).replaceWith(
				"<img class='supprimerComp' style='margin-left: 5px; margin-top: 10px;' src='../images/images/sup2.png' />"
			);
	}
	$('#ajouter_comp').click(function(){ 
		creerLalisteComplication(Liste);
		if(nbListeComp() == 2){
		$(".supprimerComp" ).replaceWith(
				"<img class='supprimerComp' style='margin-left: 5px; margin-top: 10px; cursor: pointer;' src='../images/images/sup.png' title='Supprimer' />"
		);
		}
	});

	//AFFICHER L'ICONE SUPPRIMER QUAND ON A DEUX LISTES ET PLUS
    if(nbListeComp () > 1){
    	$("#supprimer_comp").toggle(true);
    } else {
    	$("#supprimer_comp").toggle(false);
      }
}

//SUPPRIMER ELEMENT SELECTIONNER
function supprimer_comp_selectionne(id) { 

	for(var i = (id+1); i <= nbListeComp(); i++ ){
		var element = $('#comp_name_'+i).val();
		$("#SelectComp_"+(i-1)+" option[value='"+element+"']").attr('selected','selected');
		
		var note = $('#noteComp_'+i+' input').val();
		$("#noteComp_"+(i-1)+" input").val(note);
	}

	if(nbListeComp() <= 2 && id <= 2){
		$(".supprimerComp" ).replaceWith(
			"<img class='supprimerComp' style='margin-left: 5px; margin-top: 10px;' src='../images/images/sup2.png' />"
		);
	}
	if(nbListeComp() != 1) {
		$('#Complication_'+nbListeComp()).remove();
	}
	if(nbListeComp() == 1) {
		$("#supprimer_comp").toggle(false);
	}
	if((nbListeComp()+1) == 6){
		$("#ajouter_comp").toggle(true);
	}
   
}

//VIDER LES CHAMPS DE L'ELEMENT SELECTIONNER
function vider_comp_selectionne(id) {
	$("#SelectComp_"+id+" option[value='']").attr('selected','selected');
	$("#noteComp_"+id+" input").val("");
}

//CHARGEMENT DES ELEMENTS SELECTIONNES POUR LA MODIFICATION
//CHARGEMENT DES ELEMENTS SELECTIONNES POUR LA MODIFICATION
//CHARGEMENT DES ELEMENTS SELECTIONNES POUR LA MODIFICATION

//pour maj
function chargementCauseComp (index , element , note) { 
	$("#SelectComp_"+(index+1)+" option[value='"+element+"']").attr('selected','selected'); 
	$("#noteComp_"+(index+1)+" input").val(note);
	

}

var base_url = window.location.toString();
var tabUrl = base_url.split("public");

//VALIDATION VALIDATION VALIDATION
//********************* EXAMEN MORPHOLOGIQUE *****************************
//********************* EXAMEN MORPHOLOGIQUE *****************************
//********************* EXAMEN MORPHOLOGIQUE *****************************

function ValiderComplication(){
$(function(){
	//Au debut on affiche pas le bouton modifier

	//Au debut on affiche le bouton valider
	
	
	$(" #terminer2,#terminer3").click(function (){ 
		//RECUPERATION DES DONNEES DU TABLEAU
		var id_cons = $('#id_cons').val();
		var comp = [];
		var notesComp = [];
		for(var i = 1, j = 1; i <= nbListeComp(); i++ ){
			if($('#comp_name_'+i).val()) {
				comp[j] = $('#comp_name_'+i).val();
				notesComp[j] = $('#noteComp_'+i+' input').val();
				j++;
			}
		}
		
		$.ajax({
	        type: 'POST',
	        url: tabUrl[0]+'public/accouchement/conclusion-complication',
	        data: {'id_cons':id_cons, 'comp': comp, 'noteComp':noteComp},
	        success: function(data) {

	        	
	        	
	            for(var i = 1; i <= nbListeComp(); i++ ){
	    			$('#comp_name_'+i).attr('disabled',true); $('#comp_name_'+i).css({'background':'#f8f8f8'});
	    			$("#noteComp_"+i+" input").attr('disabled',true); $("#noteComp_"+i+" input").css({'background':'#f8f8f8'});
	    		}
	    		$("#controls_complication div").toggle(false);
	    		$("#iconeComp_supp_vider a img").toggle(false);

	    		return false;
	      },
	      error:function(e){console.log(e);alert("Une erreur interne est survenue!");},
	      dataType: "html"
		});
		return false;
	});
	

	

});
}
