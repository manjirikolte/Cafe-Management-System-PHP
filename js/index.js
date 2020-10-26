$(document).ready(function() {
    
    // Menubar toggle
    $(".siderbar_menu li").click(function () {
        $(".siderbar_menu li").removeClass("active");
        $(this).addClass("active");
      });
      
      $(".hamburger").click(function () {
        $(".wrapper").addClass("active");
      });
      
      $(".close, .bg_shadow").click(function () {
        $(".wrapper").removeClass("active");
      });

    // Search Function
    $(".search").keyup(function () {
      var searchTerm = $(".search").val();
      var listItem = $('.results tbody').children('tr');
      var searchSplit = searchTerm.replace(/ /g, "'):containsi('")
      
    $.extend($.expr[':'], {'containsi': function(elem, i, match, array){
          return (elem.textContent || elem.innerText || '').toLowerCase().indexOf((match[3] || "").toLowerCase()) >= 0;
      }
    });
      
    $(".results tbody tr").not(":containsi('" + searchSplit + "')").each(function(e){
      $(this).attr('visible','false');
    });
  
    $(".results tbody tr:containsi('" + searchSplit + "')").each(function(e){
      $(this).attr('visible','true');
    });
  
    var jobCount = $('.results tbody tr[visible="true"]').length;
      $('.counter').text(jobCount + ' item');
  
    if(jobCount == '0') {$('.no-result').show();}
      else {$('.no-result').hide();}
            });
  });