$(document).ready(function() {
    //$('#payment_method_paypal').addClass('active');
    //$('#paypal').addClass('active');
    
    //$('#billing-slider').prop('checked', false);
    //alert("Test");
  
    $( '#billing_country' ).change( function(){ 
        // alert( $('#billing_country').val());
                var data = {
                    'action': 'checkout_states',
                    'data': "countrycode="+$('#billing_country').val()
                };
                
                $.ajax({
                    url: '/wp-admin/admin-ajax.php',
                    data: data,
                    type: 'POST',
                    cache: false,
                    success: function (res) {
                        console.log(res);
                        if(res.success){
                            if(res.states){
                                var keys = Object.keys(res.states);
                                var stateHtml = '<option value="Select">Select a state…</option>';
                                keys.forEach(function(key){
                                    stateHtml = stateHtml+'<option value=\"'+key+'">'+res.states[key]+'</option>'; 
                                });
                                console.log(stateHtml);
                                $('#billing_state').find('option').remove().end().append(stateHtml).val('Select');    
                            }
                            else{
                                $('#billing_state').find('option').remove().end().append('<option value="Select">Select a state…</option>').val('Select');   
                            }
                            
                        }
                        
                    }
                });
    });
    //if($('#billing_country_field').children().length>0)
    //$('#billing_country_field').children().get(1).remove();
    if($('#billing_country_field').children().length>0){
	if (typeof $('#billing_country_field').children().get(1).remove === 'function') {
	  $('#billing_country_field').children().get(1).remove();
	} else {
	  $('#billing_country_field').children().get(1).parentNode.removeChild($('#billing_country_field').children().get(1));
	}
     }
    
  $('.tab-nav a').click(function (e) {                  
        if("PayPal" === $(e.target)[0].innerHTML){        
            $('#payment_method').val("paypal")            
        }else if("Credit Card" === $(e.target)[0].innerHTML){            
            $('#payment_method').val("authorize_net_aim")
        }else if("Purchase Order" === $(e.target)[0].innerHTML){
            $('#payment_method').val("purchaseorder")
        }else if("G.I. Bill" === $(e.target)[0].innerHTML){
            $('#payment_method').val("gibill")
        }else if("Self Fund" === $(e.target)[0].innerHTML){
            $('#payment_method').val("selffund")
        }else if("Check payments" === $(e.target)[0].innerHTML){
            $('#payment_method').val("cheque")
        }
   });
   
   
     if(document.getElementById("training_payment_type")!==null){
    var input = document.getElementById("training_payment_type").value;
    if(input !==null && input !== undefined && input !== '' && input!=='pay_later' && input!=='on'){
        $('#payment_method').val(input);
        $('#billing-slider').click();
        $('#payment_method_'+input).addClass('active');
        $('#'+input).css('display','block');
        
        /*if(input === "cheque"){
            $('.tab-nav a')[1].click()
        }else if(input === "authorize_net_aim"){
            $('.tab-nav a')[2].click()
        }else if(input === "gibill"){
            $('.tab-nav a')[3].click()
        }else if(input === "purchaseorder"){
            $('.tab-nav a')[4].click()
        }else if(input === "selffund"){
            $('.tab-nav a')[5].click()
        }*/
        
        
    }else{
        $('#billing-slider').prop('checked', false);
        $('#payment_method').val("pay_later");
    }
    }
});
