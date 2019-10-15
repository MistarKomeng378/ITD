var print_msg = "Please wait while we create your document" ;


var print_components = {
  iframe: function(p_url){
    return '<iframe id="printPage" name="printPage" src='+p_url+' style="position:absolute;top:0px; left:0px;width:0px; height:0px;border:0px;overfow:none; z-index:-1"></iframe>';
  },
  messageBox: function(p_message){
    return "<div id='printMessageBox' style='\
      z-index:8002; \
      position:fixed;\
      top:50%; left:50%;\
      text-align:center;\
      margin: -60px 0 0 -155px;\
      width:310px; height:120px; font-size:16px; padding:10px; color:#222; font-family:helvetica, arial;\
      opacity:0;\
      background:#fff url(" + uri + "img/print_icon.gif) center 40px no-repeat;\
      border: 6px solid #555;\
      border-radius:8px; -webkit-border-radius:8px; -moz-border-radius:8px;\
      box-shadow:0px 0px 10px #888; -webkit-box-shadow:0px 0px 10px #888; -moz-box-shadow:0px 0px 10px #888'>\
      "+p_message+"</div>";
  }
};

function loadPrintDocument(p_url){
  $("body").append(print_components.messageBox(print_msg));
  $("#printMessageBox").css("opacity", 0);
  $("#printMessageBox").animate({opacity:1}, 300, function() { print_addIframeToPage(p_url); });
}

function print_addIframeToPage(p_url){

    var url = (p_url) ? p_url : "#";

    if(!$('#printPage')[0]){
      $("body").append(print_components.iframe(url));
      $('#printPage').bind("load",function() {  
          var iframe_contents = $(this).contents().find('body').html();
          if (iframe_contents!='false')
            print_printit();  
          else
          {
            print_unloadMessage(); 
            alert('Document is not printable.');
          }
      })
    }else{
      $('#printPage').attr("src", url);
    }
}

function print_unloadMessage(){
  $("#printMessageBox").delay(1000).animate({opacity:0}, 700, function(){
    $(this).remove();
  });
}

function print_printit(){
  frames["printPage"].focus();
  frames["printPage"].print();
  print_unloadMessage();
}

 