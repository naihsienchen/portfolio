jQuery(document).ready(function () { 

    //Hides paragraphs on page load
    $('#american').hide();
    $('#asian').hide();
    $('#european').hide();
    $('#latin').hide();

    //Fades paragraphs in and out when header is clicked while hiding other paragraphs
    $('#americanLink').click(function(){
      $('.regionChoice').slideUp(500);
      $('#american').slideDown(500);
    });

    $('#asianLink').click(function(){
        $('.regionChoice').slideUp(500);
        $('#asian').slideDown(500);
    });

    $('#europeanLink').click(function(){
        $('.regionChoice').slideUp(500);
        $('#european').slideDown(500);
    });

    $('#latinLink').click(function(){
        $('.regionChoice').slideUp(500);
        $('#latin').slideDown(500);
    });

    $('#allLink').click(function(){
        $('.regionChoice').slideDown(500);
    });


});