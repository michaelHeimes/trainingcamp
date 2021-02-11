<div class="container">

    <div class="bread-crumbs custom-bread-crumbs">
        <ul>
            <li><a href="<?= site_url() ?>">Home</a></li>
            <li><?= get_the_title() ?></li>
        </ul>
    </div>


    <div class="title">
        <a href ="https://trainingcamp.com/pricing-schedules/"><h2><?= get_the_title() ?></h2></a>
        <h3  class="word-capitalize">Please select a course of interest</h3> 
    </div>


    <?php
    $tax = 'product_cat';
    $parent_terms = get_terms($tax, array('parent' => 0, 'hide_empty' => 0, 'exclude'=>array(11,12,35)));
    $category_html="";
    if(count($parent_terms)>0){
        $category_html.='<select name="product_category" id="select-1" class="dropdown">';
        $category_html.='<option value="">Certification or Vendor</option>';
        foreach ($parent_terms as $parent_term){
            $child_terms = get_terms($tax, array('parent' => $parent_term->term_id, 'hide_empty' => 1));
            if(count($child_terms)>0){
                $category_html.='<optgroup label="'.$parent_term->name.'">';
                foreach($child_terms as $child_term){
                    $category_html.='<option value="'.$child_term->term_id.'">'.$child_term->name.'</option>';
                }
                $category_html.='</optgroup>';
            }
        }
        $category_html.='</select>';
    }


    $visible_fields=array(
        'full_name'=>array('placeholder'=>'first & last name*','type'=>'text','value'=>''),
        'email'=>array('placeholder'=>'Email Address*','type'=>'email','value'=>''),
        'phone'=>array('placeholder'=>'Phone Number*','type'=>'text','value'=>''),
    );
    $empty=(isset($_COOKIE['full_name']) && isset($_COOKIE['email']) && isset($_COOKIE['phone'])) ? false : true;
    if (!$empty){
        foreach($visible_fields as $name=>$data){
            $visible_fields[$name]['value']=$_COOKIE[$name];
        }
    }
    $empty_field_value=!$empty ? 'yes' : 'no';
    
    if(isset($_COOKIE['full_name'])){
    //echo "<script type=text/javascript>getCourseList()</script>"; 
    ?>
        <script type='text/javascript'>
        $(document).ready(function(){
           //document.getElementById("pricing-form-tab").style.display = "none";
      });

     </script>
     <?php
    }else{
        ?>
        <script type='text/javascript'>
        $(document).ready(function(){
           //document.getElementById("pricing-form-tab").style.display = "block";
      });

     </script>
     <?php
    }


    $disabled='disabled="disabled"';
    $class="not-allowed";
    $one_product_html='';
    if (isset($_GET['product_id']) && is_numeric($_GET['product_id'])){
        $product=wc_get_product($_GET['product_id']);
        $product_name=is_object($product) ? $product->get_name() : '';
        if ($product_name){
            $disabled='';
            $class="";
            $one_product_html='<option value="'.$_GET['product_id'].'" selected="selected">'.$product_name.'</option>';
        }
    }
    ?>


    <div class="tab-wrap">

        <div class="tab-nav">

            <form action="" id="select-product">
                <?php if (isset($_GET['noreq']) && '1'===$_GET['noreq']): ?>

                    <input type="hidden" name="noreq" value="yes">

                <?php else: ?>
                <div  id="pricing-form-tab" class="container" style="display:none;" >
                    <?php foreach($visible_fields as $name=>$data): ?>
                        <p class="form-row form-row-wide">
                            <input type="<?= $data['type'] ?>" id="<?= $name ?>" title=" " name="<?= $name ?>" class="form-control" placeholder="<?= $data['placeholder'] ?>" value="<?= $data['value'] ?>" required>
                            <label for="<?= $name ?>"><?= $data['placeholder'] ?></label>
                        </p>
                    <?php endforeach ?>
                    </div>

                    <input type="hidden" name="kvalue" value="<?= rand(1,10) ?>">

                    <input type="hidden" name="user_ip" value="<?= $_SERVER['REMOTE_ADDR'] ?>">

                    <input type="hidden" name="from_cookies" value="<?= $empty_field_value ?>">

                    <input type="hidden" name="noreq" value="yes">

                <?php endif; ?>

                <div class="form-row pricing-category-hidden">
                    <?= $category_html ?>
                </div>

                <div class="form-row <?= $class ?>">
                    <select name="products" id="select-2" class="dropdown" <?= $disabled ?> title="Please choose a course!" required>
                        <option value="">Course of interest</option>
                        <?= $one_product_html ?>
                    </select>
                </div>

                <div class="form-row <?= $class ?>">
                    <button type="submit" class="btn btn-blue" <?= $disabled ?>>Show Schedule & Pricing</button>
                </div>

                <div class="errors_wrap"></div>
            </form>

        </div>

        <?php /* ?>
        <form method="post" action="/cart/" class="add_to_cart_form">
            <button type="submit" class="single_add_to_cart_button button alt btn btn-blue">Add to cart</button>
            <input type="hidden" name="add-to-cart" value="245">
            <input type="hidden" name="product_id"  value="245">
            <input type="hidden" name="variation_id" class="variation_id" value="251">
            <input type="hidden" name="attribute_pa_location" value="bashkill-pa">
        </form>
        <?php */ ?>

        <div class="pricing-schedules" id="pricing-schedules">
            <div class="shop-app"></div>
        </div>

    </div>
    
    
</div>
<script>
function sortList() {
    $("#date-picker-container").parent().css({"display": "none"});
  var list, i, switching, b, shouldSwitch;
  list = document.getElementById("location-array");
  switching = true;
  /*Make a loop that will continue until
  no switching has been done:*/
  while (switching) {
    //start by saying: no switching is done:
    switching = false;
    b = list.getElementsByTagName("LI");
    //Loop through all list-items:
    for (i = 0; i < (b.length - 1); i++) {
      //start by saying there should be no switching:
      shouldSwitch = false;
      /*check if the next item should
      switch place with the current item:*/
      if (b[i].getElementsByTagName("label")[0].innerText.toLowerCase() > b[i+1].getElementsByTagName("label")[0].innerText.toLowerCase()) {
        /*if next item is alphabetically
        lower than current item, mark as a switch
        and break the loop:*/
        shouldSwitch = true;
        break;
      }
    }
    if (shouldSwitch) {
      /*If a switch has been marked, make the switch
      and mark the switch as done:*/
      b[i].parentNode.insertBefore(b[i + 1], b[i]);
      switching = true;
    }
  }
}


function convertDate(d) {
  var p = d.split("/");
  return +(p[0]+p[1]+p[2]);
}

function sortByDate() {
  var tbody = document.querySelector(".content-table table tbody");
  // get trs as array for ease of use
  var rows = [].slice.call(tbody.rows);
  if(rows.length>1){
  rows.sort(function(a,b) {  
      a =  a.querySelector("time");
          
    var dateA = new Date(a.innerText);
    a.dateTime = getFormattedDate(dateA);
    a.innerText = getFormattedDate(dateA);
    
    b =  b.querySelector("time");
    var dateB = new Date(b.innerText)
    b.dateTime = getFormattedDate(dateB);
    b.innerText = getFormattedDate(dateB);
    return dateA - dateB;
  });
  
   var index = 0;
   var deletePostion = [];
   rows.forEach(function(v) {
       
       var timebegin = v.querySelector("td table tbody tr ").cells[0].querySelector("time")
        var begindate = new Date(timebegin.innerText);
        timebegin.dateTime = getFormattedDate(begindate);
        timebegin.innerText = getFormattedDate(begindate);
       
        var time = v.querySelector("td table tbody tr ").cells[1].querySelector("time")
        var dateA = new Date(time.innerText);
        time.dateTime = getFormattedDate(dateA);
        time.innerText = getFormattedDate(dateA);
        var now = new Date();
        var dt1 = Date.parse(now),
       dt2 = Date.parse(dateA);
       if (dt2 < dt1) {            
            deletePostion[index] = index;
       }
        
        tbody.appendChild(v); // note that .appendChild() *moves* elements        
        index = index + 1;           
   });

//    var tempRows =  document.querySelector(".content-table table tbody").rows;
//    var arr = [].slice.call(tempRows);

//    if(deletePostion.length>0){
//         var i;
//         arr.splice(0, deletePostion.length);
        
//    }
//     rows = arr;

//     var node =document.querySelector(".content-table table tbody");
//     while (node.hasChildNodes()) {
//         node.removeChild(node.lastChild);       
//     }

//     if(rows.length>0){
//         for (var i = 0; i < rows.length; i++){
//             document.querySelector(".content-table table tbody").insertRow(i).innerHTML = rows[i].innerHTML;        
//         }
//     }else{
//         document.querySelector(".content-table table tbody").insertRow(i).innerHTML = "Available events are not found";
//     }    
    
   function getFormattedDate(date) {
        var year = date.getFullYear();

        var month = (1 + date.getMonth()).toString();
        month = month.length > 1 ? month : '0' + month;

        var day = date.getDate().toString();
        day = day.length > 1 ? day : '0' + day;
        
        return month + '/' + day + '/' + year;
        }
    }
}


function callAjaxToDeleteVariation(jsonData) {
    jQuery.ajax({
        type: "POST",
        url: "/wp-admin/admin-ajax.php",
        data: {
            action: 'delete_product_variation_ajax',            
            json_data: jsonData
        },
        dataType:'json',
        success: function (output) {
           //console.log(output);
        }
        });    
}

	
function sortTable(json) {
console.log(JSON.stringify(json));
//for(var i = 0; i < json.length; i++) {
if(json.length>0){
callAjaxToDeleteVariation(json); 
}

for (i = 0, len = json.length; i < len; i++) { 
var obj = json[i];
//json.splice(1,1)

var selectedDate = new Date(obj.end_date);
var now = new Date();
now.setHours(0,0,0,0);
if (selectedDate < now) {
document.cookie="product_variation_id="+json[i].id; 
json.splice(i, 1);
//delete json[i]; 
i--;
len--; 
}else{
obj.start_date = formattedDate(obj.start_date);
obj.end_date = formattedDate(obj.end_date);
} 
}

function formattedDate(dateString) {
var date = new Date(dateString);
var year = date.getUTCFullYear();

var month = (1 + date.getUTCMonth()).toString();
month = month.length > 1 ? month : '0' + month;

var day = date.getUTCDate().toString();
day = day.length > 1 ? day : '0' + day;

return month + '/' + day + '/' + year;
} 

var rows = json; 
rows.sort(function(a,b) { 
var dateA = new Date(a.start_date);
a.dateTime = formattedDate(dateA); 

var dateB = new Date(b.start_date)
b.dateTime = formattedDate(dateB);

var nameA = a.attributes[0].option.toLowerCase(); 
var nameB = b.attributes[0].option.toLowerCase();	

var diff = dateA - dateB;
if(diff === 0) {

diff = nameA.localeCompare(nameB);	
}	

return diff;
}); 

return rows;
//document.getElementById("headerBeginDate").addEventListener("click", function(){ alert("Hello World!"); }); 
}

function sortTableByHeader(f,n){
    //var rows = $('#mytable tbody  tr').get();

    var tbody = document.querySelector(".content-table table tbody");
    // get trs as array for ease of use
    var rows = [].slice.call(tbody.rows);
 if(rows.length>1){
    rows.sort(function(a, b) {
                
        var A = a.querySelector("time");
        var B = b.querySelector("time");

         var dateA = new Date(A.innerText);
         var dateB = new Date(B.innerText);
 if(A.innerText.localeCompare(B.innerText) === 0){
                
                var A = a.querySelector("td table tbody tr ").cells[2]
                var B = b.querySelector("td table tbody tr ").cells[2]

                var dateA = A.innerText;
                var dateB = B.innerText;            
                return dateA.charAt(0).localeCompare(dateB.charAt(0));
                }else{
        if(dateA < dateB) {
            return -1*f;
        }
        if(dateA > dateB) {
            return 1*f;
        }
        return 0;
                }
    });
 rows.forEach(function(v) {
        tbody.appendChild(v);        
   });
 }
}
    var f_sl = 1; // flag to toggle the sorting order
    var f_nm = 1; // flag to toggle the sorting order
    var f_lo = 1;
    var f_al = 1;

    function headerBeginDateSort(){
        document.getElementById("headerBeginDate").addEventListener("click", function(){ 
                  
                f_sl *= -1; // toggle the sorting order
                document.getElementById("headerEndDatei").className = "";
                document.getElementById("headerLocationi").className = "";
                document.getElementById("headerAvailablei").className = "";
                if(f_sl>0){
                    document.getElementById("headerBeginDatei").className = "down";
                }else{
                    document.getElementById("headerBeginDatei").className = "up";
                }
                var n = $(this).prevAll().length;
                sortTableByHeader(f_sl,n);
        });         
    }

    function headerEndDateSort(){
            document.getElementById("headerEndDate").addEventListener("click", function(){ 
                        
                    f_nm *= -1; // toggle the sorting order
                    document.getElementById("headerBeginDatei").className = "";
                    document.getElementById("headerLocationi").className = "";
                    document.getElementById("headerAvailablei").className = "";
                    if(f_nm>0){
                        document.getElementById("headerEndDatei").className = "down";
                    }else{
                        document.getElementById("headerEndDatei").className = "up";
                    }
                    var n = $(this).prevAll().length;
                    sortTableByEndDate(f_nm,n);
            });         
    }
  
    function sortTableByEndDate(f,n){
            //var rows = $('#mytable tbody  tr').get();
            var tbody = document.querySelector(".content-table table tbody");
            // get trs as array for ease of use
            var rows = [].slice.call(tbody.rows);
 if(rows.length>1){
            rows.sort(function(a, b) {

                var A = a.querySelector("td table tbody tr ").cells[1].querySelector("time");
                var B = b.querySelector("td table tbody tr ").cells[1].querySelector("time")

                var dateA = new Date(A.innerText);
                var dateB = new Date(B.innerText);

                if(A.innerText.localeCompare(B.innerText) === 0){
                
                var A = a.querySelector("td table tbody tr ").cells[2]
                var B = b.querySelector("td table tbody tr ").cells[2]

                var dateA = A.innerText;
                var dateB = B.innerText;            
                return dateA.charAt(0).localeCompare(dateB.charAt(0));
                }else{
                if(dateA < dateB) {
                    return -1*f;
                }
                if(dateA > dateB) {
                    return 1*f;
                }
                return 0;
            }
            });
        rows.forEach(function(v) {
                tbody.appendChild(v);        
        });
 }
    }

      function headerLocationSort(){
        document.getElementById("headerLocation").addEventListener("click", function(){ 
                  
                f_lo *= -1; // toggle the sorting order
                document.getElementById("headerEndDatei").className = "";
                document.getElementById("headerBeginDatei").className = "";
                document.getElementById("headerAvailablei").className = "";
                if(f_lo>0){
                    document.getElementById("headerLocationi").className = "down";
                }else{
                    document.getElementById("headerLocationi").className = "up";
                }
                var n = $(this).prevAll().length;
                sortTableByLocation(f_lo,n);
        });         
    }
    

    function sortTableByLocation(f,n){
            //var rows = $('#mytable tbody  tr').get();
            var tbody = document.querySelector(".content-table table tbody");
            // get trs as array for ease of use
            var rows = [].slice.call(tbody.rows);
 if(rows.length>1){
            rows.sort(function(a, b) {

                var A = a.querySelector("td table tbody tr ").cells[2]
                var B = b.querySelector("td table tbody tr ").cells[2]

                var dateA = A.innerText;
                var dateB = B.innerText;

                if(dateA < dateB) {
                    return -1*f;
                }
                if(dateA > dateB) {
                    return 1*f;
                }
                return 0;
            });
        rows.forEach(function(v) {
                tbody.appendChild(v);        
        });
 }
    }

    function headerAvailableSort(){
        document.getElementById("headerAvailable").addEventListener("click", function(){ 
                  
                f_al *= -1; // toggle the sorting order
                document.getElementById("headerEndDatei").className = "";
                document.getElementById("headerBeginDatei").className = "";
                document.getElementById("headerLocationi").className = "";
                if(f_al>0){
                    document.getElementById("headerAvailablei").className = "down";
                }else{
                    document.getElementById("headerAvailablei").className = "up";
                }
                var n = $(this).prevAll().length;
                sortTableByAvailable(f_al,n);
        });         
    }
    

    function sortTableByAvailable(f,n){
            //var rows = $('#mytable tbody  tr').get();
            var tbody = document.querySelector(".content-table table tbody");
            // get trs as array for ease of use
            var rows = [].slice.call(tbody.rows);
 if(rows.length>1){
            rows.sort(function(a, b) {

                var A = a.querySelector("td table tbody tr ").cells[3]
                var B = b.querySelector("td table tbody tr ").cells[3]

                var dateA = A.innerText;
                var dateB = B.innerText;

                if(dateA < dateB) {
                    return -1*f;
                }
                if(dateA > dateB) {
                    return 1*f;
                }
                return 0;
            });
        rows.forEach(function(v) {
                tbody.appendChild(v);        
        });
 }
    }


</script>
