jQuery(document).ready(wp_set);function wp_set(){jQuery("#waypoint").hide();var d={action:"get_wp",zone:jQuery("#zone").val()};jQuery.post(ajax_object.ajax_url,d,function(a){if(a=eval("("+a+")")){jQuery("#waypoint").empty();var c=!0,b;for(b in a)c?(jQuery("<option/>").val("0").text(a[b]).appendTo("#waypoint"),c=!1):jQuery("<option/>").val(a[b]).text(a[b]).appendTo("#waypoint"),"0"==jQuery("#zone").val()?jQuery("#waypoint").hide():jQuery("#waypoint").fadeIn(800)}})};