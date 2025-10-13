$(function(){
    console.log("register.js loaded");
    alert("register.js loaded");

    //hide default form
    $('#step-2').hide();

    //on click of next button
    $('#nextBtn').on('click', function(e){
        e.preventDefault();
        //hide step 1
        $('#step-1').hide();
        //show step 2
        $('#step-2').show();
    })
})