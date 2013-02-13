	/*
 * given a form id will make the label the value 
 * and remove it upon entering the field
*/
function label2value(formObj, pre){     
		
        // CSS class names
        // put any class name you want
        // define this in external css (example provided)
        var inactive = "inactive";
        var active = "active";
        var focused = "focused";
        // function
        formObj.find("label").each(function(){          
                
                obj = document.getElementById($(this).attr("for"));
                
                if(($(obj).attr("type") == "text") || (obj.tagName.toLowerCase() == "textarea")){                       
                        $(obj).addClass(inactive);                      
                        var text = $(this).text();
                        if(pre){
                                text = pre+text.replace(/[:\*]/g, "").toLowerCase();
                        } else if (text == "email address:") {
                        		text = "sign up for email updates";
                        } else {
                                text = text.replace(/[:\*]/g, "").toLowerCase();
                        }
                        $(this).css("display","none");                  
                        $(obj).val(text);
                        $(obj).focus(function(){        
                                $(this).addClass(focused);
                                $(this).removeClass(inactive);
                                $(this).removeClass(active);                                                              
                                if($(this).val() == text) $(this).val("");
                        });     
                        $(obj).blur(function(){ 
                                $(this).removeClass(focused);                                                                                                    
                                if($(this).val() == "") {
                                        $(this).val(text);
                                        $(this).addClass(inactive);
                                } else {
                                        $(this).addClass(active);               
                                };                              
                        });                             
                };      
        });
};

function desc2value(formObj, pre){	

	// CSS class names
	// put any class name you want
	// define this in external css (example provided)
	var inactive = "inactive";
	var active = "active";
	var focused = "focused";
	var divs = document.getElementsByTagName("div");
	// function
      //alert("Got "+formObj); 
	formObj.find("label").each(function(){		
		
		obj = document.getElementById($(this).attr("for"));

		if(($(obj).attr("type") == "text") || (obj.tagName.toLowerCase() == "textarea")){			
			$(obj).addClass(inactive);	
			var descObj = document.getElementById(obj.id + "-wrapper");
			for(var i = 0; i < divs.length;i++)
			{
			   if(divs[i] == descObj)
			   {
			     var next = divs[i + 1];
			     var nnext = divs[i + 2];
			   }
			}
			
			if (obj.tagName.toLowerCase() == "textarea") {
				childObj = descObj.childNodes[5].childNodes[0];
				var text = childObj.innerHTML;
			} else {
				childObj = next.childNodes[0];
				var text = childObj.innerHTML;	
			}
			if(pre){
				text = pre+text.replace(/[:\*]/g, "").toLowerCase();
			} else {
				text = text.replace(/[:\*]/g, "").toLowerCase();
		          //alert(text);
                      	}
			
			$(childObj).css("display","none");
			
			$(obj).val(text);
			$(obj).focus(function(){	
				$(this).addClass(focused);
				$(this).removeClass(inactive);
				$(this).removeClass(active);								  
				if($(this).val() == text) $(this).val("");
			});	
			$(obj).blur(function(){	
				$(this).removeClass(focused);													 
				if($(this).val() == "") {
					$(this).val(text);
					$(this).addClass(inactive);
				} else {
					$(this).addClass(active);		
				};				
			});				
		};	
	});
};
// on load
$(document).ready(function(){
	//desc2value($("#webform-client-form-63", null));
	//desc2value($("#webform-client-form-64", null));
    label2value($("#search-theme-form", null)); 
    label2value($("#mailchimp_subscribe_anon_form_f8e2cf1f63", null));
    //$("input#edit-submit-1").toLowerCase();
    $("div.uc-option-image-preloaded").show();
    $("img.uc-option-image").click(function(){
        var newcolor = $(this).attr("src");
        $('img.uc-option-image').each(function () {
            if($(this).hasClass("uc-option-image-selected")){
            	$(this).removeClass('uc-option-image-selected');
            } else if ($(this).attr("src") == newcolor){
            	$(this).addClass('uc-option-image-selected');
            };
         
        });
    }); 
    $("div#product_dimensions_detail").hide();
    $("div#product_shipping_info").hide();

    $('a#link_product_overview').click(function(){
    	$('div#product_dimensions_detail').hide();
    	$("div#product_overview").show();
    	$('div#product_shipping_info').hide();
    });
    
    $('a#link_product_dimensions_detail').click(function(){
    	$('div#product_dimensions_detail').show();
    	$("div#product_overview").hide();
    	$('div#product_shipping_info').hide();
    });
    
    $('a#link_product_shipping_info').click(function(){
    	$("div#product_overview").hide();
    	$('div#product_dimensions_detail').hide();
    	$('div#product_shipping_info').show();
    });
});

function mailpage()
{
mail_str = "mailto:?subject=Check out " + document.title;
mail_str += "&body=I thought you might be interested in " + document.title;
mail_str += ". You can view it at, " + location.href;
location.href = mail_str;
}
