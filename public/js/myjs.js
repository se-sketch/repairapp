// When the user clicks on the button, scroll to the top of the document
function topFunction() {
    //document.body.scrollTop = 0; // For Safari
    document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
} 

function selectOptionId(selector_name, id){

    var selector = document.getElementById(selector_name);
    var arr_option = selector.options;

    for(var x=0; x < arr_option.length; x++){
        if (arr_option[x].value == id) {
            arr_option[x].selected = true;
            return;
        }   
    }
}

function detectMobileDevice()
{
    if( navigator.userAgent.match(/Android/i)
       || navigator.userAgent.match(/webOS/i)
       || navigator.userAgent.match(/iPhone/i)
       || navigator.userAgent.match(/iPad/i)
       || navigator.userAgent.match(/iPod/i)
       || navigator.userAgent.match(/BlackBerry/i)
       || navigator.userAgent.match(/Windows Phone/i)
       )
        return true;

    return false;
}

function getIndentForMobile()
{
    if (!detectMobileDevice()){
        return;
    }

    var div_mobile_indent = document.getElementById("mobile_indent");
    div_mobile_indent.setAttribute('class', 'pt-3');
    
    return;
}

function testElementForm(name, kolsymb)
{
    var input_name = document.getElementById(name);

    if (!input_name){
        console.log(name);
        return false;
    }

    if (input_name.value.length >= kolsymb){

        var input_name_error = document.getElementById(name+"_error");
        input_name_error.innerText = "";

        return true;
    }

    var input_name_error = document.getElementById(name+"_error");
    input_name_error.innerText = "Укажите "+name+" (минимум "+kolsymb+" символов)!";

    return false;
}

function drag_kod_in_parenthesizes(string_value){
    var pattern = /\(\d+\)/;
    var result_arr = string_value.match(pattern);

    if (!result_arr){
        return '';
    }

    if (result_arr.length == 0){
        return '';
    }
    street_id = result_arr[0];

    pattern = /\d+/;
    result_arr = street_id.match(pattern);
    if (result_arr.length == 0){
        return '';
    }
    street_id = result_arr[0];  

    return street_id;
}

function nomenclature_changed()
{
    name = document.getElementById('pickup').value;

    var kod = drag_kod_in_parenthesizes(name);
    kod = kod.trim();
    if (!kod){
        return;
    }

    var pos = name.indexOf(")");
    var result = name.substring(pos+1).trim();

    var tr_id = 'tr_id_'+kod;
    var html_tr_id = document.getElementById(tr_id);
    if (html_tr_id){
        document.getElementById('pickup').value = '';
        return;
    }

    var el_qty = document.createElement("input");
    el_qty.setAttribute('type', 'number');
    el_qty.setAttribute('step', 0.001);
    el_qty.setAttribute('id', "qty_"+kod);
    el_qty.setAttribute('name', "qtys["+kod+"][qty]");
    el_qty.setAttribute('min', 0.001);
    el_qty.setAttribute('required', true);
    //el_qty.setAttribute('value', );

    var el_button = document.createElement("button");
    el_button.setAttribute('type', 'button');
    el_button.setAttribute('class', "btn btn-outline-danger btn-sm");
    el_button.setAttribute('onclick', "return this.parentNode.parentNode.remove();");
    el_button.appendChild(document.createTextNode("X"));



    var table = document.getElementById("doc_tbody");

    var num_index = table.childElementCount;

    // Create an empty <tr> element and add it to the 1st position of the table:
    var row = table.insertRow(num_index);
    row.setAttribute('id', tr_id);

    // Insert new cells (<td> elements) at the 1st and 2nd position of the "new" <tr> element:
    var cell1 = row.insertCell(0);
    var cell2 = row.insertCell(1);
    var cell3 = row.insertCell(2);
    var cell4 = row.insertCell(3);

    // Add some text to the new cells:
    cell1.innerHTML = kod;
    cell2.innerHTML = result;
    cell3.appendChild(el_qty);
    cell4.appendChild(el_button);

    document.getElementById('pickup').value = '';
}

function validateFormWriteOff(){

    var fl_filled = true;

    var object_repair = document.getElementById("object_id");
    if (object_repair){
        if (object_repair.value > 0){
            document.getElementById("object_repair_error").innerText = "";
        }else{
            document.getElementById("object_repair_error").innerText = "Не заполнен объект ремонта!";
            fl_filled = false; 
        }
    }else{
        document.getElementById("object_repair_error").innerText = "Не найден объект ремонта!";
        fl_filled = false; 
    }

    //-------------

    var subdivision = document.getElementById("subdivision_id");
    if (subdivision){
        if (subdivision.value > 0){
            document.getElementById("subdivision_error").innerText = "";
        }else{
            document.getElementById("subdivision_error").innerText = "Не заполнено подразделение!";
            fl_filled = false; 
        }
    }else{
        document.getElementById("subdivision_error").innerText = "Не найдено подразделение!";
        fl_filled = false; 
    }

    //-------------

    var table = document.getElementById("doc_tbody");
    var num_index = table.childElementCount;
    var qtys_error = document.getElementById('qtys_error');

    if (num_index > 0){
        qtys_error.innerText = '';
    }else{
        qtys_error.innerText = 'Табличная часть должна быть заполнена!';
        fl_filled = false;
    }

    return fl_filled;
}

function DeleteRow(tr_id){
    console.log(tr_id);
}



