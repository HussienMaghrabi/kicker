<template>
<div>
    <div class="container">
        <div class="column1">
            <div class="item1">
               <i class="fas fa-tag i_1"></i>
                 <p class="p_1">DEPARTMENTS<br>0<br>Department</p>

            </div>
            <div class="item2">
                <i class="far fa-comment i_2"></i>
                   <p class="p_2">ATTENDEES TODAY<br>0<br>Employee</p>

            </div>
        </div>
        <div class="column2">
            <div class="item3">
                <i class="far fa-heart i_3"></i>
                <p class="p_3">EMPLOYEES<br>0<br>Employee</p>
            </div>
            <div class="item4">
                <i class="fas fa-tasks i_4"></i>
                <p class="p_4">PENDING APPROVAL<br>0<br>Request</p>
            </div>
        </div>
        <hr>
       <div>
            <p style="font-weight:bold">Happiness Indicator:</p>
           
                <!-- <i class="far fa-smile-beam i_5"></i>
                <i class="far fa-meh i_6"></i>
                <i class="far fa-frown i_7"></i> -->
              <div class="happy">  <img class="img_1" src="/images/happy.svg" />  </div>
               <div class="middle"> <img class="img_2"  src="/images/middle.svg" /></div>
              <div class="sad">  <img class="img_3"  src="/images/sad.svg" /> </div>
              <div> <span class="span_1" style="margin-left:3.2%;color:#31b403">0.00%</span><span class="span_2" style="margin-left:12.4%;color:#30539A">0.00%</span><span class="span_3" style="margin-left:13.5%;color:#ff494a">0.00%</span></div>
             
       </div>
<div class="inst">
    <p style="padding:10px">    Usage Instructions:</p>
    <ul style="list-style-type:disc;" class="inst_list">
        <li>Firstly pLease fill you company data from Account Setting tab..</li>
        <li>Add your company departments from Departments tab..</li>
        <li>Then add your employees from Employees tab..</li>
        <li>Each employee can login to the system (Web Version) from this.<a> Link.</a></li>
        <li>Employee also can Download Application.<a> Android Version</a> , <a>iOS Version.</a></li>
        <li>Admin can review all Check-in Summary , Complaints , Vacations , Leaves Permissions and set Annual Vacations from this control panel.</li>
    </ul>
</div>
    <hr>

    </div>
</div>
</template>
<style>
.column1
{
    display: inline-block;
    width: 40%;
}
.item1
{
    width: 80%;
    height: 90px;
    background-color: #f39c11;
    box-shadow: 0 1px 1px rgba(0,0,0,0.1);
    border-radius: 2px;
    margin-bottom: 15px;
    color: white
}
.item2
{
    width: 80%;
    height:90px;
    background-color: #01c0ef;
    box-shadow: 0 1px 1px rgba(0,0,0,0.1);
    border-radius: 2px;
    margin-bottom: 15px;
    color: white
}
.column2
{
     display: inline-block;
    width: 40%;
}
.item3
{
    width: 80%;
    height: 90px;
    background-color:#00a65a;
    box-shadow: 0 1px 1px rgba(0,0,0,0.1);
    border-radius: 2px;
    margin-bottom: 15px;
    color: white
}
.item4
{
    width: 80%;
    height: 90px;
    background-color: #dd4b39;
    box-shadow: 0 1px 1px rgba(0,0,0,0.1);
    border-radius: 2px;
    margin-bottom: 15px;
    color: white
}
.i_1
{
    width: 20%;
    height: 100%;
    background-color:#c37d0d;
    padding: 5px;
    text-align: center;
    vertical-align: center;
    padding-top: 30px;
    font-size: 30px


}
.p_1
{
    
    margin-left: 97px;
    margin-top: -83px;
    font-size: 14px;
    padding: 2px
}
.i_2
{
    width: 20%;
    height: 100%;
    background-color:#039ac0;
    padding: 5px;
    text-align: center;
    vertical-align: center;
    padding-top: 30px;
    font-size: 30px

}
.p_2
{
    
    margin-left: 97px;
    margin-top: -83px;
    font-size: 14px;
    padding: 2px
}
.i_3
{
     width: 20%;
    height: 100%;
    background-color:#008547;
    padding: 5px;
    text-align: center;
    vertical-align: center;
    padding-top: 30px;
    font-size: 30px

}
.p_3
{
    
    margin-left: 97px;
    margin-top: -83px;
    font-size: 14px;
    padding: 2px
}
.i_4
{
    width: 20%;
    height: 100%;
    background-color:#b13b2c;
    padding: 5px;
    text-align: center;
    vertical-align: center;
    padding-top: 30px;
    font-size: 30px

}
.p_4
{
    margin-left: 97px;
    margin-top: -83px;
    font-size: 14px;
    padding: 2px
}
hr
{
    background-color: red
}
.i_5
{
    color: #30b40f;
    font-size: 30px;
    
}
.happy
{
     height: 130px;
    width: 130px;
    border-radius: 50%;
    margin: 10px auto;
    border: 3px solid #31b403;
    text-align: center;
    display: inline-block;
    margin-right: 80px
}
.img_1
{
        margin-top: 27px;
    width: 50%;
}
.middle
{
     height: 130px;
    width: 130px;
    border-radius: 50%;
    margin: 10px auto;
    border: 3px solid #30539A;
    text-align: center;
    display: inline-block;
    margin-right: 80px
}
.img_2
{
     margin-top: 27px;
    width: 50%;
}
.sad
{
     height: 130px;
    width: 130px;
    border-radius: 50%;
    margin: 10px auto;
    border: 3px solid #ff494a;
    text-align: center;
    display: inline-block;
    margin-right: 80px
}
.img_3
{
     margin-top: 27px;
    width: 50%;
}
.inst
{
    margin-top: 30px
}
.inst_list
{
  margin-left: 50px
}
 @media (max-width: 767px)
 {
     .column1
     {
         width: 100%;
     }
     .column2
     {
          width: 100%;
     }
     .happy,.sad,.middle
     {
         margin-left:109px;
         margin-top: 10px
     }
     .span_1
     {
        margin-left: 40.2% !important; 
        top: 46%;
        position: absolute;
     }
     .span_2
     {
        margin-left: 41.4% !important;
        position: absolute;
        top: 56.7%;
     }
     .span_3
     {
        margin-left: 41.5% !important; 
         position: absolute;
           top: 68%;
}
     }
 
</style>