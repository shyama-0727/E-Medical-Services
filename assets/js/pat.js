
function genereatepdf(){
    return confirm('Are You Sure You Want To Download The Prescription');
}
function bill(){
    return confirm('Are You Sure You Want To Pay The Bill');
}
function checkcancel(){
    return confirm('Are You Sure You Want Cancel Your Appointment');
}

function validatedate(){    
    today = new Date();
    var dd = today.getDate();
    var mm = today.getMonth()+1; //As January is 0.
    var yy = today.getFullYear();
    var  e = document.getElementById('date');
    var  dateformat = e.value.split('-');
    var  cin=dateformat[2];
    var  cinmonth=dateformat[1];
    var  cinyear=dateformat[0];
    if (yy==cinyear && mm==cinmonth && dd<=cin) { 
    return true;
    }
    else if(yy<cinyear){
        return true;
    }
    else if(mm<cinmonth && yy<=cinyear){
        return true;
    }else {    
        alert("Please select valid appointment date from today");
        e.value ='';
    }    
}
function my_fun(str) {
  // alert('doctor')
    //console.log(str);
    if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    }
    else
    {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function(){
    if (this.readyState==4 && this.status==200) {
        document.getElementById('doctid').innerHTML = this.responseText;
    }
    }
    xmlhttp.open("GET","partials/patient_db.php?select_doc="+str, true);
    xmlhttp.send();

}
function select_depart(str) {
  // alert('department');
    //console.log(str);
    if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    }
    else
    {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function(){
    if (this.readyState==4 && this.status==200) {
        document.getElementById('fees').innerHTML = this.responseText;
    }
    }
    xmlhttp.open("GET","../admin/partials/admin_db.php?select_depart="+str, true);
    xmlhttp.send();

}
function select_time(str) {
  // alert('time');
    //console.log(str);
    if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    }
    else
    {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function(){
    if (this.readyState==4 && this.status==200) {
        document.getElementById('apptime').innerHTML = this.responseText;
    }
    }
    xmlhttp.open("GET","partials/patient_db.php?select_time="+str, true);
    xmlhttp.send();

}

/** Functions for Panel book */
function get_doctors(dept){
    if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    }
    else
    {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }

    xmlhttp.onreadystatechange = function(){
        if (this.readyState==4 && this.status==200) {

            jsonResp = JSON.parse(this.responseText)['data'];

            document.getElementById('panel_doc_emailid').innerHTML = jsonResp['dr_list'];
            document.getElementById('panel_co_doc_emailid').innerHTML = jsonResp['all_dr_list'];
            $('#panel_co_doc_emailid').select2();
        }
    }
    xmlhttp.open("GET","../patient/partials/pat_panel.php?select_dept="+dept, true);
    xmlhttp.send();


}

function getDrFees()
{
    let hostDr = document.getElementById("panel_doc_emailid").value;
    let selectedDrs = $('#panel_co_doc_emailid').select2('val');
    selectedDrs.push(hostDr);

    let reqData = {
        drs: selectedDrs        
    };

    if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    }
    else
    {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }

    xmlhttp.onreadystatechange = function(){
        if (this.readyState==4 && this.status==200) {
            console.log(this.responseText);
            jsonResp = JSON.parse(this.responseText)['data'];
            document.getElementById("panel_fees").value = jsonResp['total_fees'];
            document.getElementById('panel_time').innerHTML = jsonResp['time_slot'];
        }
    }
    xmlhttp.open("GET","../patient/partials/pat_panel.php?drs=" + JSON.stringify(reqData), true);
    xmlhttp.send();

}
